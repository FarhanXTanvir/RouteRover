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


  <!-- Font Family -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

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
        <h2>SUPER LOGIN</h2>
        <form action="login.php" method="post">
          <i class="fa fa-shield" aria-hidden="true"></i>
          <div class="inputBox">
            <label for="username"><i class="fas fa-user" aria-hidden="true"> </i> Username </label>
            <input type="text" name="username" id="username" autocomplete="username">
          </div>

          <div class="inputBox">
            <label for="password"><i class="fas fa-lock" aria-hidden="true"></i> Password</label>
            <input type="password" name="password" id="password" autocomplete="current-password">
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