<?php
require_once('../includes/connect.php');
if (isset($_GET['q'])) {
    $search = $con->real_escape_string($_GET['q']);
    $sql = "SELECT * FROM products WHERE product_title LIKE '%$search%' LIMIT 5";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div style='padding: 5px; border-bottom: 1px solid #ccc;'>";
            echo "<a href='product_details.php?product_id=" . $row['product_id'] . "' style='text-decoration:none; color:black; display:block; padding:10px; border-bottom:1px solid #ddd;'>";
            echo "<img src='./admin/product_images/" . $row['product_image_one'] . "' width='50' height='50' style='vertical-align:middle; margin-right:10px;'>";
            echo "<strong>" . htmlspecialchars($row['product_title']) . "</strong><br>";
            echo "Price: $" . $row['product_price'];
            echo "</a>";
            echo "</div>";
        }
    } else {
        echo "<div>No results found</div>";
    }
}
?>
