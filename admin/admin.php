<?php

@include "../db/config.php";


// Initialize the session
session_start();

// Query to fetch products from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

// Check if the user is logged in, if not, redirect to login page
if (!isset($_SESSION['admin_name'])) {
    header("location: ../login.php");
    // exit;
}
if (!isset($_SESSION['admin_id'])) {
    header("location: ../login.php");
    // exit;
}

// Get the user's cart items from the database
$admin_id = $_SESSION['admi_id'];

// Query to count users with role 'customer'
$sqlUsers = "SELECT COUNT(*) as total_users FROM users WHERE role = 'customer'";
$resultUsers = $conn->query($sqlUsers);
$rowUsers = $resultUsers->fetch_assoc();
$totalUsers = $rowUsers['total_users'];

// Query to count orders with statuses 'pending', 'shipped', and 'delivered'
$sqlOrdersPending = "SELECT COUNT(*) as total_orders_pending FROM orders WHERE status = 'pending'";
$resultOrdersPending = $conn->query($sqlOrdersPending);
$rowOrdersPending = $resultOrdersPending->fetch_assoc();
$totalOrdersPending = $rowOrdersPending['total_orders_pending'];

$sqlOrdersShipped = "SELECT COUNT(*) as total_orders_shipped FROM orders WHERE status = 'shipped'";
$resultOrdersShipped = $conn->query($sqlOrdersShipped);
$rowOrdersShipped = $resultOrdersShipped->fetch_assoc();
$totalOrdersShipped = $rowOrdersShipped['total_orders_shipped'];

$sqlOrdersDelivered = "SELECT COUNT(*) as total_orders_delivered FROM orders WHERE status = 'delivered'";
$resultOrdersDelivered = $conn->query($sqlOrdersDelivered);
$rowOrdersDelivered = $resultOrdersDelivered->fetch_assoc();
$totalOrdersDelivered = $rowOrdersDelivered['total_orders_delivered'];

// Query to count total products
$sqlProducts = "SELECT COUNT(*) as total_products FROM products";
$resultProducts = $conn->query($sqlProducts);
$rowProducts = $resultProducts->fetch_assoc();
$totalProducts = $rowProducts['total_products'];



// Query to calculate total sales grouped by month
$sqlSalesByMonth = "SELECT 
                        MONTHNAME(date) as month_name, 
                        SUM(total_amount) as total_sales 
                    FROM orders 
                    GROUP BY MONTH(date) 
                    ORDER BY MONTH(date)";

$resultSalesByMonth = $conn->query($sqlSalesByMonth);

// Initialize data array for Google Charts
$data = [["Month", "Sales"]];

if ($resultSalesByMonth->num_rows > 0) {
    while ($row = $resultSalesByMonth->fetch_assoc()) {
        $data[] = [$row["month_name"], (float)$row["total_sales"]];
    }
}

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

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <link rel="stylesheet" href="../css/style.css">


</head>

<body>

    <!-- NAV BAR START  -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <!-- <img src="./assets/shoe1.jpg" alt="Logo" width="30" height="30" class="d-inline-block align-top"> -->
                Plug Stores
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="admin.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_products.php">Manage Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_stores.php">Manage Stores</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="orders.php">Orders</a>
                    </li> -->
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

    <br><br>

    <!-- ANALYTICS -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-3">
                <div class="card text-center shadow">
                    <div class="card-body">
                        <h5 class="card-title">Total Users</h5>
                        <p class="card-text"><?php echo $totalUsers; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center shadow">
                    <div class="card-body">
                        <h5 class="card-title">Orders Pending</h5>
                        <p class="card-text"><?php echo $totalOrdersPending; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center shadow">
                    <div class="card-body">
                        <h5 class="card-title">Orders Shipped</h5>
                        <p class="card-text"><?php echo $totalOrdersShipped; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center shadow">
                    <div class="card-body">
                        <h5 class="card-title">Orders Delivered</h5>
                        <p class="card-text"><?php echo $totalOrdersDelivered; ?></p>
                    </div>
                </div>
            </div>
            <!-- <div class="col-md-3 mt-3">
                <div class="card text-center shadow">
                    <div class="card-body">
                        <h5 class="card-title">Total Products</h5>
                        <p class="card-text"><?php echo $totalProducts; ?></p>
                    </div>
                </div>
            </div> -->
        </div>
    </div>

    <br><br>

    <!-- LINE CHART GRAPH -->
    <div class="container my-5">
        <div class="d-flex justify-content-center">
            <div id="chart_div" style="width: 90%; height: 500px;"></div>
        </div>
    </div>


    <br><br>



    <!-- FOOTER  -->
    <?php include '../components/admin_footer.php'; ?>

    <!--Bootstrap JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- LINE CHART GRAPH -->
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            // Fetch PHP data as JSON
            const data = google.visualization.arrayToDataTable(<?php echo json_encode($data); ?>);

            // Customized chart options
            const options = {
                title: 'Monthly Sales',
                titleTextStyle: {
                    color: '#4CAF50', // Green color for the title
                    fontSize: 35,
                    bold: true,
                    alignment: 'center'  // Center-align the title
                },
                hAxis: {
                    title: 'Month',
                    titleTextStyle: {
                        color: '#757575', // Gray color for x-axis title
                        bold: true
                    },
                    textStyle: {
                        color: '#333' // Darker text for months
                    },
                    gridlines: {
                        count: 12
                    } // Ensure 12 gridlines (1 for each month)
                },
                vAxis: {
                    title: 'Sales',
                    titleTextStyle: {
                        color: '#757575', // Gray color for y-axis title
                        bold: true
                    },
                    textStyle: {
                        color: '#333' // Darker text for values
                    },
                    gridlines: {
                        color: '#f0f0f0' // Light gray gridlines
                    }
                },
                legend: {
                    position: 'bottom',
                    textStyle: {
                        color: '#555', // Medium gray legend text
                        fontSize: 12
                    }
                },
                colors: ['#FF5722'], // Custom line color (Orange)
                curveType: 'function', // Smooth curve for the line chart
                pointSize: 6, // Size of the points on the line
                backgroundColor: '#f9f9f9', // Light background for the chart
                tooltip: {
                    textStyle: {
                        color: '#000', // Black text in tooltips
                        fontSize: 12
                    },
                    showColorCode: true
                }
            };

            // Render the line chart
            const chart = new google.visualization.LineChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
    </script>



</body>

</html>