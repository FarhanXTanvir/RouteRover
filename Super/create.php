<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <!-- ----Script---- -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="../assets/fontawesome/fontawesome.css" />

    <!-- Google Fonts --> <!-- Poppins -->
    <link rel="stylesheet" href="../assets/fonts/fonts.css" />

    <!-- Style Sheet -->
    <link rel="stylesheet" href="../css/login.css">

    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }

        body {
            color: white;
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
                    
                    if (isset($_POST['create'])) {
                        // Store the form post data into some variables
                        $username = $_POST['username'];
                        $email = $_POST['email'];
                        $password = $_POST['password'];
                        $cpassword = $_POST['cpassword'];

                        // Array for storing Form Validation errors
                        $errors = array();

                        // Checking empty fields
                        if (empty($username) || empty($email) || empty($password) || empty($cpassword)) {
                            array_push($errors, "All fields are required");
                        }
                        // Validating email syntax
                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            array_push($errors, "Email is not valid");
                        }
                        // Validating password rules
                    
                        if (empty($password)) {
                            $password_err = "Please enter a password.";
                        } elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$!%*?&])[A-Za-z\d@#$!%*?&]{8,}$/", $password)) {
                            array_push($errors, "Please enter a valid password. Must be at least 8 characters long, contain at least one uppercase letter, one lowercase letter, one digit, and one special character (@#$!%*?&).");
                        } else {
                            // Hashing password for data security
                            $password_hash = password_hash($password, PASSWORD_DEFAULT);
                        }

                        //Validating Confirmation password
                        if ($password !== $cpassword) {
                            array_push($errors, "Confirmation Password does not match");
                        }

                        require_once '../connect.php';
                        $sql = "SELECT * FROM admins WHERE username = '$username'";
                        $result = mysqli_query($con, $sql);

                        // Checking if same username already exists
                        $userCount = mysqli_num_rows($result);
                        if ($userCount > 0) {
                            array_push($errors, "Admin already exists!");
                        }

                        // If there are any errors print them one by one
                        if (count($errors) > 0) {
                            //  $error contains each error message from $errors
                            foreach ($errors as $error) {
                                echo "<div class='error'>
                                <span class='close'> x </span> $error
                                </div>";
                            }
                        }
                        // If there is no error then insert the data into database or add new user in DB
                        else {
                            $sql = "INSERT INTO admins (username, email, password) VALUES (?, ?, ?)";

                            // Initializing statement
                            $stmt = mysqli_stmt_init($con);

                            // Preparing statement
                            $preparestmt = mysqli_stmt_prepare($stmt, $sql);

                            // If statement is prepared then bind the parameters
                            if ($preparestmt) {
                                mysqli_stmt_bind_param($stmt, "sss", $username, $email, $password_hash);

                                // Execute the statement
                                mysqli_stmt_execute($stmt);
                                echo "
                                <div class='success'>
                                    <span class='close'> x </span> Admin Registration Successful!
                                </div>";
                                // Records created successfully. Redirect to landing page
                                header("location: ../super.php");
                                // Close statement
                                mysqli_stmt_close($stmt);
                                exit();
                            } else {
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
                            <input type="password" name="password" class="form-control">

                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" name="cpassword" class="form-control">

                        </div>
                        <input type="submit" class="btn btn-primary" value="Create" name="create">
                        <a href="../super.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>