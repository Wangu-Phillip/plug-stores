<?php

@include "../db/config.php";

session_start();

// Check if the user is logged in, if not, redirect to login page
if (!isset($_SESSION['admin_name']) && !isset($_SESSION['manager_name'])) {
    header("location: ../login.php");
    // exit;
}
if (!isset($_SESSION['admin_id']) && !isset($_SESSION['manager_id'])) {
    header("location: ../login.php");
    // exit;
}

// Get the user's cart items from the database
$manager_id = $_SESSION['manager_id'] == null ? -1 : $_SESSION['manager_id'];


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $order_id = $_POST['order_id'];
    $new_status = $_POST['status'];


    $sql_update = "UPDATE orders SET status = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("si", $new_status, $order_id);

    if ($stmt_update->execute()) {
        echo "Status updated successfully.";
    header("location: orders.php");

    } else {
        echo "Error updating status: " . $conn->error;
    }

    $stmt_update->close();
}

$conn->close();
?>
