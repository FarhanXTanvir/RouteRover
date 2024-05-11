<?php
// require_once './validators/config.php';
session_start();
if (!isset($_SESSION["super"])) {
    if (!isset($_COOKIE['super'])) {
        header('Location: super/login.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Dashboard | Super </title>

    <!-- Font Family -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon_io/favicon-16x16.png">
    <link rel="manifest" href="favicon_io/site.webmanifest">


    <!-- <link rel="stylesheet" href="css/super.css?v=2"> -->
    <link rel="stylesheet" href="css/super.css?v=2">

    <!-- Custom CSS -->
    <?php include 'src/inc.php'; ?>
</head>

<body>
    <?php include 'src/inc/header.php'; ?>
    <section id="ap">
        <h1>Super Panel</h1>
        <div class="container">
            <h2> Admin List </h2>
            <div class="content">
                <div class="table">
                    <a href="super/create.php" class="addBtn">
                        <button class="addAdmin">
                            <!-- <i class="fa-solid fa-plus"></i> -->
                            + Add Admin
                        </button>
                    </a>
                    <?php
                    require_once "connect.php";

                    // Attempt select query execution
                    $sql = "SELECT * FROM admins";
                    if ($result = mysqli_query($con, $sql)) {
                        if (mysqli_num_rows($result) > 0) {
                            echo '<table>';
                            echo "
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Password</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>";
                            echo "<tbody>";
                            $count = 1;
                            while ($user = mysqli_fetch_array($result)) {
                                echo "<tr>";
                                echo "<td>" . $count . "</td>";
                                echo "<td>" . $user['username'] . "</td>";
                                echo "<td>" . $user['email'] . "</td>";
                                echo "<td>" . $user['password'] . "</td>";
                                echo "<td class='act'>";
                                echo '<a href="super/read.php?id=' . $user['id'] . '" title="View Record"><i
                                class="fa-solid fa-user"></i></a>';
                                echo '<a href="super/update.php?id=' . $user['id'] . '" title="Update Record"><i class="fa-solid fa-pencil"></i></a>';
                                echo '<a href="super/delete.php?id=' . $user['id'] . '" title="Delete Record"><i class="fa-solid fa-trash"></i></a>';
                                echo "</td>";
                                echo "</tr>";
                                $count++;
                            }
                            echo "</tbody>";
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else {
                            echo '<div class="error"><em>No records were found.</em></div>';
                        }
                    } else {
                        echo "Oops! Something went wrong. Please try again later.";
                    }

                    // Close connection
                    mysqli_close($con);
                    ?>
                </div>
                <!-- Updates Bus fare for route1, route2, route3, route4, route5 on database -->
            </div>
        </div>
    </section>
    <!-- ----------------- Footer Section --------------- -->
    <?php include 'src/inc/footer.php'; ?>
</body>

</html>