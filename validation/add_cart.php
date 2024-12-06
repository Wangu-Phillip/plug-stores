<!-- validation/add_cart.php -->

<?php
session_start();

@include "../db/config.php";

if (!isset($_SESSION['customer_id'])) {
    header("location: ../login.php");
    exit;
}

// Get the user's cart items from the database
$customer_id = $_SESSION['customer_id'];

// Check if product_id and price are passed as GET parameters
if (isset($_GET["product_id"]) && isset($_GET["price"])) {
    $product_id = mysqli_real_escape_string($conn, $_GET["product_id"]);
    $price = mysqli_real_escape_string($conn, $_GET["price"]);

    // Insert product into the cart
    $insert = "INSERT INTO cart (product_id, user_id, price) VALUES ('$product_id', '$customer_id', '$price')";

    if (mysqli_query($conn, $insert)) {
        header("location: ../shop/customer_products.php?success=Product added to cart.");
    } else {
        header("location: ../shop/customer_products.php?error=Failed to add product to cart.");
    }
} else {
    header("location: ../shop/customer_products.php?error=Invalid product details.");
}
?>