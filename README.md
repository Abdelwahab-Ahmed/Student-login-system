# RegisterForm

A simple PHP login demo with session-based dashboard access using PDO and Bootstrap 5.

## Project files

- `index.php` — login page and authentication logic
- `connection.php` — PDO database connection setup
- `dashboard.php` — protected dashboard page that displays the logged-in user
- `logout.php` — logout handler to clear the session and redirect to login

## Requirements

- PHP 7.4 or newer with PDO and PDO MySQL enabled
- MySQL or MariaDB
- XAMPP, WAMP, or another local PHP web server stack

## Database setup

1. Create the database and `users` table:

```sql
CREATE DATABASE users;
USE users;

CREATE TABLE users (
  ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  Email VARCHAR(255) NOT NULL UNIQUE,
  Password VARCHAR(255) NOT NULL,
  FirstName VARCHAR(100) NOT NULL,
  LastName VARCHAR(100) NOT NULL
);
```

2. Create a test user and store a password hash:

```php
<?php
echo password_hash('your-password', PASSWORD_DEFAULT);
```

Copy the generated hash into the `Password` column for your user row.

## Configuration

Update `connection.php` if your database credentials differ:

```php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "users";
```

## How it works

- `index.php` accepts email and password input.
- It looks up the user record by email using PDO prepared statements.
- If the user exists and `password_verify()` succeeds, the script starts a session and stores minimal user data in `$_SESSION`.
- The user is redirected to `dashboard.php`.
- `dashboard.php` displays the user name and includes a logout form.
- `logout.php` clears session data, destroys the session cookie, and redirects back to `index.php`.

## Notes on the current implementation

- `connection.php` creates a PDO connection with `ERRMODE_EXCEPTION` and `FETCH_ASSOC`.
- `index.php` stores `user_id`, `user_firstName`, `user_lastName`, and `user_email` in session.
- `dashboard.php` reads the stored session values and displays the user name.
- The UI uses Bootstrap 5 card layout and form styling.
- Logout is implemented through a POST form to clear the active session.

## Quick start

1. Place the project directory under your web server root, e.g. `htdocs/Projects/registerForm`.
2. Start Apache and MySQL from XAMPP.
3. Open `http://localhost/Projects/registerForm/index.php` in your browser.
4. Sign in using a test user whose password is hashed in the database.

## Recommendations

- Use `password_hash()` when inserting new users.
- Keep the session flow secure by avoiding password storage in session.
- Consider adding input validation and a dedicated login/logout controller for production.
