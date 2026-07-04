# Troubleshooting Guide

## Setup Issues

### "Error: No se pudo conectar a MySQL" on every page
`includes/config/database.php` connects with `mysqli_connect()` using `$_ENV['DB_HOST']`, `$_ENV['DB_USERNAME']`, `$_ENV['DB_PASSWORD']`, `$_ENV['DB_NAME']`.

**Checklist:**
- Confirm a `.env` file exists **inside `includes/`** (not the project root) — `includes/app.php` calls `Dotenv::createImmutable(__DIR__)`, which resolves relative to `includes/`.
- Confirm the four variables are spelled exactly `DB_HOST`, `DB_USERNAME`, `DB_PASSWORD`, `DB_NAME`.
- Confirm MySQL is running and the database named in `DB_NAME` already exists (the app does not create it for you).

### Missing `.env.example`
The `.gitignore` excludes `.env` but keeps a `!.env.example` exception — however no `.env.example` is currently committed. If you're starting fresh, create `includes/.env` manually with:

```env
DB_HOST=localhost
DB_USERNAME=your_user
DB_PASSWORD=your_password
DB_NAME=your_database
```

Consider committing an `includes/.env.example` with the same keys (empty values) so the gitignore exception has something to keep, and so new contributors know what to fill in.

### `composer install` fails or classes aren't found
The project uses PSR-4 autoloading defined in `composer.json`:

```json
"Model\\" : "./models",
"MVC\\" : "./",
"Controllers\\" : "./controllers"
```

Run `composer install` from inside `real_state_mvc/` (the folder containing `composer.json`), not the repository root. If you add a new class, make sure its namespace matches its folder (`Model\`, `MVC\`, or `Controllers\`) or autoloading will silently fail with a `Class not found` fatal error.

### Front-end assets look unstyled / `app.js` errors in the console
- Run `npm install` then `npm run dev` (which runs `gulp`) inside `real_state_mvc/` to compile `src/scss` and `src/js` into the build output the views reference (`build/img/...`, etc.).
- If `app.js` throws on `mobileMenu.addEventListener(...)`, check that the page's HTML includes an element with class `.mobile-menu` and `.navigation` — `eventListeners()` assumes both exist unconditionally and will throw a `TypeError` on `null` otherwise.

---

## Authentication & Access Issues

### Can't log in even with correct credentials
- Passwords must be stored hashed with PHP's `password_hash()`. If a user row was inserted with a plaintext password, `Admin::checkPassword()` (which uses `password_verify()`) will always fail.
- `Admin::userExist()` matches on exact email string; there's no case-insensitive comparison, so check the stored email's casing matches what's typed.

### Redirected to `/` when visiting `/admin` or any protected route
This is expected behavior for unauthenticated sessions — `Router::checkRoute()` checks `$_SESSION['login']` against a hardcoded `$protected_routes` list. Make sure:
- Cookies aren't blocked (the session cookie is what carries `$_SESSION['login']` between requests).
- You actually completed a successful `POST /login` first — a failed login never sets the session flag.

### Session doesn't persist between requests
`Router::checkRoute()`, `LoginController::logout()`, `Admin::userAuthentication()`, and `functions.php`'s `isAuth()` each call `session_start()` independently. If you add new entry points (e.g. a CLI script or a new front controller), make sure they also call `session_start()` before touching `$_SESSION`, or the session will appear empty.

---

## Property / Seller CRUD Issues

### "Image is required" even though a file was selected
`PropController::create` only builds the resized `$image` object when `$_FILES['property']['tmp_name']['image']` is non-empty — check the `<input>`'s `name` attribute is exactly `property[image]` and the form has `enctype="multipart/form-data"`. Also confirm `upload_max_filesize` / `post_max_size` in `php.ini` are large enough for your property photos.

### Updating a property clears the image
In `PropController::update`, if no new file is uploaded, the existing `$property->image` value from the DB is kept (it isn't overwritten) — but make sure your update form still renders a hidden field or otherwise doesn't submit an empty `property[image]` value that could be picked up elsewhere in a future refactor.

### Deleting a property/seller does nothing
`PropController::delete` and `SellerController::delete` both require **two** POST fields: `id` (a valid integer) and `tipo` set to exactly `"property"` or `"seller"` respectively (checked by `validateCT()`). If either is missing, malformed, or misspelled, the delete silently no-ops with no error message shown to the user — check your form's hidden inputs match these exact names and values.

### "Select a seller" error even after choosing one
`PropertyDB::validate()` requires `sellers_id` to be truthy. If your seller `<select>` sends a string `"0"` or an empty option value, PHP's falsy check will still flag it as missing — make sure the dropdown's `value` attributes are non-zero seller IDs.

### Phone number rejected during seller creation/update
`Sellers::validate()` requires the phone to match `/[0-9]{10}/` — note this is **not anchored** (no `^`/`$`), so it actually just requires 10 consecutive digits *somewhere* in the string, meaning formatted numbers with extra digits could pass unexpectedly, while a valid 9-digit number will always fail. If you need strict 10-digit-only validation, anchor the pattern: `/^[0-9]{10}$/`.

---

## Contact Form / Email Issues

### "Message could not be sent"
This means `$mail->send()` returned `false`. Common causes:
- Mailtrap sandbox credentials in `PageController::contact` are hardcoded (`Username`, `Password`) — if that sandbox inbox has since expired or been deleted from your Mailtrap account, sending will fail. Since the project already uses `phpdotenv`, moving these credentials into `.env` (e.g. `MAIL_HOST`, `MAIL_USERNAME`, `MAIL_PASSWORD`) and reading them with `$_ENV[...]` is recommended so they can be rotated without touching code.
- Outbound port `2525` (or `587`) may be blocked by your hosting provider or local firewall.

### Undefined index notices on `/contact` submission
`PageController::contact` directly accesses keys like `$serverResponse['phone']` or `$serverResponse['email']` based on `$serverResponse['contact']`. If a form is submitted without JavaScript enabled (so `app.js`'s `showContactMethods()` never swapped in the right fields), the expected key may be missing entirely, producing a PHP notice. Consider adding null-coalescing (`?? ''`) around each field read, and/or server-side validation before building the email body.

### No validation errors shown for a badly-filled contact form
Unlike the property/seller/login flows, `PageController::contact` doesn't run any equivalent of a `validate()` method — it goes straight to building and sending the email. Required-ness is enforced only client-side via the `required` HTML attributes, so a request sent directly to `POST /contact` (bypassing the browser) can omit any field.

---

## Database / Data Integrity Notes

### IDs seem to "jump around" or get reused after deletions
This is intentional: `ActiveRecord::getNextId()` scans existing IDs and returns the first unused integer rather than relying on `AUTO_INCREMENT`. This keeps ID sequences compact but means a deleted property's old ID can be reassigned to a brand-new property — don't treat IDs as a permanent historical reference (e.g. in external links or logs) without accounting for reuse.

### Concern about SQL injection
Queries in `ActiveRecord` and `Admin` are built via string concatenation, with values passed through `mysqli::escape_string()` before being interpolated. This mitigates the most common injection vectors but is not equivalent to parameterized/prepared statements. If you extend this project or expose it publicly, migrating to `mysqli` prepared statements (or PDO with bound parameters) is a worthwhile hardening step.

---

## Where to Look Next

- Routing & access control → `Router.php`
- Bootstrapping / environment / DB connection → `includes/app.php`, `includes/config/database.php`
- Shared helpers (`isAuth`, `sanitize`, `validateCT`, `showNoti`, `checkORedirect`) → `includes/functions.php`
- Full request/response contracts → [`API_REFERENCE.md`](API_REFERENCE.md)
- System design and data flow → [`ARCHITECTURE.md`](ARCHITECTURE.md)
