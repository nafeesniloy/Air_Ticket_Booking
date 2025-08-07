<?php
$host = 'localhost';
$user = 'root';       // XAMPP default
$pass = '';           // XAMPP default (no password)
$dbname = 'air_ticket';

$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
