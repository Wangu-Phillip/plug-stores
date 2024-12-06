<?php

$conn = mysqli_connect("localhost", "root", "", "ecommerce");

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>