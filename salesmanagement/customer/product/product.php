<?php
include 'C:/xampp/htdocs/salesmanagement/includes/dbconnection.php';

// Get filters (search or category)
$search = isset($_GET['search']) ? $_GET['search'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : 'All';

// Base SQL query
$sql = "SELECT product_id, product_name, product_description, product_price, product_image, product_category, stock_quantity FROM products";

// Add filters to the query
$where = [];
$params = [];
$types = '';

if ($category !== 'All') {
    $where[] = "product_category = ?";
    $params[] = $category;
    $types .= 's';
}

if (!empty($search)) {
    $where[] = "product_name LIKE ?";
    $params[] = "%$search%";
    $types .= 's';
}

if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

// Prepare and execute query
$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

// Display products
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='order-card' id='product-{$row['product_id']}'>";
        echo "<div class='order-header'>";
        echo "<h3 class='product-name'>{$row['product_name']}</h3>";
        echo "</div>";
        echo "<div class='order-body'>";
        echo "<img class='product-image' src='{$row['product_image']}' alt='{$row['product_name']}'>";
        echo "<div class='product-details'>";
        echo "<p class='product-description'>{$row['product_description']}</p>";
        echo "<p class='product-price'><strong>Price:</strong> RM{$row['product_price']}</p>";
        echo "<p class='product-stock'><strong>Stock:</strong> {$row['stock_quantity']}</p>";
        echo "</div>";
        echo "</div>";
        echo "<div class='order-footer'>";
        echo "<a href='add_to_cart.php?product_id=" . $row['product_id'] . "' class='action-button buy-now'>Buy Now</a>";
        echo "<button class='action-button add-to-cart' onclick='addToCart({$row['product_id']})'>Add to Cart</button>";
        echo "<button class='action-button view-details' onclick='loadDetails({$row['product_id']})'>View Details</button>";
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "<p>No products found</p>";
}

$conn->close();
?>
