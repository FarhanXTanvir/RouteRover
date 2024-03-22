<?php
session_start();
// Check existence of id parameter before processing further
if (isset ($_GET["id"]) && !empty (trim($_GET["id"]))) {
    // Get URL parameter
    $id = trim($_GET["id"]);
} else {
    //URL doesn't contain id parameter. Redirect to error page
    header("location: super/error.php");
    exit ("Please login first.");
    // echo "Please login first.";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-20 border mt-5 p-5">
                    <h1 class="mt-5 mb-3 text-center">Profile
                        <?php echo '<a href="user_update.php?id=' . $id . '" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>'; ?>
                    </h1>
                    <?php
                    // Get user info using $user variable, and pass username in  $username variable
                    require_once 'server.php';
                    ?>
                    <div class="form-group border p-1">
                        <label>Username</label>
                        <p><b>
                                <?php echo $user['username']; ?>
                            </b></p>
                    </div>
                    <div class="form-group border p-1">
                        <label>Email</label>
                        <p><b>
                                <?php echo $user['email']; ?>
                            </b></p>
                    </div>
                    <div class="form-group border p-1">
                        <label>Password</label>
                        <p><b>
                                <?php echo $user['password']; ?>
                            </b></p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>