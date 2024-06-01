<?php
session_start();

if (!isset($_COOKIE['super'])) {
  if (isset($_SESSION["super"])) {
    $_COOKIE['super'] = $_SESSION["super"];
    header('Location: ../super.php');
  }
} else if (isset($_COOKIE['super'])) {
  header('Location: ../super.php');
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Super Login</title>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="../assets/fontawesome/fontawesome.css" />

  <!-- Google Fonts --> <!-- Poppins -->
  <link rel="stylesheet" href="../assets/fonts/fonts.css" />

  <!-- Style Sheet -->
  <link rel="stylesheet" href="../css/login.css">
  <link rel="stylesheet" href="../css/header.css">

  <style>
    body {
      height: 100vh;
    }
  </style>
</head>

<body>
  <?php include '../src/inc/header.php'; ?>
  <section>
    <div class="signin">
      <div class="content">
        <i class="super-shield fa fa-shield" aria-hidden="true"></i>
        <h2>SUPER LOGIN</h2>
        <form method="post">
          <div class="inputBox">
            <i class="fas fa-user" aria-hidden="true"></i>
            <input type="text" name="username" id="username" area-label="username" placeholder="Username"
              autocomplete="username">
          </div>
          <div class="inputBox">
            <i class="fas fa-lock" aria-hidden="true"></i>
            <input type="password" name="password" id="password" area-label="password" placeholder="Password"
              autocomplete="current-password">
          </div>
          <?php require_once "authenticate.php"; ?>
          <input type="submit" value="Login" name="login">
        </form>
      </div>
    </div>
  </section>
  <script src="../script/header.js"></script>
</body>

</html>