<?php

@include "./db/config.php";

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

    <link rel="stylesheet" href="css/style.css">

    <!--Bootstrap CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!--Google Fonts-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.3/font/bootstrap-icons.min.css">
    <!--Google Fonts-->



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
                        <a class="nav-link" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="products.php">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Cart</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <a href="login.php"><button class="btn btn-outline-primary me-2" type="button">Sign In</button> </a>
                </div>
            </div>
        </div>
    </nav>
    <!-- NAV BAR END  -->

    <br><br>

    <!-- PRODUCTS SECTION START  -->
    <?php include './components/product.php'; ?>
    <!-- PRODUCTS SECTION END -->


    <!-- NEW SHOES IN STORE SECTION START -->



    <!-- NEW SHOES IN STORE SECTION END -->


    <br><br>

    <!-- FOOTER  -->
    <?php include './components/customer_footer.php'; ?>



    <!--Bootstrap JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>