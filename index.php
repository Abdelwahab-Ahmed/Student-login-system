<?php
require_once 'connection.php';

$errors = [];
$email = "";
$password = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    if (!empty($username) && !empty($password)) {
        // --- Select the row by username ---
        $stmt = $pdo->prepare("SELECT username, password FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // --- Verify password ---
        if ($user && password_verify($password, $user["password"])) {
            $message = "Hello " . htmlspecialchars($user["username"]);
        } else {
            $message = "Invalid username or password.";
        }
    } else {
        $message = "Please fill in both fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="col-11 col-sm-8 col-md-5 col-lg-4">
            <h3 class="mb-1 text-center">Sign in</h3>
            <p class="text-center text-muted mb-4">Access your account</p>

            <?php if (!empty($successMessage)) : ?>
                <div class="alert alert-success"><?= htmlspecialchars($successMessage) ?></div>
            <?php endif; ?>

            <?php if (!empty($errors)) : ?>
                <div class="alert alert-danger">
                    <ul class="mb-0 ps-3">
                        <?php foreach ($errors as $error) : ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control <?= isset($errors["email"]) ? "is-invalid" : "" ?>" id="email" name="email" value="<?= htmlspecialchars($email) ?>" placeholder="Email">
                    <?php if (isset($errors["email"])) : ?>
                        <div class="invalid-feedback"><?= $errors["email"] ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control <?= isset($errors["password"]) ? "is-invalid" : "" ?>" id="password" name="password" placeholder="Password">
                    <?php if (isset($errors["password"])) : ?>
                        <div class="invalid-feedback"><?= $errors["password"] ?></div>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary w-100">Sign in</button>
            </form>

            <p class="text-center mt-3 mb-0">
                Don't have an account? <a href="index.php">Create one</a>
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
