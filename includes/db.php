<?php
$host = 'localhost';         // or your DB host
$username = 'root';          // your DB username
$password = "";              // your DB password
$database = 'devil';    // your database name

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// You can include this file anywhere with: 
//         'require_once 'includes/db.php'; ,

?>