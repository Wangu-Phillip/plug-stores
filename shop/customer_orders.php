<?php
// Include database connection
@include "../db/config.php";

// Initialize the session
session_start();

// Check if the user is logged in, if not, redirect to login page
if (!isset($_SESSION['customer_name'])) {
    header("location: ../login.php");
    exit;
}
if (!isset($_SESSION['customer_id'])) {
    header("location: ../login.php");
    exit;
}

// Get the user ID
$customer_id = $_SESSION['customer_id'];

// Query to fetch all orders grouped by status
$sql = "SELECT o.id, p.name, o.quantity, o.date, o.total_amount, o.status
        FROM products p, orders o
        WHERE o.user_id = $customer_id AND p.id = o.product_id";
$result = $conn->query($sql);

// Separate orders by status
$pending_orders = [];
$shipped_orders = [];
$delivered_orders = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        switch ($row['status']) {
            case 'Pending':
                $pending_orders[] = $row;
                break;
            case 'Shipped':
                $shipped_orders[] = $row;
                break;
            case 'Delivered':
                $delivered_orders[] = $row;
                break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../css/style.css">

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
                    <li class="nav-item"><a class="nav-link" href="customer.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="customer_products.php">Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="cart.php">Cart</a></li>
                    <li class="nav-item"><a class="nav-link active" href="customer_orders.php">My Orders</a></li>
                </ul>
                <div class="d-flex">
                    <a href="../logout.php"><button class="btn btn-outline-primary me-2">Logout</button></a>
                </div>
            </div>
        </div>
    </nav>
    <!-- NAV BAR END -->

    <!-- ORDERS TABS -->
    <div class="container mt-5">

        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs" id="ordersTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab" aria-controls="pending" aria-selected="true">Pending</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="shipped-tab" data-bs-toggle="tab" data-bs-target="#shipped" type="button" role="tab" aria-controls="shipped" aria-selected="false">Shipped</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="delivered-tab" data-bs-toggle="tab" data-bs-target="#delivered" type="button" role="tab" aria-controls="delivered" aria-selected="false">Delivered</button>
            </li>
        </ul>

        <!-- Tabs Content -->
        <div class="tab-content mt-4" id="ordersTabsContent">
            <!-- Pending Orders -->
            <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <?php if (!empty($pending_orders)) : ?>
                        <?php foreach ($pending_orders as $order) : ?>
                            <div class="col">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Order #<?php echo $order['id']; ?></h5>
                                        <p class="card-text">Product: <?php echo $order['name']; ?></p>
                                        <p class="card-text">Quantity: <?php echo $order['quantity']; ?></p>
                                        <p class="card-text">Date: <?php echo $order['date']; ?></p>
                                        <p class="card-text">Total: P<?php echo $order['total_amount']; ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p>No pending orders.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Shipped Orders -->
            <div class="tab-pane fade" id="shipped" role="tabpanel" aria-labelledby="shipped-tab">
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <?php if (!empty($shipped_orders)) : ?>
                        <?php foreach ($shipped_orders as $order) : ?>
                            <div class="col">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Order #<?php echo $order['id']; ?></h5>
                                        <p class="card-text">Product: <?php echo $order['name']; ?></p>
                                        <p class="card-text">Quantity: <?php echo $order['quantity']; ?></p>
                                        <p class="card-text">Date: <?php echo $order['date']; ?></p>
                                        <p class="card-text">Total: P<?php echo $order['total_amount']; ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p>No shipped orders.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Delivered Orders -->
            <div class="tab-pane fade" id="delivered" role="tabpanel" aria-labelledby="delivered-tab">
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <?php if (!empty($delivered_orders)) : ?>
                        <?php foreach ($delivered_orders as $order) : ?>
                            <div class="col">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Order #<?php echo $order['id']; ?></h5>
                                        <p class="card-text">Product: <?php echo $order['name']; ?></p>
                                        <p class="card-text">Quantity: <?php echo $order['quantity']; ?></p>
                                        <p class="card-text">Date: <?php echo $order['date']; ?></p>
                                        <p class="card-text">Total: P<?php echo $order['total_amount']; ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p>No delivered orders.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <br><br>

    <!-- FOOTER -->
    <?php include '../components/customer_footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
