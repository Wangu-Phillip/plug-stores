<?php

@include "../db/config.php";


// Initialize the session
session_start();



// Check if the user is logged in, if not, redirect to login page
if (!isset($_SESSION['admin_name'])) {
    header("location: ../login.php");
    // exit;
}
if (!isset($_SESSION['admin_id']) ) {
    header("location: ../login.php");
    // exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plug Stores</title>


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
                Plug Stores
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
                        <a class="nav-link active" href="manage_products.php">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_stores.php">Stores</a>
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

    <!-- SEARCH INPUT FIELD & CATEGORY FILTER -->
    <div class="container my-3">
        <div class="row">
            <div class="col-md-4">
                <input
                    type="text"
                    class="form-control"
                    id="searchInput"
                    placeholder="Search product by name..."
                    onkeyup="searchProduct()" />
            </div>
            <div class="col-md-4">
                <select class="form-select" id="categoryFilter" onchange="filterByCategory()">
                    <option value="">All Categories</option>
                    <?php
                    // Fetch categories
                    $categoryQuery = "SELECT * FROM categories";
                    $categoryResult = mysqli_query($conn, $categoryQuery);

                    while ($category = mysqli_fetch_assoc($categoryResult)) {
                        echo "<option value='{$category['category_name']}'>{$category['category_name']}</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>

    <!-- PRODUCTS SECTION START -->
    <section class="container">
        <!-- Button trigger modal -->
        <a href="#" data-bs-toggle="modal" data-bs-target="#addProductModal">
            <button type="button" class="btn btn-primary text-end">Add products</button>
        </a>
        <br><br>

        <div class="applications-table border rounded">
            <div id="productTable">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Size</th>
                            <th>Color</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Query to fetch products from the database
                        $query = "SELECT p.id, p.name, p.description, p.category, p.price, p.size, p.color, p.image, s.id AS shop_id FROM products p,shops s WHERE p.shop_id = s.id ";
                        $result = mysqli_query($conn, $query);

                        if ($result) {
                            $count = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['description']; ?></td>
                                    <td><?php echo $row['price']; ?></td>
                                    <td><?php echo $row['size']; ?></td>
                                    <td><?php echo $row['color']; ?></td>
                                    <td><img src="<?php echo "." . $row['image']; ?>" class="img-fluid" style="max-width: 50px; max-height: 50px;"></td>
                                    <td>
                                        <button
                                            class="btn btn-warning btn-sm"
                                            onclick="editProduct(
                                            '<?php echo $row['id']; ?>', 
                                            '<?php echo $row['name']; ?>', 
                                            '<?php echo $row['description']; ?>', 
                                            '<?php echo $row['price']; ?>', 
                                            '<?php echo $row['size']; ?>', 
                                            '<?php echo $row['color']; ?>', 
                                            '<?php echo $row['category']; ?>', 
                                            '<?php echo $row['image']; ?>'
                                        )">
                                            Edit
                                        </button>
                                        <form action="../validation/delete_product.php" method="post" style="display:inline;">
                                            <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                        <?php
                                $count++;
                            }
                            mysqli_free_result($result);
                        } else {
                            echo "<tr><td colspan='8'>No products found</td></tr>";
                        }
                        mysqli_close($conn);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>



    <!-- ADD/SAVE A PRODUCT -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"> <!-- Makes the modal wider -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Add Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../validation/add_products.php" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <!-- Left Column -->
                            <input type="hidden" name="shopid" value="<?php echo $row['shop_id']; ?>">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="productName" class="form-label">Product Name</label>
                                    <input type="text" class="form-control" id="productName" name="productName" required>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="price" class="form-label">Price</label>
                                    <input type="text" class="form-control" id="price" name="price" required>
                                </div>
                                <div class="mb-3">
                                    <label for="size" class="form-label">Size</label>
                                    <input type="text" class="form-control" id="size" name="size" required>
                                </div>
                                <div class="mb-3">
                                    <label for="color" class="form-label">Color</label>
                                    <input type="text" class="form-control" id="color" name="color" required>
                                </div>
                                <div class="mb-3">
                                    <label for="category" class="form-label">Category</label>
                                    <select class="form-select" id="category" name="category" required>
                                        <option value="" selected disabled>Choose a category</option>
                                        <?php
                                        @include "../db/config.php";
                                        // Fetch categories
                                        $categoryQuery = "SELECT * FROM categories";
                                        $categoryResult = mysqli_query($conn, $categoryQuery);

                                        while ($category = mysqli_fetch_assoc($categoryResult)) {
                                            echo "<option value='{$category['category_name']}'>{$category['category_name']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="image" class="form-label">Main Image</label>
                                    <input type="file" class="form-control" id="image" name="image" required>
                                </div>
                                <div class="mb-3">
                                    <label for="variety_1" class="form-label">Variety 1</label>
                                    <input type="file" class="form-control" id="variety_1" name="variety_1" required>
                                </div>
                                <div class="mb-3">
                                    <label for="variety_2" class="form-label">Variety 2</label>
                                    <input type="file" class="form-control" id="variety_2" name="variety_2">
                                </div>
                                <div class="mb-3">
                                    <label for="variety_3" class="form-label">Variety 3</label>
                                    <input type="file" class="form-control" id="variety_3" name="variety_3">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Add Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- EDIT MODAL -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../validation/update_product.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" id="editProductId" name="product_id">
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editProductName" class="form-label">Product Name</label>
                                    <input type="text" class="form-control" id="editProductName" name="product_name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="editDescription" class="form-label">Description</label>
                                    <textarea class="form-control" id="editDescription" name="description" rows="5" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="editPrice" class="form-label">Price</label>
                                    <input type="text" class="form-control" id="editPrice" name="price" required>
                                </div>
                                <div class="mb-3">
                                    <label for="editSize" class="form-label">Size</label>
                                    <input type="text" class="form-control" id="editSize" name="size" required>
                                </div>
                                <div class="mb-3">
                                    <label for="editColor" class="form-label">Color</label>
                                    <input type="text" class="form-control" id="editColor" name="color" required>
                                </div>
                                <div class="mb-3">
                                    <label for="editCategory" class="form-label">Category</label>
                                    <select class="form-select" id="editCategory" name="category" required>
                                        <option value="" selected disabled>Choose a category</option>
                                        <?php
                                        @include "../db/config.php";
                                        // Fetch categories
                                        $categoryQuery = "SELECT * FROM categories";
                                        $categoryResult = mysqli_query($conn, $categoryQuery);

                                        while ($category = mysqli_fetch_assoc($categoryResult)) {
                                            echo "<option value='{$category['category_name']}'>{$category['category_name']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!-- Right Column -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editImage" class="form-label">Main Image</label>
                                    <input type="file" class="form-control" id="editImage" name="image">
                                    <img id="editImagePreview" style="max-width: 100%; margin-top: 10px;">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <br><br>

    <!-- FOOTER  -->
    <?php include '../components/admin_footer.php'; ?>

    <!--Bootstrap JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AJAX SEARCH & FILTER PRODUCTS FUNCTIONALITY -->
    <script>
        // FUNCTION TO FILTER PRODUCTS BY CATEGORY
        function filterByCategory() {
            const selectedCategory = document.getElementById("categoryFilter").value;

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "../validation/filter_products.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    document.getElementById("productTable").innerHTML = this.responseText;
                }
            };

            xhr.send("category=" + selectedCategory);
        }

        // FUNCTION TO SEARCH PRODUCTS BY THEIR NAME --> USES AJAX
        function searchProduct() {
            const searchValue = document.getElementById("searchInput").value;

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "../validation/search_product.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    document.getElementById("productTable").innerHTML = this.responseText;
                }
            };

            xhr.send("search=" + searchValue);
        }
    </script>

    <!-- EDIT FUNCTION -->
    <script>
        // FUNCTION TO EDIT PRODUCTS
        function editProduct(id, name, description, price, size, color, category, image) {
            // Populate modal fields
            document.getElementById('editProductId').value = id;
            document.getElementById('editProductName').value = name;
            document.getElementById('editDescription').value = description;
            document.getElementById('editPrice').value = price;
            document.getElementById('editSize').value = size;
            document.getElementById('editColor').value = color;
            document.getElementById('editCategory').value = category;
            document.getElementById('editImagePreview').src = image;

            // Show the modal
            var editModal = new bootstrap.Modal(document.getElementById('editProductModal'));
            editModal.show();
        }

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