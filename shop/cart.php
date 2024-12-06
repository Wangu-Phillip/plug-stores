<!-- cart.php -->

<?php
// Include database connection
@include "../db/config.php";

// Initialize the session
session_start();

// Check if the user is logged in, if not, redirect to login page
if (!isset($_SESSION['customer_name']) || !isset($_SESSION['customer_id'])) {
    header("location: ../login.php");
    exit;
}

// Get the user's cart items from the database
$customer_id = $_SESSION['customer_id'];

$sql = "SELECT p.name, p.price, c.quantity, c.id
        FROM products p, cart c
        WHERE c.user_id = $customer_id AND p.id = c.product_id";

$result = $conn->query($sql);

// Calculate the total price of all items in the cart
$total_price = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

    <!-- NAV BAR START -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Sneakers.</a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="customer.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="customer_products.php">Products</a></li>
                    <li class="nav-item"><a class="nav-link active" href="cart.php">Cart</a></li>
                    <li class="nav-item"><a class="nav-link" href="customer_orders.php">My Orders</a></li>
                </ul>
                <a href="../logout.php"><button class="btn btn-outline-primary me-2">Logout</button></a>
            </div>
        </div>
    </nav>
    <!-- NAV BAR END -->

    <!-- CART PRODUCTS -->
    <div class="container">
        <h1 class="mt-5">Your Cart</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $count = 1;
                    while ($row = $result->fetch_assoc()) {
                        $total_item_price = $row['price'] * $row['quantity'];
                        echo "<tr>";
                        echo "<td>{$count}</td>";
                        echo "<td>{$row['name']}</td>";
                        echo "<td>{$row['price']}</td>";
                        echo "<td>{$row['quantity']}</td>";
                        echo "<td>{$total_item_price}</td>";
                        echo "<td>
                                <form action='../validation/delete_cart_item.php' method='post' style='display:inline;'>
                                    <input type='hidden' name='cart_id' value='{$row['id']}'>
                                    <button class='btn btn-danger btn-sm' type='submit'>Remove</button>
                                </form>
                            </td>";
                        echo "</tr>";
                        $count++;
                        $total_price += $total_item_price;
                    }
                } else {
                    echo "<tr><td colspan='6'>Your cart is empty. <br><a href='customer_products.php'>Continue Shopping</a></td></tr>";
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" class="text-end">Total:</th>
                    <th><?php echo $total_price; ?></th>
                </tr>
            </tfoot>
        </table>

        <div class="d-flex justify-content-end">
            <a href="pay.php" class="btn btn-primary">Proceed to Pay</a>
        </div>
    </div>

    <!-- FOOTER -->
    <?php include '../components/customer_footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

