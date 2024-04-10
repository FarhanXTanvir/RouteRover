<?php
// Start the session
session_start();

// If the user is not logged in redirect to the login page...
if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
  if (isset($_COOKIE['user'])) {
    $_SESSION["user"] = $_COOKIE['user'];
  } elseif (isset($_COOKIE['admin'])) {
    $_SESSION["admin"] = $_COOKIE['admin'];
  } else {
    header('Location: login.php');
    exit();
  }
}
?>