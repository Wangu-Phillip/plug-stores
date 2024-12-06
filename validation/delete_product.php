<?php
@include "../db/config.php";


// Initialize the session
session_start();



// Check if the user is logged in, if not, redirect to login page
if (!isset($_SESSION['admin_name'])) {
    header("location: ../login.php");
    // exit;
}
if (!isset($_SESSION['admin_id'])) {
    header("location: ../login.php");
    // exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve product ID
    $product_id = $_POST['product_id'];

    // Delete product from database
    $query = "DELETE FROM products WHERE id = '$product_id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        header("Location: ../admin/manage_products.php?success=Product deleted successfully.");

    } else {
        $error_message = $conn->error;
        header("Location: ../admin/manage_products.php?error=Error deleting product: $error_message");
    }
} else {
    $error_message = $conn->error;
    header("Location: ../admin/manage_products.php?error=Invalid Request: $error_message");
}
?>
