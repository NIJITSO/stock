<?php
$servername = "localhost";
$username = "NIJITSO";
$password = "pyke";
$dbname = "bruh";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


?>