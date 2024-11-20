<?php

global $dbservername, $dbusername, $dbpassword, $dbname;

$dbservername = "localhost";
$dbusername = "caretech_user";
$dbpassword = "@KNjOzNqd)NdGART";
$dbname = "caretech_solutions";

/*
$dbservername = "localhost";
$dbusername = "";
$dbpassword = "";
$dbname = "";
*/
$conn = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname);
//global $conn;

?>