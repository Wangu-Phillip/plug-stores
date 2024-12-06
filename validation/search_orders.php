<?php
@include "../db/config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $query = "
        SELECT o.id, u.email, cd.address, p.name, p.price, o.quantity, p.size, p.color, o.date, o.status
        FROM products p, orders o, users u, customer_details cd
        WHERE p.id = o.product_id AND o.user_id = u.id 
        AND o.status = '$status' AND u.email LIKE '%$email%'
    ";

    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        echo '<table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer Email</th>
                    <th>Customer Address</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Size</th>
                    <th>Color</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>';

        $count = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                <td>{$count}</td>
                <td>{$row['email']}</td>
                <td>{$row['address']}</td>
                <td>{$row['name']}</td>
                <td>{$row['price']}</td>
                <td>{$row['quantity']}</td>
                <td>{$row['size']}</td>
                <td>{$row['color']}</td>
                <td>{$row['date']}</td>
                <td>{$row['status']}</td>
            </tr>";
            $count++;
        }

        echo '</tbody></table>';
    } else {
        echo '<p class="text-center">No orders found.</p>';
    }

    mysqli_close($conn);
}
