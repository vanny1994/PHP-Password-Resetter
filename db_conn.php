<?php
// Connection variables
$servername = "localhost";
$username = ""; // your username here
$password = ""; // password here
$dbname = ""; // your db here

// Create connection
$db_conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($db_conn->connect_error) {
    die("Connection failed: " . $db_conn->connect_error);
}

?>
