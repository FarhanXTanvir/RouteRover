<?php
if (isset($_POST['login'])) {
    $role = $_POST["role"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    if (empty($username) || empty($password)) {
        echo "
        <div class='error'>
            <i class='fa-regular fa-times close'></i> All fields are required
        </div>";
        return;
    }

    require_once 'connect.php';
    $login = false;
    if ($role === 'user') {
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($con, $sql);
        $userCount = mysqli_num_rows($result);

        if ($userCount === 1) {
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
            if (password_verify($password, $user["password"])) {
                $login = true;
                echo "
                <div class='success'>
                    Login successful, Redirecting to User Dashboard... 
                </div>";
            } else {
                $pswdError = "<p>Password does not match</p>";
                return;
            }
        } else {

            $userNameError = "<p>Username does not exist</p>";
            return;
        }
    } elseif ($role === 'admin') {
        $sql = "SELECT * FROM admins WHERE username = '$username'";
        $result = mysqli_query($con, $sql);
        $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
        if ($username === 'super') {
            echo "
            <div class='error'>
                <i class='fa-regular fa-times close'></i> You are not authorized to login as super admin
            </div>";
        } else if ($user) {
            if (password_verify($password, $user["password"])) {
                $login = true;
                echo "
                <div class='success'>
                    Login successful, Redirecting to Admin Panel... 
                </div>";
            } else {
                $pswdError = "<p>Password does not match</p>";
            }
        } else {
            $userNameError = "<p>Admin does not exist</p>";
        }
    }
    if ($login === true) {
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