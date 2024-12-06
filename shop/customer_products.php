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

// Get the user's cart items from the database
$customer_id = $_SESSION['customer_id'];

// Query to fetch products from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);


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
                        <a class="nav-link" aria-current="page" href="customer.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="customer_products.php">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php">Cart</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="customer_orders.php">My Orders</a>
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

    <!-- SUCCESS/ERROR TOAST -->
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1050;">
        <div id="toastNotification" class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-light">
                <span id="toastIcon" class="me-2"></span>
                <strong id="toastHeading" class="me-auto">Message</strong>
                <small id="toastTime">Just now</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="toastMessage">
                <!-- Toast Message -->
            </div>
            <div id="toastProgress" class="progress position-relative bottom-0 start-2 w-100" style="height: 3px;">
                <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>

    <!-- PRODUCTS SECTION START  -->
    <?php include '../components/product.php'; ?>
    <!-- PRODUCTS SECTION END -->


    <br><br>

    <!-- FOOTER  -->
    <?php include '../components/customer_footer.php'; ?>


    <!--Bootstrap JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // FUNCTION TO DISPLAY THE TOAST MESSAGE
        function showToast(isSuccess, message, duration = 5000) {
            const toastElement = document.getElementById("toastNotification");
            const toastHeading = document.getElementById("toastHeading");
            const toastMessage = document.getElementById("toastMessage");
            const toastTime = document.getElementById("toastTime");
            const toastIcon = document.getElementById("toastIcon");
            const progressBar = document.querySelector("#toastProgress .progress-bar");

            // Get current time
            const now = new Date();
            const formattedTime = now.toLocaleTimeString([], {
                hour: "2-digit",
                minute: "2-digit",
            });
            toastTime.textContent = formattedTime;

            // Set Toast content and icon
            if (isSuccess) {
                toastHeading.textContent = "Success";
                toastHeading.classList.remove("text-danger");
                toastHeading.classList.add("text-success");
                toastMessage.textContent = message;

                // Green tick icon for success
                toastIcon.innerHTML = `<i class="bi bi-check-circle-fill text-success" style="font-size: 1.2rem;"></i>`;
                progressBar.classList.replace("bg-danger", "bg-success");
            } else {
                toastHeading.textContent = "Error";
                toastHeading.classList.remove("text-success");
                toastHeading.classList.add("text-danger");
                toastMessage.textContent = message;

                // Red X icon for error
                toastIcon.innerHTML = `<i class="bi bi-x-circle-fill text-danger" style="font-size: 1.2rem;"></i>`;
                progressBar.classList.replace("bg-success", "bg-danger");
            }

            // Reset and animate progress bar
            progressBar.style.width = "100%";
            progressBar.style.transition = `width ${duration}ms linear`;
            setTimeout(() => {
                progressBar.style.width = "0%";
            }, 0);

            // Show the Toast
            const toast = new bootstrap.Toast(toastElement, {
                delay: duration,
            });
            toast.show();
        }

        // Trigger Toast if URL contains success or error messages
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has("success")) {
            showToast(true, urlParams.get("success"), 5000);
        } else if (urlParams.has("error")) {
            showToast(false, urlParams.get("error"), 5000);
        }
    </script>

</body>

</html>