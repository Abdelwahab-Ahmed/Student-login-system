<?php
session_start();

if (empty($_SESSION['user_id'])) { header('Location: index.php'); exit; }

$userName = $_SESSION["user_firstName"] . " " . $_SESSION["user_lastName"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {


    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 60,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }

    session_destroy();
    header("Location: http://localhost/projects/registerForm/index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="d-flex align-items-center justify-content-center min-vh-100 px-3">
        <div class="card border-0 rounded-4 shadow-sm p-4 w-100" style="max-width: 420px;">
            <div class="card-body text-center">
                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill py-2 px-3 mb-3">Welcome</span>
                <h1 class="h3 mb-2">
                    Hello, <?= htmlspecialchars($userName) ?>!
                </h1>
                <p class="text-muted mb-4">You have successfully signed in. Use the button below to logout.</p>
                <form method="post">
                    <button type="submit" class="btn btn-outline-primary btn-lg w-100">Logout</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
