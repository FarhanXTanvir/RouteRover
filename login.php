<?php
// require_once './validators/config.php';
session_start();
// include './validators/check_cookie.php';
if (isset($_SESSION["username"])) {
    if ($_SESSION['role'] === "user") {
        header('Location: user');
    } else if ($_SESSION['role'] === "admin") {
        header('Location: admin');
    }
} else if (isset($_COOKIE["username"])) {
    if ($_COOKIE['role'] === "user") {
        header('Location: user');
    } else if ($_COOKIE['role'] === "admin") {
        header('Location: admin');
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title> Login | RouteRover </title>

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
            <h2>LOGIN</h2>
            <!-- <form action="login" method="post"> -->
            <form method="post">
                <p class="roleSelect">
                    <i class="fa fa-shield" aria-hidden="true"></i>
                    <select name="role" id="role" aria-label="Role">
                        <option value="user">user</option>
                        <option value="admin">admin</option>
                    </select>
                </p>
                <div class="inputBox">
                    <label for="username"><i class="fas fa-user" aria-hidden="true"> </i> Username </label>
                    <input type="text" name="username" id="username" autocomplete="username">
                </div>

                <div class="inputBox">
                    <label for="password"><i class="fas fa-lock" aria-hidden="true"></i> Password</label>
                    <input type="password" name="password" id="password" autocomplete="current-password">
                </div>

                <div class="links">
                    <a href="#">Forgot Password</a> <a href="register">Register</a>
                </div>
                <?php require_once "./validators/authenticate.php"; ?>
                <input type="submit" value="Login" name="login">
            </form>
        </div>
    </section>
    <!-- ----------------- Footer Section --------------- -->
    <?php include 'src/inc/footer.php'; ?>
</body>

</html>