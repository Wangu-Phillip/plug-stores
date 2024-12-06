<?php
@include "../db/config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["search"])) {
    $search = mysqli_real_escape_string($conn, $_POST["search"]);

    $query = "SELECT * FROM products WHERE name LIKE '%$search%'";
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
                    <td><img src='{$row['image']}' style='max-width: 50px; max-height: 50px;'></td>
                    <td>
                        <form action='delete_product.php' method='post'>
                            <input type='hidden' name='product_id' value='{$row['id']}'>
                            <button type='submit' class='btn btn-danger'>Delete</button>
                        </form>
                    </td>
                </tr>";
            $count++;
        }

        echo '</tbody></table>';
    } else {
        echo '<p class="text-center">No products found.</p>';
    }

    mysqli_close($conn);
}
