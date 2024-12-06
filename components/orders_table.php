<?php
function generateOrderTable($status, $conn, $manager_id)
{
    $query = "SELECT o.id, u.email, cd.address, p.name, p.price, o.quantity, p.size, p.color, o.date, o.status
              FROM products p, orders o, users u, customer_details cd, shops s
              WHERE p.id = o.product_id AND o.user_id = u.id AND o.status = '$status' AND p.shop_id = s.id AND s.owner_id = $manager_id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $table = '<table class="table table-striped">
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
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>';

        $count = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            $table .= "<tr>
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
                            <td>
                                <form action='update_status.php' method='post'>
                                    <input type='hidden' name='order_id' value='{$row['id']}'>
                                    <select name='status' class='btn btn-outline-primary btn-sm'>
                                        <option value='Pending'>Pending</option>
                                        <option value='Shipped'>Shipped</option>
                                        <option value='Delivered'>Delivered</option>
                                    </select>
                                    <button type='submit' class='btn btn-outline-primary btn-sm'>Update</button>
                                </form>
                            </td>
                        </tr>";
            $count++;
        }

        $table .= '</tbody></table>';
    } else {
        $table = '<p class="text-center">No orders found for this status.</p>';
    }

    return $table;
}
