<?php
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