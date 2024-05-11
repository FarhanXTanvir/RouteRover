<?php
session_start();
session_destroy();

// Unset the cookies
if (isset($_COOKIE['username'])) {
    setcookie('username', '', time() - 3600, "/"); // 3600 = 1 hour
    setcookie('id', '', time() - 3600, "/"); // 3600 = 1 hour
    setcookie('email', '', time() - 3600, "/"); // 3600 = 1 hour
    setcookie('role', '', time() - 3600, "/"); // 3600 = 1 hour
}

// Redirect to the login page:
header('Location: login.php');
