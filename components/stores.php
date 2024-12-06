<!-- components/stores.php -->

<section class="container">
    <div>
        <div class="row row-cols-1 row-cols-md-4 g-1">
            <?php
            // Loop through products
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Trim the description to a maximum of 100 characters
                    $trimmed_description = substr($row['description'], 0, 30);
                    if (strlen($row['description']) > 30) {
                        $trimmed_description .= '...';
                    }

                    // $_SESSION['shop_id'] = $row['shop_id'];

                    echo '<div class="col mb-4">';
                    echo '  <div class="product-card">';
                    echo '      <img src="' . $row['logo'] . '" class="product-image rounded-3" alt="' . $row['name'] . '">';
                    echo '      <div class="product-details">';
                    echo '          <h5 class="title pt-1">' . $row['name'] . '</h5>';
                    echo '          <p class="description">' . $trimmed_description . '</p>';
                    echo '      </div>';
                    echo '  </div>';
                    echo '</div>';
                }
            } else {
                echo "0 results";
            }
            ?>
        </div>
    </div>
</section>