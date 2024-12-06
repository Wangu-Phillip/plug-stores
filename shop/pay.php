<!-- pay.php -->
 
<?php
// Include database connection
@include "config.php";

// Initialize the session
session_start();

// Check if the user is logged in, if not, redirect to login page
if (!isset($_SESSION['customer_name']) || !isset($_SESSION['customer_id'])) {
    header("location: login.php");
    exit;
}

// Get the user ID
$customer_id = $_SESSION['customer_id'];

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Simulate payment validation (you can integrate a real payment gateway here)
    $is_payment_successful = true; // Simulate a successful payment

    if ($is_payment_successful) {
        // Get the product IDs, quantities, and amounts from the cart
        $cart_query = "SELECT * FROM cart WHERE user_id = $customer_id";
        $cart_result = $conn->query($cart_query);

        if ($cart_result->num_rows > 0) {
            while ($cart_item = $cart_result->fetch_assoc()) {
                $product_id = $cart_item['product_id'];
                $quantity = $cart_item['quantity'];
                $total_amount = $cart_item['price'] * $quantity;

                // Insert the order into the `orders` table
                $insert_order = "INSERT INTO orders (product_id, user_id, quantity, total_amount) 
                                 VALUES ('$product_id', '$customer_id', '$quantity', '$total_amount')";

                if (!$conn->query($insert_order)) {
                    die("Error inserting order: " . $conn->error);
                }
            }

            // Clear the cart after successful payment
            $clear_cart = "DELETE FROM cart WHERE user_id = $customer_id";
            if (!$conn->query($clear_cart)) {
                die("Error clearing cart: " . $conn->error);
            }

            // Redirect to the orders page with a success message
            header("location: customer_orders.php?success=Payment completed successfully.");
            exit;
        } else {
            // Redirect to the cart page if the cart is empty
            header("location: cart.php?error=Your cart is empty.");
            exit;
        }
    } else {
        // Redirect to the cart page if payment fails
        header("location: cart.php?error=Payment failed. Please try again.");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- NAV BAR START -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Sneakers.</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="customer_products.php">Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="cart.php">Cart</a></li>
                </ul>
                <a href="logout.php"><button class="btn btn-outline-primary me-2">Logout</button></a>
            </div>
        </div>
    </nav>
    <!-- NAV BAR END -->

    <!-- PAYMENT DETAILS FORM -->
    <div class="container">
        <h1 class="my-5">Payment Details</h1>
        <form method="post" action="pay.php">
            <div class="mb-3">
                <label for="cardNumber" class="form-label">Card Number</label>
                <input type="text" class="form-control" id="cardNumber" placeholder="Enter your card number" required>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="expiryDate" class="form-label">Expiry Date</label>
                    <input type="text" class="form-control" id="expiryDate" placeholder="MM/YY" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="cvv" class="form-label">CVV</label>
                    <input type="text" class="form-control" id="cvv" placeholder="CVV" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="cardHolderName" class="form-label">Card Holder Name</label>
                <input type="text" class="form-control" id="cardHolderName" placeholder="Enter card holder name" required>
            </div>
            <button type="submit" class="btn btn-primary">Pay Now</button>
        </form>
    </div>

    <!-- FOOTER -->
    <?php include './components/customer_footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
