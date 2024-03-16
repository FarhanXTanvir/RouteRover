<?php
    $DB_HOST = 'localhost';
    $DB_USER = 'root';
    $DB_PASS = '123456';
    $DB_NAME = 'routerover';
    // $DB_HOST = 'localhost';
    // $DB_USER = 'id21953055_xenon';
    // $DB_PASS = 'Rr%1860%';
    // $DB_NAME = 'id21953055_routerover';
    // $Table_Name = 'users';

    $con = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME); // Check connection
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>