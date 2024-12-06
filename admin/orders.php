<?php

@include "../db/config.php";


// Initialize the session
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


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sneakers.</title>


    <!--Bootstrap CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!--Google Fonts-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.3/font/bootstrap-icons.min.css">
    <!--Google Fonts-->

    <link rel="stylesheet" href="../css/style.css">


</head>

<body>

    <!-- NAV BAR START  -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <!-- <img src="./assets/shoe1.jpg" alt="Logo" width="30" height="30" class="d-inline-block align-top"> -->
                Sneakers.
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="admin.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_products.php">Manage Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="orders.php">Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_users.php">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="settings.php">Settings</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <!-- <a href="login.php"><button class="btn btn-outline-primary me-2" type="button">Login</button> </a> -->
                    <a href="../logout.php"><button class="btn btn-outline-primary me-2" type="button">Logout</button> </a>
                </div>
            </div>
        </div>
    </nav>
    <!-- NAV BAR END  -->

    <br>

    <!-- TAB NAVIGATION -->
    <div class="container">
        <ul class="nav nav-tabs justify-content-start" id="orderTabs" role="tablist">
            <li class="nav-item"><button class="nav-link active" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab">Pending</button></li>
            <li class="nav-item"><button class="nav-link" id="shipped-tab" data-bs-toggle="tab" data-bs-target="#shipped" type="button" role="tab">Shipped</button></li>
            <li class="nav-item"><button class="nav-link" id="delivered-tab" data-bs-toggle="tab" data-bs-target="#delivered" type="button" role="tab">Delivered</button></li>
        </ul>

        <div class="tab-content mt-3" id="orderTabsContent">
            <!-- Pending Orders -->
            <div class="tab-pane fade show active" id="pending" role="tabpanel">
                <div class="d-flex justify-content-end mb-3">
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="searchPending" placeholder="Search by customer email..." onkeyup="searchOrders('Pending', this.value)">
                    </div>
                </div>

                <div id="pendingOrders">
                    <?php include '../components/orders_table.php';
                    echo generateOrderTable('Pending', $conn, $manager_id); ?>
                </div>
            </div>

            <!-- Shipped Orders -->
            <div class="tab-pane fade" id="shipped" role="tabpanel">
                <div class="d-flex justify-content-end">
                    <div class="col-md-4">
                        <input type="text" class="form-control mb-3" id="searchShipped" placeholder="Search by customer email..." onkeyup="searchOrders('Shipped', this.value)">
                    </div>
                </div>

                <div id="shippedOrders">
                    <?php echo generateOrderTable('Shipped', $conn, $manager_id); ?>
                </div>
            </div>

            <!-- Delivered Orders -->
            <div class="tab-pane fade" id="delivered" role="tabpanel">
                <div class="d-flex justify-content-end">
                    <div class="col-md-4">
                        <input type="text" class="form-control mb-3" id="searchDelivered" placeholder="Search by customer email..." onkeyup="searchOrders('Delivered', this.value)">
                    </div>
                </div>

                <div id="deliveredOrders">
                    <?php echo generateOrderTable('Delivered', $conn, $manager_id); ?>
                </div>
            </div>
        </div>
    </div>

    <br><br>

    <!-- FOOTER  -->
    <?php include '../components/admin_footer.php'; ?>


    <!--Bootstrap JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AJAX Live Search -->
    <script>
        function searchOrders(status, email) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "../validation/search_orders.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    if (status === "Pending") {
                        document.getElementById("pendingOrders").innerHTML = this.responseText;
                    } else if (status === "Shipped") {
                        document.getElementById("shippedOrders").innerHTML = this.responseText;
                    } else if (status === "Delivered") {
                        document.getElementById("deliveredOrders").innerHTML = this.responseText;
                    }
                }
            };

            xhr.send(`status=${status}&email=${email}`);
        }
    </script>

</body>

</html>