<?php
// require_once './validators/config.php';
session_start();
include './validators/check_cookie.php';

if (!isset($_SESSION["username"])) {
    header("location: super/error.php");
    exit();
}
require_once "connect.php";

// Define variables and initialize with empty values
$username = $email = $password = "";
$username_err = $email_err = $password_err = "";

// Processing form data when form is submitted
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    // Get hidden input value
    $id = $_POST["id"];

    // Validate name
    $input_username = trim($_POST["username"]);
    if (empty($input_username)) {
        $username_err = "Please enter a username.";
    } elseif (!preg_match("/^[a-zA-Z0-9_]+$/", $input_username)) {
        $username_err = "Please enter a valid username. No spaces or special characters are allowed except underscore.";
    } else {
        $username = $input_username;
    }

    // Validate email
    $input_email = trim($_POST["email"]);
    if (empty($input_email)) {
        $email_err = "Please enter an email.";
    } elseif (!filter_var($input_email, FILTER_VALIDATE_EMAIL)) {
        $email_err = "Please enter a valid email address.";
    } else {
        $email = $input_email;
    }

    // Validate password
    $input_password = trim($_POST["password"]);
    if (empty($input_password)) {
        $password_err = "Please enter a password.";
    } elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$!%*?&])[A-Za-z\d@#$!%*?&]{8,}$/", $input_password)) {
        $password_err = "Please enter a valid password. Must be at least 8 characters long, contain at least one uppercase letter, one lowercase letter, one digit, and one special character (@#$!%*?&).";
    } else {
        $password = $input_password;
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
    }

    // Check input errors before inserting in database
    if (empty($username_err) && empty($email_err) && empty($password_err)) {
        // Prepare an update statement
        if (isset($_SESSION["username"])) {
            if ($_SESSION["role"] === "admin") {
                $sql = "UPDATE admins SET username=?, email=?, password=? WHERE id=?";
            } elseif ($_SESSION["role"] === "user") {
                $sql = "UPDATE users SET username=?, email=?, password=? WHERE id=?";
            }
        } else {
            echo "Unexpected Error Occured";
            exit();
        }

        if ($stmt = mysqli_prepare($con, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssi", $username, $email, $password_hash, $id);

            // Set parameters
            $param_username = $username;
            $param_email = $email;
            $param_password = $password;
            $param_id = $id;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records updated successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($con);
} else {
    // Check existence of id parameter before processing further
    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        // Get URL parameter
        $id = trim($_GET["id"]);

        // Prepare a select statement
        if (isset($_SESSION["username"])) {
            if ($_SESSION["role"] === "admin") {
                $sql = "SELECT * FROM admins WHERE id = ?";
            } elseif ($_SESSION["role"] === "user") {
                $sql = "SELECT * FROM users WHERE id = ?";
            }
        }
        if ($stmt = mysqli_prepare($con, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);

            // Set parameters
            $param_id = $id;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) == 1) {
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    // Retrieve individual field value
                    $username = $user["username"];
                    $email = $user["email"];
                    $password = $user["password"];
                } else {
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: super/error.php");
                    exit();
                }

            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);

        // Close connection
        mysqli_close($con);
    } else {
        // URL doesn't contain id parameter. Redirect to error page
        header("location: super/error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
                <div class="col-md-12">
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the admin record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username"
                                class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $username; ?>">
                            <span class="invalid-feedback">
                                <?php echo $username_err; ?>
                            </span>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email"
                                class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $email; ?>">
                            <span class="invalid-feedback">
                                <?php echo $email_err; ?>
                            </span>
                        </div>
                        <div class="form-group">
                            <label> Password </label>
                            <input type="password" name="password"
                                class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"
                                value="">
                            <span class="invalid-feedback">
                                <?php echo $password_err; ?>
                            </span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="./index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>