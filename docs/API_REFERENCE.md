# API Reference

This project doesn't expose a JSON/REST API — it's a server-rendered PHP application. This reference documents every **route** (the app's "endpoints"), the **client-side events** in `app.js`, and the **request/response contract** for each, since that's the closest equivalent to an API surface for this codebase.

All routes are registered in `public/index.php` on a single `Router` instance and dispatched by `Router::checkRoute()`.

---

## Public Routes

### `GET /`
- **Controller:** `PageController::index`
- **Description:** Home page. Loads up to 3 properties (`PropertyDB::get(3)`) for a featured listing section.
- **View:** `pages/index`

### `GET /about-us`
- **Controller:** `PageController::aboutUs`
- **Description:** Static "About Us" page, no data passed to the view.
- **View:** `pages/about-us`

### `GET /properties`
- **Controller:** `PageController::properties`
- **Description:** Full property catalog (`PropertyDB::all()`).
- **View:** `pages/listing`

### `GET /listing?id={int}`
- **Controller:** `PageController::property`
- **Query params:** `id` (required, integer) — validated by `checkORedirect('/listing')`; redirects back to `/listing` if missing/invalid.
- **Description:** Detail page for a single property (`PropertyDB::find($id)`).
- **View:** `pages/property`

### `GET /blog`
- **Controller:** `PageController::blog`
- **View:** `pages/blog`

### `GET /entry`
- **Controller:** `PageController::entry`
- **View:** `pages/entry`

### `GET /contact`
- **Controller:** `PageController::contact`
- **Description:** Renders the empty contact form.
- **View:** `pages/contact`

### `POST /contact`
- **Controller:** `PageController::contact`
- **Body params (all under `contact[...]`):**

| Field | Key | Required | Notes |
|---|---|---|---|
| Name | `contact[name]` | Yes | |
| Message | `contact[message]` | Yes | |
| Buy or Sell | `contact[type]` | Yes | `Buy` or `Sell` |
| Price/Budget | `contact[price]` | Yes | Numeric |
| Contact method | `contact[contact]` | Yes | `phone` or `email` — controls which fields below appear |
| Phone | `contact[phone]` | If `contact[contact] === 'phone'` | |
| Preferred date | `contact[date]` | If `contact[contact] === 'phone'` | |
| Preferred time | `contact[time]` | If `contact[contact] === 'phone'` | Between 09:00–18:00 (client-side `min`/`max`) |
| Email | `contact[email]` | If `contact[contact] === 'email'` | |

- **Behavior:** Builds an HTML email with all submitted fields and sends it via PHPMailer over a Mailtrap SMTP sandbox to `admin@realsstate.com`. Returns `$message = "Message sent successfully"` or `"Message could not be sent"`, shown back on the same `pages/contact` view.
- **No server-side validation** is performed on these fields before sending — see the troubleshooting guide.

### `GET /login`
- **Controller:** `LoginController::login`
- **View:** `auth/login`

### `POST /login`
- **Controller:** `LoginController::login`
- **Body params:** `email`, `password`
- **Flow:**
  1. `Admin::validateAuth()` — checks both fields are non-empty.
  2. `Admin::userExist()` — looks up the email in `users`; adds `"Account not found"` to errors if none.
  3. `Admin::checkPassword($result)` — verifies the password with `password_verify()`; adds `"Incorrect password"` if it fails.
  4. On success, `Admin::userAuthentication()` sets `$_SESSION['user']` and `$_SESSION['login'] = true`, then redirects to `/admin`.
- **Errors:** returned as a flat array of strings and rendered above the form.

### `GET /logout`
- **Controller:** `LoginController::logout`
- **Description:** Empties `$_SESSION` and redirects to `/`.

---

## Protected Routes (require `$_SESSION['login']`)

Unauthenticated requests to any of these are redirected to `/` by `Router::checkRoute()`.

### `GET /admin`
- **Controller:** `PropController::index`
- **Description:** Admin dashboard — lists all properties and all sellers, plus delete/update actions for each.
- **Query params:** `result` or `resultado` (optional, int 1–3) — shows a "Created/Updated/Deleted successfully" banner via `showNoti()`.
- **View:** `properties/admin`

### `GET|POST /properties/create`
- **Controller:** `PropController::create`
- **Body params (`multipart/form-data`, under `property[...]`):** `title`, `price`, `description` (min 50 characters), `bedrooms`, `wc` (bathrooms), `parking_space`, `sellers_id`
- **File param:** `property[image]` — required; resized to 800×600 with Intervention Image and saved under `IMAGE_DIRECTORY` with a randomly generated filename.
- **Validation errors** (`PropertyDB::validate()`): missing title, missing price, description under 50 characters, missing bedrooms/bathrooms/parking count, no seller selected, no image.
- **On success:** redirects to `/admin?result=1`.

### `GET|POST /properties/update?id={int}`
- **Controller:** `PropController::update`
- **Query params:** `id` (required) — validated by `checkORedirect('/admin')`.
- **Body params:** same as `/properties/create`; image is optional (existing image is kept if no new file is uploaded, and the old file is deleted when a replacement is provided).
- **On success:** redirects to `/admin?result=2`.

### `POST /properties/delete`
- **Controller:** `PropController::delete`
- **Body params:** `id` (int, validated with `FILTER_VALIDATE_INT`), `tipo` (must equal `"property"`, checked via `validateCT()`)
- **Behavior:** deletes the DB row and its associated image file, then redirects to `/admin?result=3`.

### `GET|POST /sellers/create`
- **Controller:** `SellerController::create`
- **Body params (under `seller[...]`):** `name`, `last_name`, `phone` (must match `/[0-9]{10}/`)
- **On success:** redirects to `/admin?result=1`.

### `GET|POST /sellers/update?id={int}`
- **Controller:** `SellerController::update`
- **Query params:** `id` (required) — validated by `checkORedirect('/admin')`.
- **Body params:** same as `/sellers/create`.
- **On success:** redirects to `/admin?result=2`.

### `POST /sellers/delete`
- **Controller:** `SellerController::delete`
- **Body params:** `id` (int), `tipo` (must equal `"seller"`)
- **On success:** redirects to `/admin?result=3`.

---

## Client-Side Events (`src/js/app.js`)

| Event | Trigger element | Handler | Effect |
|---|---|---|---|
| `DOMContentLoaded` | `document` | anonymous listener | Runs `eventListeners()` and `darkMode()` on page load |
| `click` | `.mobile-menu` | `navigationResponsive()` | Toggles the `.mostrar` class on `.navigation` to open/close the mobile nav |
| `click` | radio inputs named `contact[contact]` | `showContactMethods(e)` | Replaces the contents of `#contact` with either a phone+date+time field set or an email field, matching the routes' conditional body params above |
| `change` | `matchMedia('(prefers-color-scheme: dark)')` | anonymous listener inside `darkMode()` | Adds/removes `.dark-mode` on `<body>` when the OS-level color scheme preference changes |
| `click` | `.dark-mode-boton` | anonymous listener inside `darkMode()` | Manually toggles `.dark-mode` on `<body>` |

---

## Notification Codes

Used by `showNoti($code)` in `includes/functions.php` and rendered on the admin dashboard after redirects:

| Code | Message |
|---|---|
| `1` | Created successfully |
| `2` | Updated successfully |
| `3` | Deleted successfully |
| other | (no message shown) |
