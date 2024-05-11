<?php
session_start();
if (isset($_SESSION["username"])) {
    if ($_SESSION['role'] === "user") {
        header('Location: user');
    } else if ($_SESSION['role'] === "admin") {
        header('Location: admin');
    }
} else {
    if (isset($_COOKIE["username"])) {
        if ($_COOKIE['role'] === "user") {
            header('Location: user');
        } else if ($_COOKIE['role'] === "admin") {
            header('Location: admin');
        }
    }
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
    <?php include 'src/inc.php'; ?>

    <!-- Font Family -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon_io/favicon-16x16.png">
    <link rel="manifest" href="favicon_io/site.webmanifest">
</head>

<body>
    <?php include 'src/inc/header.php'; ?>
    <section>
        <div class="signin">
            <div class="content">
                <h2>Create Account</h2>
                <form method="post">
                    <div class="inputBox">
                        <label for="username"><i class="fas fa-user" aria-hidden="true"></i> Username</label>
                        <input type="text" name="username" id="username" autocomplete="username">
                    </div>
                    <div class="inputBox">
                        <label for="email"><i class="fas fa-envelope" aria-hidden="true"></i> Email</label>
                        <input type="email" name="email" id="email" autocomplete="email">
                    </div>
                    <div class="inputBox">
                        <label for="password"><i class="fas fa-lock" aria-hidden="true"></i> Password</label>
                        <input type="password" name="password" id="password" autocomplete="new-password">
                    </div>
                    <div class="inputBox">
                        <label for="cpassword"><i class="fas fa-lock" aria-hidden="true"></i> Confirm Password</label>
                        <input type="password" name="cpassword" id="cpassword" autocomplete="new-password">
                    </div>
                    <div class="links">
                        <p style="color: white;">Already Registered?</p> <a href="login.php">Login</a>
                    </div>
                    <?php require_once "./validators/entry.php"; ?>
                    <input type="submit" value="REGISTER" name="register">
                </form>
            </div>
        </div>
    </section>
    <?php include 'src/inc/footer.php'; ?>
    <!-- <script src="script/register.js"></script> -->
</body>

</html>