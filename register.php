<?php
    session_start();
    if (isset($_SESSION["user"])) {
        header('Location: user.php');
    }
    elseif (isset($_SESSION["admin"])) {
        header('Location: admin.php');
    }
?>
<!doctype html>
<html lang="en"> 
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title> Register | RouteRover </title>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="css/login.css">
    <?php include 'src/lib/lib.html'; ?>
  
   </head>
<body>
  <?php include 'src/inc/header.php'; ?>
  <section>
    <div class="signin">
        <div class="content"> 
            <h2>REGISTER</h2>
            <?php
                // print_r($_POST);
                if (isset($_POST['submit'])) {
                    $username = $_POST['username'];
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $cpassword = $_POST['cpassword'];

                    $password_hash = password_hash($password, PASSWORD_DEFAULT);

                    $errors = array();

                    // Checking empty fields
                    if(empty($username) || empty($email) || empty($password) || empty($cpassword)) {
                        array_push($errors, "All fields are required");
                    }
                    //Validating email syntax
                    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                        array_push($errors, "Email is not valid");
                    }
                    //Validating password rules
                    if(strlen($password) < 8) {
                        array_push($errors,"Password must be at least 8 characters long");
                    }
                    //Validating matching passwords
                    if ($password !== $cpassword){
                        array_push($errors,"Password does not match");
                    }

                    require_once 'connect.php';
                    $sql = "SELECT * FROM users WHERE username = '$username'";
                    $result = mysqli_query($con, $sql);
                    $rowCount = mysqli_num_rows($result);
                    if ($rowCount>0) {
                        array_push($errors,"Username already exists!");
                    }
                    if(count($errors)>0){
                        foreach($errors as $error){
                            echo "<div class='alert alert-danger alert-dismissible'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'> &times;</a> $error
                            </div>";
                        }
                    }
                    else{
                        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
                        $stmt = mysqli_stmt_init($con);
                        $preparestmt = mysqli_stmt_prepare($stmt, $sql);
                        if($preparestmt){
                            mysqli_stmt_bind_param($stmt, "sss", $username, $email, $password_hash);
                            mysqli_stmt_execute($stmt);
                            echo "<div class='alert alert-success alert-dismissible'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'> &times;</a> Registration Successful! You can now login.
                            </div>";
                        }
                        else{
                            die("Something went wrong");
                        }
                    }
                }
            ?> 
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
                    <div class="links"> <p>Already Registered?</p> <a href="login.php">Signin</a></div> 

                    <div class="inputBox"> 
                        <input type="submit" value="Sign Up" name="submit"> 
                    </div> 
                </div>
            </form> 
        </div> 
   </div> 
  </section>
  <?php include 'src/inc/footer.php'; ?>
</body>
</html>