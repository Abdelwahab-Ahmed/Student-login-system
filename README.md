# RegisterForm

A simple PHP login form using PDO and MySQL.

## Files

- `index.php` - Login form and authentication logic.
- `connection.php` - Database connection using PDO.

## Requirements

- PHP (with PDO and PDO MySQL enabled)
- MySQL / MariaDB
- XAMPP or similar local development stack

## Database setup

1. Create a database named `users`.
2. Create a `users` table with at least these columns:
   - `Email`
   - `Password`
   - `FirstName`
   - `LastName`

Example SQL:

```sql
CREATE DATABASE users;
USE users;

CREATE TABLE users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  Email VARCHAR(255) NOT NULL UNIQUE,
  Password VARCHAR(255) NOT NULL,
  FirstName VARCHAR(100) NOT NULL,
  LastName VARCHAR(100) NOT NULL
);
```

3. Add a test user with a hashed password:

```php
<?php
echo password_hash('your-password', PASSWORD_DEFAULT);
```

Then insert the result into the `Password` column.

## Configuration

The database connection is configured in `connection.php`:

```php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "users";
```

Update these values if your environment differs.

## Usage

1. Place the project in your web server root.
2. Start Apache and MySQL.
3. Open `http://localhost/Projects/registerForm/index.php`.
4. Enter your email and password to sign in.

## Notes

- `password_verify()` expects the stored password to be a PHP password hash.
- The form currently displays a plain login button and basic validation.
