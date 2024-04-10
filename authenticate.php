<?php
if (isset($_POST['login'])) {
    $role = $_POST["role"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    require_once 'connect.php';

    if ($role === 'user') {
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($con, $sql);
        $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $errors = array();
        if ($user) {
            if (password_verify($password, $user["password"])) {
                $_SESSION["user"] = $user["username"];
                $_SESSION["email"] = $user["email"];
                $_SESSION["id"] = $user["id"];
                // If they are, set a cookie to keep them logged in
                setcookie('user', $username, time() + (86400 * 30), "/"); // 86400 = 1 day
                header("Location: user");
                die("Redirecting to User dashboard...");
            } else {
                array_push($errors, "Password does not match");
            }
        } else {
            array_push($errors, "Username does not exist");
        }
    } elseif ($role === 'admin') {
        $sql = "SELECT * FROM admins WHERE username = '$username'";
        $result = mysqli_query($con, $sql);
        $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $errors = array();
        if ($username === 'super') {
            array_push($errors, "You are not authorized to login as super admin");
        } else if ($user) {
            if (password_verify($password, $user["password"])) {
                $_SESSION["admin"] = $user["username"];
                $_SESSION["email"] = $user["email"];
                $_SESSION["id"] = $user["id"];
                // If they are, set a cookie to keep them logged in
                setcookie('admin', $username, time() + (86400 * 30), "/"); // 86400 = 1 day
                header("Location: admin");
                die("Redirecting to Admin Panel...");
            } else {
                array_push($errors, "Password does not match");
            }
        } else {
            array_push($errors, "Admin does not exist");
        }
    }
    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo "<div class='error alert alert-danger alert-dismissible'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'> &times;</a> $error
                </div>";
        }
    }
}
?>