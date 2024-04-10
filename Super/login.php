<?php
session_start();

if (!isset($_COOKIE['super'])) {
  if (isset($_SESSION["super"])) {
    $_COOKIE['super'] = $_SESSION["super"];
    header('Location: ../super.php');
  }
} else if(isset($_COOKIE['super'])) {
  header('Location: ../super.php');
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Super Admin Login</title>
  <link rel="stylesheet" href="../css/login.css">
</head>

<body>
  <section>
    <div class="signin">
      <div class="content">
        <h2>Super Sign In</h2>
        <?php require_once "authenticate.php"; ?>
        <!-- <form action="login.php" method="post"> -->
        <form action="login.php" method="post">
          <div class="form">
            <div class="inputBox" style="text-align:right;">
              <i class="fa-solid fa-shield"></i>
            </div>
            <div class="inputBox">
              <input type="text" name="username"> <i class="fas fa-user"> Username </i>
            </div>

            <div class="inputBox">
              <input type="password" name="password"> <i class="fas fa-lock"> Password </i>
            </div>

            <div class="inputBox">
              <input type="submit" value="Login" name="login">
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
</body>

</html>