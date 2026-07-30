<?php
require_once 'connection.php';

$error = "";
$email = "";
$password = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if (!empty($email) && !empty($password)) {

    $stmt = $conn->prepare("SELECT Email, Password, FirstName, LastName FROM users WHERE Email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user["Password"])) {
            $successMessage = "Hello " . htmlspecialchars($user["FirstName"])  .  htmlspecialchars($user["LastName"]);
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "Please fill in both fields.";
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
                <div class="alert alert-success">
                    <?= htmlspecialchars($successMessage) ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($error)) : ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control <?= empty($error) ? "is-valid" : "is-invalid" ?>" id="email" name="email" value="<?= htmlspecialchars($email) ?>" placeholder="Email">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control <?= empty($error) ? "is-valid" : "is-invalid" ?>" id="password" name="password" placeholder="Password">
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
