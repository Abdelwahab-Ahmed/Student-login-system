<?php
require_once "connection.php";


$error = "";
$email = "";
$password = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if (!empty($email) && !empty($password)) {

    $stmt = $conn->prepare("SELECT ID, Email, Password, FirstName, LastName FROM users WHERE Email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user["Password"])) {
            session_start();
            $_SESSION["user_id"] = $user["ID"];
            $_SESSION["user_firstName"] = $user["FirstName"];
            $_SESSION["user_lastName"] = $user["LastName"];
            $_SESSION["user_email"] = $user["Email"];
            
            header("Location: http://localhost/projects/registerForm/dashboard.php");
            exit;
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
<body class="bg-light">
    <div class="d-flex align-items-center justify-content-center min-vh-100 px-3">
        <div class="card border-0 rounded-4 shadow-sm p-4" style="max-width: 420px; width: 100%;">
            <div class="card-body">
                <div class="text-center mb-4">
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill py-2 px-3">Welcome back</span>
                </div>
                <h1 class="h3 text-center mb-2">Sign in to your account</h1>
                <p class="text-center text-muted mb-4">Enter your email and password to continue.</p>

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
                        <input type="email" class="form-control <?= empty($error) ? "" : "is-invalid" ?>" id="email" name="email" value="<?= htmlspecialchars($email) ?>" placeholder="Email">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control <?= empty($error) ? "" : "is-invalid" ?>" id="password" name="password" placeholder="Password">
                    </div>

                    <button type="submit" class="btn btn-outline-primary btn-lg w-100">Sign in</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
