<?php

@include "./db/config.php";

// Query to fetch products from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

// Query to fetch hero section data from the database
$hero_sql = "SELECT * FROM hero_section";
$hero_result = $conn->query($hero_sql);

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
                Plug Stores
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="stores.php">Stores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact us</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <a href="login.php"><button class="btn btn-outline-primary me-2" type="button">Sign In</button> </a>
                </div>
            </div>
        </div>
    </nav>
    <!-- NAV BAR END  -->

    <!-- HERO SECTION START -->
    <section>
        <div class="container-fluid p-0">
            <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php if ($hero_result->num_rows > 0) : ?>
                        <?php $active = true; ?>
                        <?php while ($hero = $hero_result->fetch_assoc()) : ?>
                            <div class="carousel-item <?php echo $active ? 'active' : ''; ?>">
                                <img src="<?php echo $hero['image']; ?>" class="d-block w-100 custom-opacity" id="heroImage" alt="Hero Image">
                                <div class="carousel-caption text-center mt-4 position-absolute top-50 start-50 translate-middle">
                                    <h1 class="text-dark fw-bold d-flex justify-content-center"><?php echo $hero['hero_heading']; ?></h1>
                                    <p class="text-dark fw-bold"><?php echo $hero['slogan']; ?></p>
                                    <a href="#" class="btn btn-primary btn-lg"><?php echo $hero['btn_text']; ?></a>
                                </div>
                            </div>
                            <?php $active = false; ?>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <div class="carousel-item active">
                            <img src="./assets/default.jpg" class="d-block w-100 custom-opacity" id="heroImage" alt="Default Hero Image">
                            <div class="carousel-caption text-center mt-4 position-absolute top-50 start-50 translate-middle">
                                <h1 class="text-dark fw-bold">Welcome to Our Shoe Shop</h1>
                                <p class="text-dark fw-bold">Explore our latest collection and find your perfect pair of shoes.</p>
                                <a href="#" class="btn btn-primary btn-lg">Shop Now</a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <!-- Carousel Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>
    <!-- HERO SECTION END -->

    <br><br>

    <!-- PLUG STORES PRODUCTS SECTION START  -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Plug Stores</h2>
            <div class="row">
                <!-- Shoe Card 1 -->
                <div class="col-md-4 mb-4">
                    <div class="rounded-2">
                        <div class="row g-0">
                            <img src="./assets/shoe4.jpg" class="card-img product-image rounded-3" alt="shoe">
                            <h5 class="text-center" id="shoe">Product 1</h5>
                        </div>
                    </div>
                </div>

                <!-- Shoe Card 2 -->
                <div class="col-md-4 mb-4">
                    <div class="rounded-2">
                        <div class="row g-0">
                            <img src="./assets/shoe4.jpg" class="card-img product-image rounded-3" alt="shoe">
                            <h5 class="text-center" id="shoe">Product 2</h5>
                        </div>
                    </div>
                </div>

                <!-- Shoe Card 4 -->
                <div class="col-md-4 mb-4">
                    <div class="rounded-2">
                        <div class="row g-0">
                            <img src="./assets/shoe4.jpg" class="card-img product-image rounded-3" alt="shoe">
                            <h5 class="text-center" id="shoe">Product 3</h5>
                        </div>
                    </div>
                </div>
            </div>

            <!-- View More Button with Icon -->
            <div class="text-center">
                <a href="customer_products.php" class="btn btn-secondary">
                    View More <i class="bi bi-arrow-right"></i>
                </a>
            </div>

        </div>
    </section>
    <!-- PLUG STORES PRODUCTS SECTION END  -->


    <!-- PRODUCTS SECTION START  -->
    <h1 class="mt-5 mb-4 text-center">Featured Products</h1>
    <!-- PRODUCTS SECTION END -->

    <br><br>

    <!-- FOOTER  -->
    <?php include './components/customer_footer.php'; ?>



    <!--Bootstrap JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>