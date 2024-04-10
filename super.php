<?php
session_start();
if (!isset($_SESSION["super"])) {
    if (!isset($_COOKIE['super'])) {
        header('Location: super/login.php');
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>

    <!-- CDN of Bootstrap and Font-awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/super.css">
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <div class="text-right">
                            <a href='index.php'><button
                                    class='btn btn-success font-weight-bolder text-center'>Home</button></a>
                            <a href='super/logout'><button
                                    class='btn btn-danger font-weight-bolder text-center'>Logout</button></a>
                        </div>
                        <h2 class="text-warning">Admin List</h2>
                        <a href="super/create.php" class="btn btn-success pull-right"><i class="fa-solid fa-plus"></i> Add
                            Admin</a>
                    </div>
                    <?php

                    require_once "connect.php";

                    // Attempt select query execution
                    $sql = "SELECT * FROM admins";
                    if ($result = mysqli_query($con, $sql)) {
                        if (mysqli_num_rows($result) > 0) {
                            echo '<table class="table table-bordered table-striped">';
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
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else {
                        echo "Oops! Something went wrong. Please try again later.";
                    }

                    // Close connection
                    mysqli_close($con);
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>