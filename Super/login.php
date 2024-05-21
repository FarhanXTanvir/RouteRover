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

  <!-- ----Script---- -->
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->

  <!-- Font Awesome -->
  <link rel="stylesheet" href="../assets/fontawesome/fontawesome.css" />

  <!-- Google Fonts --> <!-- Poppins -->
  <link rel="stylesheet" href="../assets/fonts/fonts.css" />

  <!-- Style Sheet -->
  <link rel="stylesheet" href="../css/login.css?v=1">
  <link rel="stylesheet" href="../css/header.css?v=1">

  <style>
    body {
      background: #0af761;
      height: 100vh;
    }

    header {
      background: #333;
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