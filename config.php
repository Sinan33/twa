<?php
// Database connection settings
$host = "localhost";
$username = "u846110844_tawazun_test"; // Replace with your MySQL username
$password = "W4]JAjt|#EYg"; // Replace with your MySQL password
$database = "u846110844_tawazun_test";

// Create database connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set character set to support Arabic
$conn->set_charset("utf8mb4");
?>