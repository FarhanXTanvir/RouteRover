<?php
if (isset($_POST['login'])) {
    $role = $_POST["role"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    require_once 'connect.php';

    $errors = array();
    if (empty($username) || empty($password)) {
        array_push($errors, "All fields are required");
    }

    if ($role === 'user' && count($errors) === 0) {
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($con, $sql);
        $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
        if ($user) {
            if (password_verify($password, $user["password"])) {
                $login = true;
                echo "
                <div class='success'>
                    Login successful, Redirecting to User Dashboard... <span class='close'> x </span> 
                </div>";
            } else {
                array_push($errors, "Password does not match");
            }
        } else {
            array_push($errors, "Username does not exist");
        }
    } elseif ($role === 'admin' && count($errors) === 0) {
        $sql = "SELECT * FROM admins WHERE username = '$username'";
        $result = mysqli_query($con, $sql);
        $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
        if ($username === 'super') {
            array_push($errors, "You are not authorized to login as super admin");
        } else if ($user) {
            if (password_verify($password, $user["password"])) {
                $login = true;
                echo "
                <div class='success'>
                    Login successful, Redirecting to Admin Panel... <span class='close'> x </span> 
                </div>";
            } else {
                array_push($errors, "Password does not match");
            }
        } else {
            array_push($errors, "Admin does not exist");
        }
    }
    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo "
            <div class='error'>
                <span class='close'> x </span> $error
            </div>";
        }
    } else if ($login === true) {
        $_SESSION["username"] = $user["username"];
        $_SESSION["email"] = $user["email"];
        $_SESSION["id"] = $user["id"];
        $_SESSION["role"] = $role;

        // If they are, set a cookie to keep them logged in
        setcookie('username', $_SESSION["username"], time() + (86400 * 30), "/"); // 86400 = 1 day
        setcookie('id', $_SESSION["id"], time() + (86400 * 30), "/"); // 86400 = 1 day
        setcookie('email', $_SESSION["email"], time() + (86400 * 30), "/"); // 86400 = 1 day
        setcookie('role', $role, time() + (86400 * 30), "/"); // 86400 = 1 day

        echo "
        <script>
            setTimeout(function(){
            window.location.href = './index.php';
            }, 1000);
        </script>";
    }
}