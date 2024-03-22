<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <link rel="stylesheet" href="css/super.css">
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2>Admin List</h2>
                        <a href="super/create.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add Admin</a>
                    </div>
                    <?php

                    require_once "connect.php";

                    // Attempt select query execution
                    $sql = "SELECT * FROM admins";
                    if($result = mysqli_query($con, $sql)){
                        if(mysqli_num_rows($result) > 0){
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
                                while($user = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $count . "</td>";
                                        echo "<td>" . $user['username'] . "</td>";
                                        echo "<td>" . $user['email'] . "</td>";
                                        echo "<td>" . $user['password'] . "</td>";
                                        echo "<td class='act'>";
                                            echo '<a href="super/read.php?id='. $user['id'] .'" title="View Record" data-toggle="tooltip"><span class="fa fa-user"></span></a>';
                                            echo '<a href="super/update.php?id='. $user['id'] .'" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                            echo '<a href="super/delete.php?id='. $user['id'] .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                        echo "</td>";
                                    echo "</tr>";
                                    $count++;
                                }
                                echo "</tbody>";
                            echo "</table>";
                            echo "<div class='text-center'><a href='index.php'><button class='btn btn-success font-weight-bolder'>Home</button></a></div>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else{
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