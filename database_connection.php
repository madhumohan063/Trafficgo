<?php

// database_connection.php
$servername = "localhost";
$username = "root";
$password = "@Aditri_1165";
$dbname = "routes_info";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
