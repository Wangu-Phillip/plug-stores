<!-- UPDATE BACKEND -->
<?php
@include "../db/config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $productId = mysqli_real_escape_string($conn, $_POST["product_id"]);
    $productName = mysqli_real_escape_string($conn, $_POST["product_name"]);
    $description = mysqli_real_escape_string($conn, $_POST["description"]);
    $price = mysqli_real_escape_string($conn, $_POST["price"]);
    $size = mysqli_real_escape_string($conn, $_POST["size"]);
    $color = mysqli_real_escape_string($conn, $_POST["color"]);
    $category = mysqli_real_escape_string($conn, $_POST["category"]);

    // Handle image upload
    $imagePath = null;
    if (!empty($_FILES["image"]["name"])) {
        $targetDir = "uploads/";
        $imagePath = $targetDir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath);
    }

    // Update the product
    $updateQuery = "UPDATE products SET 
                        name = '$productName', 
                        description = '$description', 
                        price = '$price', 
                        size = '$size', 
                        color = '$color', 
                        category = '$category'";
    if ($imagePath) {
        $updateQuery .= ", image = '$imagePath'";
    }
    $updateQuery .= " WHERE id = '$productId'";

    if (mysqli_query($conn, $updateQuery)) {
        header("Location: ../admin/manage_products.php?success=Product updated successfully.");
        exit();
    } else {
        $error_message = $conn->error;
        header("Location: ../admin/manage_products.php?error=Error updating product: $error_message");
    }
}
