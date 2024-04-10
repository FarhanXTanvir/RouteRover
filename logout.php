<?php
session_start();
session_destroy();

// Unset the cookies
if (isset($_COOKIE['user'])) {
    setcookie('user', '', time() - 3600, "/"); // 3600 = 1 hour
}
if (isset($_COOKIE['admin'])) {
    setcookie('admin', '', time() - 3600, "/"); // 3600 = 1 hour
}

// Redirect to the login page:
header('Location: login.php');
?>