<?php
// require_once './validators/config.php';
session_start();
include './validators/check_cookie.php';

if (!isset($_SESSION["username"])) {
    header("location: super/error.php");
    exit("Please login first.");
}
// Check existence of id parameter before processing further
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    // Get URL parameter
    $id = trim($_GET["id"]);
} else {
    //URL doesn't contain id parameter. Redirect to error page
    header("location: super/error.php");
    exit("Please login first.");
    // echo "Please login first.";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>View Record</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="./assets/fontawesome/fontawesome.css" />

    <!-- Google Fonts --> <!-- Poppins -->
    <link rel="stylesheet" href="./assets/fonts/fonts.css" />
    <link rel="stylesheet" href="./super/read.css">
</head>

<body>
    <div class="container">
        <div class="content">
            <h1>Profile
                <?php echo "<a href='user_update.php?id= $id' title='Update Record'><i class='fa fa-pencil'></i></a>"; ?>
            </h1>
            <?php
            // Get user info using $user variable, and pass username in  $username variable
            require_once 'server.php';
            ?>
            <table>
                <tr>
                    <td>Username</td>
                    <td><?php echo $user['username']; ?></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><?php echo $user['email']; ?></td>
                </tr>
                <tr>
                    <?php
                    echo "
                    <td id='password'>Password ";
                    if (isset($_GET['viewPass'])) {
                        echo "
                        <a href='profile.php?id=$id'>
                            <i class='fa-solid fa-eye-slash'></i>
                        </a>
                        </td>
                        <td>";
                        echo $user['password'];
                    } else {
                        echo "
                        <a href='profile.php?viewPass&id=$id'>
                            <i class='fa-solid fa-eye'></i>
                        </a>
                        </td>
                        <td>";
                        echo "******** ";
                    }
                    echo "</td>";
                    ?>
                </tr>
            </table>
            <a href="./index.php"><button>Back</button></a>
        </div>
    </div>
</body>

</html>