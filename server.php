<?php
require_once 'connect.php';

// Function to get user data by username
function get_user_info($id)
{
    global $con;

    // Query the database
    // !Have to query via user id, because username is not primary key
    if (isset ($_SESSION["admin"])) {
        $sql = "SELECT * FROM admins WHERE id=$id";
    } elseif (isset ($_SESSION["user"])) {
        $sql = "SELECT * FROM users WHERE id=$id";
    } else {
        echo "No user logged in";
        exit();
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
$user = get_user_info($id);
?>