<?php
$servername = "mysql88.unoeuro.com";
$username = "aarhustech_tg_2018_dk";
$password = "HTX2018TG";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?> 