<?php

/*
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
*/

// Class for PDO connection.
class DBConnect{
    private $host;
    private $user;
    private $password;
    private $db;

    public function __construct() {
        $this->host = getenv('CLOUDSQL_DSN');
        $this->user = getenv('CLOUDSQL_USER');
        $this->password = getenv('CLOUDSQL_PASSWORD');
        $this->db = getenv('CLOUDSQL_DATABASE_NAME');
    }

    // Updated the password variable.

    public function connect(){
        try{
            $conn = new PDO($this->host . '; dbname=' . $this->db, $this->user, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e){
            echo 'Database Error:' . $e->getMessage();
           
        }
    }

}
  

//global $conn;

// Fetch credentials from environment variables - updated.
//$inst = getenv('CLOUDSQL_DSN'); // Cloud SQL instance DSN
//$user =  getenv('CLOUDSQL_USER'); // 'root'
//$pass = getenv('CLOUDSQL_PASSWORD'); // '@KNjOzNqd)NdGART'
//$db = getenv('CLOUDSQL_DATABASE_NAME'); // 'caretech_solutions'

// Added Socket Directory.
//$socketDir = "/cloudsql";
//$unixSocket = "$socketDir/$inst";


// Use the Cloud SQL Unix socket for connection
//$conn = mysqli_connect($unixSocket, $user, $pass, $db);

?> 