<?php
include 'C:/xampp/htdocs/salesmanagement/includes/dbconnection.php';

$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = "SELECT product_ingredients, product_details FROM products WHERE product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $details = $result->fetch_assoc();
    echo json_encode($details);
} else {
    echo json_encode(['error' => 'No details found']);
}

$conn->close();
?>
