<?php
@include "../db/config.php";


// Initialize the session
session_start();



// Check if the user is logged in, if not, redirect to login page
if (!isset($_SESSION['customer_name'])) {
    header("location: ../login.php");
    // exit;
}
if (!isset($_SESSION['customer_id'])) {
    header("location: ../login.php");
    // exit;
}

$customer_id = $_SESSION['customer_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve product ID
    $cart_id = $_POST['cart_id'];

    // Delete product from database
    $query = "DELETE FROM cart WHERE id = '$cart_id' AND user_id = $customer_id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "Product deleted successfully";
    header("location: ../shop/cart.php");

    } else {
        echo "Error deleting product: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request";
}
?>
