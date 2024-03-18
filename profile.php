<?php
    session_start();
// Check existence of id parameter before processing further
    if(isset($_SESSION["admin"])){
        $username = $_SESSION["admin"];
        $role = "admin";
    } 
    elseif(isset($_SESSION["user"])){
        $username = $_SESSION["user"];
        $role = "user";
    } 
    else{
        //URL doesn't contain id parameter. Redirect to error page
        header("location: super/error.php");
        exit("Please login first.");
        // echo "Please login first.";
    }
    require_once 'server.php';
    // Get user info using $user variable, and pass username in  $username variable
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
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
                <div class="col-md-20 border p-1 mt-5 p-5">
                    <h1 class="mt-5 mb-3 text-center">Profile</h1>
                    <div class="form-group border p-1">
                        <label>username</label>
                        <p><b><?php echo $username; ?></b></p>
                    </div>
                    <div class="form-group border p-1">
                        <label>email</label>
                        <p><b><?php echo $user['email']; ?></b></p>
                    </div>
                    <div class="form-group border p-1">
                        <label>password</label>
                        <p><b><?php echo $user['password']; ?></b></p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>