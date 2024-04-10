<?php
session_start();
session_destroy();

// Unset the cookies
if (isset($_COOKIE['super'])) {
    setcookie('super', '', time() - 3600, "/"); // 3600 = 1 hour
}

// Redirect to the login page:
header('Location: login');
?>