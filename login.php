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
// Start output buffering
ob_start();
// Include the file
require_once "./validators/authenticate.php";

// Get the output and clean the buffer
$output = ob_get_clean();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title> Login | RouteRover </title>

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon_io/favicon-16x16.png">
    <link rel="manifest" href="favicon_io/site.webmanifest">

    <!-- Style Sheet -->
    <link rel="stylesheet" href="css/login.css">
    <?php include 'src/inc.php'; ?>

    <script src="./assets/jquery.js"></script>
    <style>
        .break {
            width: 100%;
        }
    </style>
</head>

<body>
    <?php include 'src/inc/header.php'; ?>
    <section>
        <div class="signin">
            <h2>LOGIN</h2>
            <form method="post">
                <p class="roleSelect">
                    <i class="admin-shield fa fa-shield" aria-hidden="true"></i>
                    <select name="role" id="role" aria-label="Role">
                        <option value="user">user</option>
                        <option value="admin">admin</option>
                    </select>
                </p>
                <div class="inputBox">
                    <div>
                        <i class="fas fa-user" aria-hidden="true"></i>
                        <input type="text" name="username" id="username" area-label="username" placeholder="Username"
                            autocomplete="username">
                    </div>
                    <?php
                    if (isset($userNameError)) {
                        echo $userNameError;
                    } ?>
                </div>

                <div class="inputBox">
                    <div>
                        <i class="fas fa-lock" aria-hidden="true"></i>
                        <input type="password" name="password" id="password" area-label="password"
                            placeholder="Password" autocomplete="current-password">
                    </div>
                    <?php
                    if (isset($pswdError)) {
                        echo $pswdError;
                    } ?>
                </div>

                <div class="links">
                    <a href="#">Forgot Password</a> <a href="register">Register</a>
                </div>
                <?php
                // Display the output
                echo $output;
                ?>
                <input type="submit" value="Login" name="login">
            </form>
        </div>
    </section>
    <!-- ----------------- Footer Section --------------- -->
    <?php include 'src/inc/footer.php'; ?>
</body>

</html>