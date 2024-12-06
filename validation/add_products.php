<!-- add_products.php -->
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


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $productName = mysqli_real_escape_string($conn, $_POST['productName']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $size = mysqli_real_escape_string($conn, $_POST['size']);
    $color = mysqli_real_escape_string($conn, $_POST['color']);
    $category = mysqli_real_escape_string($conn, $_POST['category']); 
    $shopId = mysqli_real_escape_string($conn, $_POST['shopid']);

    // Handle file uploads
    $targetDir = "./uploads/";

    // Main image
    $image = basename($_FILES["image"]["name"]);
    $targetImage = $targetDir . $image;
    move_uploaded_file($_FILES["image"]["tmp_name"], $targetImage);

    // Variety 1
    $variety1 = basename($_FILES["variety_1"]["name"]);
    $targetVariety1 = $targetDir . $variety1;
    move_uploaded_file($_FILES["variety_1"]["tmp_name"], $targetVariety1);

    // Variety 2 (Optional)
    $variety2 = !empty($_FILES["variety_2"]["name"]) ? basename($_FILES["variety_2"]["name"]) : null;
    $targetVariety2 = $variety2 ? $targetDir . $variety2 : null;
    if ($variety2) {
        move_uploaded_file($_FILES["variety_2"]["tmp_name"], $targetVariety2);
    }

    // Variety 3 (Optional)
    $variety3 = !empty($_FILES["variety_3"]["name"]) ? basename($_FILES["variety_3"]["name"]) : null;
    $targetVariety3 = $variety3 ? $targetDir . $variety3 : null;
    if ($variety3) {
        move_uploaded_file($_FILES["variety_3"]["tmp_name"], $targetVariety3);
    }

    // Insert product into the database
    $query = "INSERT INTO products (shop_id, name, description, price, size, color, category, image, variety_1, variety_2, variety_3) 
              VALUES ('$shopId', '$productName', '$description', '$price', '$size', '$color', '$category', '$targetImage', '$targetVariety1', '$targetVariety2', '$targetVariety3')";

    if (mysqli_query($conn, $query)) {
        echo "Product added successfully";
        header("Location: ../admin/manage_products.php?success=Product saved successfully.");
        exit();
    } else {
        $error_message = $conn->error;
        header("Location: ../admin/manage_products.php?error=Error updating product: $error_message");
    }
} else {
    $error_message = $conn->error;
    header("Location: ../admin/manage_products.php?error=Invalid Request: $error_message");
}
