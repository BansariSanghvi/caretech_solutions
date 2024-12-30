<?php


global $dbservername, $dbusername, $dbpassword, $dbname;

$dbservername = "localhost";
$dbusername = "caretech_user";
$dbpassword = "@KNjOzNqd)NdGART";
$dbname = "caretech_solutions";


//$dbservername = "localhost";
//$dbusername = "";
//$dbpassword = "";
//$dbname = "";

$conn = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname);
//global $conn;



/*
global $user, $dsn, $dbpassword, $db;

$user = getenv('CLOUDSQL_USER'); //root
$dsn = getenv('CLOUDSQL_DSN');
$dbpassword = getenv('CLOUDSQL_PASSWORD');


//Create the PDO Client
$db = new PDO($dsn,$user,$dbpassword);

*/

?> 