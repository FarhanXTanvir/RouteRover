<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Add Admin</h2>
                    <p>Please fill this form and submit to add admin record to the database.</p>
                    <?php
                    
                    // Define variables and initialize with empty values
                    $username = $email = $password = "";
                    
                    // Processing form data when form is submitted

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

                        require_once 'config.php';
                        $sql = "SELECT * FROM admin WHERE username = '$username'";
                        $result = mysqli_query($con, $sql);
                        $rowCount = mysqli_num_rows($result);
                        if ($rowCount>0) {
                            array_push($errors,"Admin already exists!");
                        }
                        if(count($errors)>0){
                            foreach($errors as $error){
                                echo "<div class='alert alert-danger alert-dismissible'>
                                <a href='#' class='close' data-dismiss='alert' aria-label='close'> &times;</a> $error
                                </div>";
                            }
                        }
                        else{
                            $sql = "INSERT INTO admin (username, email, password) VALUES (?, ?, ?)";
                            $stmt = mysqli_stmt_init($con);
                            $preparestmt = mysqli_stmt_prepare($stmt, $sql);
                            if($preparestmt){
                                mysqli_stmt_bind_param($stmt, "sss", $username, $email, $password_hash);
                                mysqli_stmt_execute($stmt);
                                echo "
                                <div class='alert alert-success alert-dismissible'>
                                    <a href='#' class='close' data-dismiss='alert' aria-label='close'> &times;</a> Admin Registration Successful!
                                </div>";
                                // Records created successfully. Redirect to landing page
                                header("location: ../super.php");
                                // Close statement
                                mysqli_stmt_close($stmt);
                                exit();
                            }
                            else{
                                die("Oops! Something went wrong. Please try again later.");
                            }
                        }
                        // Close connection
                        mysqli_close($con);                    
                    }
                        

                    ?>
                    <form action="create.php" method="post">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="text" name="password" class="form-control">
                            
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="text" name="cpassword" class="form-control">
                            
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="../super.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>