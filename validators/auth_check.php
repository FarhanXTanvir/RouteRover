<?php
// Start the session
require_once '/validators/check_cookie ';

// If the user is not logged in redirect to the login page...
if (isset($_SESSION["username"])) {
  if ($_SESSION["role"] === "admin") {
    if ($location === "user.php")
      header('Location: admin');
  } else if ($_SESSION["role"] === "user") {
    if ($location === "admin.php")
      header('Location: user');
  }
}