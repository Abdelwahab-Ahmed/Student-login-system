# RegisterForm

Simple PHP login/demo using PDO + MySQL and Bootstrap 5.

## Files

- `index.php` — login form and authentication (stores user data in `$_SESSION`)
- `connection.php` — PDO database connection
- `dashboard.php` — protected dashboard that reads user info from session
- `logout.php` — (recommended) logout handler that destroys the session


## Requirements

- PHP 7.4+ with PDO and PDO MySQL
- MySQL / MariaDB
- XAMPP or similar local development stack

## Database setup

1. Create a database and `users` table. Example:

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

2. Create a test user and store a PHP password hash in `Password`:

```php
<?php
echo password_hash('your-password', PASSWORD_DEFAULT);
```

Insert the generated hash into the `Password` column for your test row.

## Configuration

Edit `connection.php` to match your database credentials:

```php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'users';
```

## How it works

- `index.php` validates credentials and on success:
  - regenerates the session id (`session_regenerate_id(true)`) to prevent fixation
  - stores minimal user data in `$_SESSION` (id, email, first, last)
  - redirects to `dashboard.php` (relative path)
- `dashboard.php` checks `$_SESSION['user_id']` and redirects to `index.php` if not authenticated
- Logout is handled via a POST form that clears `$_SESSION`, destroys the session cookie, and calls `session_destroy()` before redirecting to the login page

## UI / Design

- Pages use Bootstrap 5 utilities for layout and components — no extra frameworks required
 

## Security notes

- Never store plaintext passwords — always store `password_hash()` output and verify with `password_verify()`.
- Regenerate session id after login and clear/destroy session on logout.
- Use POST for logout to avoid state-changing GET requests.

## Quick start

1. Place the project folder in your web root (e.g., `htdocs/Projects/registerForm`).
2. Start Apache and MySQL through XAMPP.
3. Visit `http://localhost/Projects/registerForm/index.php` and sign in with your test user.

## Next steps

- Add `logout.php` endpoint if you prefer a dedicated file for logout behavior.
- Add input sanitization and stronger validation as needed for production.
- Consider HTTPS and secure cookie flags for deployment.
