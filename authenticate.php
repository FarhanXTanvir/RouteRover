<?php 
    if(isset($_POST['login'])){
        $role = $_POST["role"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        require_once 'connect.php';
        if($role === 'user'){
            $sql = "SELECT * FROM users WHERE username = '$username'";
            $result = mysqli_query($con, $sql);
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
            if($user){
                if(password_verify($password, $user["password"])){
                    $_SESSION["user"] = $user["username"];
                    $_SESSION["email"] = $user["email"];
                    $_SESSION["password"] = $user["password"];
                    header("Location: user.php");
                    die("Redirecting to User dashboard...");
                }
                else{
                    echo 
                    "<div class='alert alert-danger alert-dismissible'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'> &times;</a> Password does not match
                    </div>";
                }
            }
            else{
                echo 
                "<div class='alert alert-danger alert-dismissible'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'> &times;</a> Username does not exist
                </div>";
            }
        }
        elseif($role === 'admin'){
            $sql = "SELECT * FROM admin WHERE username = '$username'";
            $result = mysqli_query($con, $sql);
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
            if($user){
                if(password_verify($password, $user["password"])){
                    $_SESSION["admin"] = $user["username"];
                    $_SESSION["email"] = $user["email"];
                    $_SESSION["password"] = $user["password"];
                    header("Location: admin.php");
                    die("Redirecting to Admin dashboard...");
                }
                else{
                    echo 
                    "<div class='alert alert-danger alert-dismissible'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'> &times;</a> Password does not match
                    </div>";
                }
            }
            else{
                echo 
                "<div class='alert alert-danger alert-dismissible'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'> &times;</a> Admin does not exist
                </div>";
            }
        }                
    }
?>