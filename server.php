<?php
    require_once 'connect.php';

    // Function to get user data by username
    function get_user_info($username, $role)
    {
        global $con;

        // Escape the username to prevent SQL injection
        $username = mysqli_real_escape_string($con, $username);

        // Query the database
        if($role === "admin"){
            $sql = "SELECT * FROM admin WHERE username = '$username'";
        }
        elseif($role === "user"){
            $sql = "SELECT * FROM users WHERE username = '$username'";
        }
        
        $result = mysqli_query($con, $sql);

        // Check if the query was successful
        if ($result) {
            // Fetch the user data as an associative array
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

            // Return the user data
            return $user;
        } else {
            echo "Error: " . mysqli_error($con);
        }

        // Close the connection
        mysqli_close($con);
    }

    // Usage example
    $user = get_user_info($username, $role);
?>
