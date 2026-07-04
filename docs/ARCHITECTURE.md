# Architecture Documentation

## 1. Overview

Real State MVC is a hand-rolled implementation of the Model-View-Controller pattern in plain PHP — there is no framework (Laravel, Symfony, etc.) underneath it. All routing, rendering, and data access are implemented directly in the project's own classes (`Router.php`, `models/ActiveRecord.php`).

The application has two audiences:

1. **Public visitors** — browse properties, read the blog, and submit a contact form.
2. **Authenticated staff** — manage properties and sellers through an admin panel guarded by a session-based login.

## 2. Request Lifecycle

```
Browser request
      │
      ▼
public/.htaccess  ──rewrite──▶  public/index.php  (front controller)
      │
      ▼
includes/app.php
  • loads Composer autoloader
  • loads .env via Dotenv
  • connects to MySQL (includes/config/database.php)
  • sets ActiveRecord::$db
      │
      ▼
public/index.php registers routes on a Router instance
      │
      ▼
Router::checkRoute()
  • starts the session
  • reads $_SESSION['login']
  • matches REQUEST_URI + REQUEST_METHOD against registered routes
  • if the URL is in the protected-routes list and there is no session, redirects to '/'
  • otherwise calls the mapped [Controller, method]
      │
      ▼
Controller method
  • reads $_GET / $_POST / $_FILES
  • talks to a Model (ActiveRecord subclass) for persistence
  • calls Router::render($view, $data)
      │
      ▼
Router::render()
  • extracts $data into local variables
  • buffers the view file's output
  • includes views/layout.php, injecting the buffered content
      │
      ▼
HTML response
```

The root project also has its own top-level `.htaccess` that rewrites all non-`public/` requests into the `public/` folder, so the app can be served from the repository root as well as directly from `public/`.

## 3. Layered Architecture

### 3.1 Router (`Router.php`)

A single class holds two associative arrays (`routeGET`, `routePOST`) mapping URL paths to `[Controller::class, 'method']` callables. `checkRoute()` is the dispatcher; `render()` is the view-rendering helper. There is no route-parameter syntax (e.g. `/properties/{id}`) — resource IDs are instead passed via query strings (e.g. `/listing?id=5`) and read manually inside controllers with `checkORedirect()`.

Access control is centralized in `Router::checkRoute()` through a hardcoded `$protected_routes` array, rather than per-route middleware. This is what the commit `4cf7aa7` refers to as the "security method to restrict admin access to unregistered emails" — an unauthenticated visitor hitting any protected URL is redirected to `/`.

### 3.2 Controllers (`controllers/`)

| Controller | Responsibility |
|---|---|
| `PageController` | All public-facing pages: home, about, listings, property detail, blog, blog entry, contact (including sending the email). |
| `PropController` | Admin CRUD for properties, including image upload/resizing. |
| `SellerController` | Admin CRUD for sellers. |
| `LoginController` | Authentication (`login`) and session teardown (`logout`). |

Controllers are stateless: every action is a `public static` method that receives the `Router` instance (to call `render()`) and reads superglobals directly. This keeps the code simple but means controllers are tightly coupled to the HTTP layer and hard to unit test in isolation.

### 3.3 Models (`models/`)

`ActiveRecord` is the shared base class implementing a lightweight Active Record pattern:

- `create()` / `update()` / `save()` / `delete()` — persistence operations.
- `all()` / `get($n)` / `find($id)` — read helpers built on `querySQL()`.
- `attributes()` / `sanitizeData()` — reflect over each subclass's `$columnsDB` to build SQL fragments, escaping values with `mysqli::escape_string`.
- `synchronize($args)` — repopulates an in-memory object from submitted form data (used by the `update` flows).
- `getNextId()` — scans existing IDs in ascending order and returns the first unused integer, so deleted IDs get reused instead of relying on `AUTO_INCREMENT`.

Concrete models (`Admin`, `PropertyDB`, `Sellers`) declare their table name, column list, and `validate()` rules, and add domain-specific behavior (e.g. `Admin::checkPassword()`, `Admin::userAuthentication()`).

### 3.4 Views (`views/`)

Views are plain PHP templates grouped by feature (`auth/`, `pages/`, `properties/`, `sellers/`), plus a single shared `layout.php` that all pages render into. Reusable form fragments (`properties_form.php`, `sellers_form.php`) are shared between the `create` and `update` views for each resource. `includes/templates/` holds the site-wide `header.php`/`footer.php` and additional listing/form partials used across public pages.

### 3.5 Front-end (`src/`)

- `src/scss/` — Sass source, organized into `base/` and `layout/` partials, compiled by Gulp.
- `src/js/app.js` — Vanilla JS handling: dark-mode toggle (based on `prefers-color-scheme`, plus a manual button), the mobile hamburger menu, and dynamically swapping the contact form's "how should we reach you" fields (phone vs. email) based on the visitor's radio button selection.
- `gulpfile.js` — Build pipeline: autoprefixing, concatenation, source maps, minification (Terser for JS, `cssnano` via `gulp-postcss` for CSS), image optimization/WebP conversion, and cache-busting via `gulp-cache`.

## 4. Data Flow Example: Creating a Property

1. Admin visits `/properties/create` (GET) — `PropController::create` renders an empty form with the seller list for the dropdown.
2. Admin submits the form (POST, `multipart/form-data`).
3. `PropController::create` builds a `PropertyDB` instance from `$_POST['property']`, generates a random image filename, and — if a file was uploaded — resizes it to 800×600 with Intervention Image.
4. `PropertyDB::validate()` checks required fields (title, price, description length ≥ 50, bedroom/bathroom/parking counts, seller selection, image).
5. If validation passes, the image is written to `IMAGE_DIRECTORY` and `PropertyDB::save()` calls `create()`, which computes the next available ID and runs an `INSERT` built from the model's `$columnsDB`.
6. On success, the browser is redirected to `/admin?result=1`, where `PropController::index` reloads the full listing and `showNoti()` renders a "Created successfully" banner.

## 5. Authentication Model

- Passwords are stored hashed (`password_hash()`) and verified with `password_verify()` — `Admin::checkPassword()`.
- A successful login sets `$_SESSION['user']` and `$_SESSION['login'] = true`.
- `Router::checkRoute()` treats the presence of `$_SESSION['login']` as the sole authorization check for the protected routes list; there are no roles or permission levels — any authenticated session can access the entire admin panel.
- `LoginController::logout()` clears the session array entirely and redirects to `/`.

## 6. Design Trade-offs Worth Knowing

- **No prepared statements.** Queries are built by string concatenation with values escaped through `mysqli::escape_string`. This is safer than nothing but is more error-prone than parameterized queries — a good candidate for a future refactor.
- **ID recycling instead of relying on `AUTO_INCREMENT`.** `ActiveRecord::getNextId()` scans for gaps in existing IDs. This keeps IDs low and sequential for a small demo dataset but adds a query on every insert and could create race conditions under concurrent writes.
- **No route parameters.** IDs travel through query strings rather than path segments, which is simple but means every "show one record" controller action has to manually validate `$_GET['id']` via `checkORedirect()`.
- **Hardcoded SMTP credentials.** `PageController::contact` embeds Mailtrap sandbox credentials directly in code rather than reading them from `.env`, even though the project already uses `phpdotenv` elsewhere. See the troubleshooting guide for a suggested fix.


[← Back to main README](../README.md)
