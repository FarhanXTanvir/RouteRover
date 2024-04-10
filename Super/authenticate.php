<?php
if (isset($_POST['login'])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    require_once '../connect.php';
    $sql = "SELECT * FROM admins WHERE username = '$username'";
    $result = mysqli_query($con, $sql);
    $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $errors = array();
    if ($user) {
        if (password_verify($password, $user["password"]) && $username === 'super') {
            $_SESSION["super"] = $user["username"];
            // If they are, set a cookie to keep them logged in
            setcookie('super', $username, time() + (86400 * 30), "/"); // 86400 = 1 day
            header("Location: ../super.php");
            die("Redirecting to User dashboard...");
        } else {
            array_push($errors, "Password does not match");
        }
    } else {
        array_push($errors, "Username does not exist");
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