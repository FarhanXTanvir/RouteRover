<?php
// Check existence of id parameter before processing further
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $id = trim($_GET["id"]);
    // Connect Database
    require_once '../connect.php';

    // Prepare a select statement
    $sql = "SELECT * FROM admins WHERE id = ?";

    if ($stmt = mysqli_prepare($con, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);

        // Set parameters
        $param_id = trim($_GET["id"]);

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) == 1) {
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                // Retrieve individual field value
                $username = $row["username"];
                $email = $row["email"];
                $password = $row["password"];
            } else {
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
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
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="read.css">
    <link rel="stylesheet" href="..\assets/fontawesome/fontawesome.css">
    <link rel="stylesheet" href="..\assets\fonts\fonts.css">
</head>

<body>
    <div class="container">
        <div class="content">
            <h1>View Admin Record</h1>
            <table>
                <tr>
                    <td>Username</td>
                    <td><?php echo $row["username"]; ?></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><?php echo $row["email"]; ?></td>
                </tr>
                <tr>
                    <?php
                    echo "
                    <td id='password'>Password ";
                    if (isset($_GET['viewPass'])) {
                        echo "
                        <a href='read.php?id=$id'>
                            <i class='fa-solid fa-eye-slash'></i>
                        </a>
                        </td>
                        <td>";
                        echo $row["password"];
                    } else {
                        echo "
                        <a href='read.php?viewPass&id=$id'>
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
            <a href="../super.php"><button>Back</button></a>
        </div>
    </div>
</body>

</html>