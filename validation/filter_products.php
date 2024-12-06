<?php
@include "../db/config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["category"])) {
    $category = mysqli_real_escape_string($conn, $_POST["category"]);

    if ($category === "") {
        $query = "SELECT * FROM products";
    } else {
        $query = "SELECT * FROM products WHERE category = '$category'";
    }

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo '<table class="table table-striped">
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
                <tbody>';
        
        $count = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$count}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['description']}</td>
                    <td>{$row['price']}</td>
                    <td>{$row['size']}</td>
                    <td>{$row['color']}</td>
                    <td><img src='{$row['image']}' class='img-fluid' style='max-width: 50px; max-height: 50px;'></td>
                    <td>
                        <button
                            class='btn btn-warning btn-sm'
                            onclick=\"editProduct(
                                '{$row['id']}',
                                '{$row['name']}',
                                '{$row['description']}',
                                '{$row['price']}',
                                '{$row['size']}',
                                '{$row['color']}',
                                '{$row['category']}',
                                '{$row['image']}'
                            )\">Edit</button>
                        <form action='delete_product.php' method='post' style='display:inline;'>
                            <input type='hidden' name='product_id' value='{$row['id']}'>
                            <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                        </form>
                    </td>
                </tr>";
            $count++;
        }

        echo '</tbody></table>';
    } else {
        echo '<p class="text-center">No products found for this category.</p>';
    }

    mysqli_close($conn);
}
