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

    <!-- Style Sheet -->
    <link rel="stylesheet" href="css/login.css">
    <?php include 'src/inc.php'; ?>

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
                        <i class="fas fa-user" aria-hidden="true"></i>
                        <input type="text" name="username" id="username" area-label="username" placeholder="Username"
                            autocomplete="username">
                    </div>
                    <div class="inputBox">
                        <i class="fas fa-envelope" aria-hidden="true"></i>
                        <input type="email" name="email" id="email" area-label="email" placeholder="Email"
                            autocomplete="email">
                    </div>
                    <div class="inputBox">
                        <i class="fas fa-lock" aria-hidden="true"></i>
                        <input type="password" name="password" id="password" area-label="password"
                            placeholder="Password" autocomplete="new-password">
                    </div>
                    <div class="inputBox">
                        <i class="fas fa-lock" aria-hidden="true"></i>
                        <input type="password" name="cpassword" id="cpassword" area-label="cpassword"
                            placeholder="Confirm Password" autocomplete="new-password">
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