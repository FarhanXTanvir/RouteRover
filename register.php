<?php
session_start();

if (isset($_SESSION["user"]) || isset($_COOKIE['user'])) {
    if (isset($_COOKIE['user'])) {
        $_SESSION["user"] = $_COOKIE['user'];
    }
    header('Location: user.php');
} elseif (isset($_SESSION["admin"]) || isset($_COOKIE['admin'])) {
    if (isset($_COOKIE['admin'])) {
        $_SESSION["admin"] = $_COOKIE['admin'];
    }
    header('Location: admin.php');
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title> Register | RouteRover </title>

    <!-- ----Script---- -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!-- Style Sheet -->
    <link rel="stylesheet" href="css/login.css">
    <?php include 'src/lib/lib.html'; ?>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">

    <!-- Font Family -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Favicon -->
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
</head>

<body>
    <?php include 'src/inc/header.php'; ?>
    <section>
        <div class="signin">
            <div class="content">
                <h2>REGISTER</h2>
                <?php require_once "entry.php"; ?>
                <form action="register.php" method="post">
                    <div class="form">
                        <div class="inputBox">
                            <input type="text" name="username"> <i class="fas fa-user"> Username </i>
                        </div>
                        <div class="inputBox">
                            <input type="email" name="email"> <i class="fas fa-envelope"> Email </i>
                        </div>
                        <div class="inputBox">
                            <input type="password" name="password"> <i class="fas fa-lock"> Password </i>
                        </div>
                        <div class="inputBox">
                            <input type="password" name="cpassword"> <i class="fas fa-lock"> Confirm Password </i>
                        </div>
                        <div class="links">
                            <p>Already Registered?</p> <a href="login.php">Signin</a>
                        </div>

                        <div class="inputBox">
                            <input type="submit" value="Sign Up" name="register">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <?php include 'src/inc/footer.php'; ?>
    <script src="script\script.js"></script>
</body>

</html>