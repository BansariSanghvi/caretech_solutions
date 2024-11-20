<?php
// db_connection.php

$servername = "localhost";  // or the appropriate host
$username = "your_username";
$password = "your_password";
$dbname = "your_database";

// Create connection
function get_db_connection() {
    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    return $conn;
}
?>
