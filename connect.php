<?php
$DB_HOST = 'localhost';
$DB_USER = 'xenon';
$DB_PASS = 'admin';
$DB_NAME = 'routerover';

// For 000Web Host
// $DB_HOST = 'localhost';
// $DB_USER = 'id21953055_xenon';
// $DB_PASS = 'Rr%1860%';
// $DB_NAME = 'id21953055_routerover';

// For Infinity Host
// $DB_HOST = 'sql208.infinityfree.com';
// $DB_USER = 'if0_36176538';
// $DB_PASS = 'Rr11532001';
// $DB_NAME = 'if0_36176538_routerover';

$con = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME); // Check connection
if (!$con) {
    die ("Connection failed: " . mysqli_connect_error());
}
?>