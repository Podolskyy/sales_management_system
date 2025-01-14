<?php
session_start();
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id']; // Access the user_id stored in the session
} else {
    // Handle case where the user is not logged in
    echo "You are not logged in.";
}

// Include database connection file
include 'C:/xampp/htdocs/salesmanagement/includes/dbconnection.php';

// Retrieve data from GET request
$productId = isset($_GET['product_id']) ? (int) $_GET['product_id'] : 0;
$quantity = 1; // Default quantity is 1, you can customize this

if ($productId > 0 && $quantity > 0) {
    // Check if the product already exists in the user's cart
    $stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $userId, $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $existingCartItem = $result->fetch_assoc();

    if ($existingCartItem) {
        // If the product already exists in the cart, update the quantity
        $newQuantity = $existingCartItem['amount'] + $quantity;
        $updateStmt = $conn->prepare("UPDATE cart SET amount = ? WHERE user_id = ? AND product_id = ?");
        $updateStmt->bind_param("iii", $newQuantity, $userId, $productId);
        $updateStmt->execute();
    } else {
        // If the product does not exist in the cart, insert a new entry
        $insertStmt = $conn->prepare("INSERT INTO cart (user_id, product_id, amount) VALUES (?, ?, ?)");
        $insertStmt->bind_param("iii", $userId, $productId, $quantity);
        $insertStmt->execute();
    }

    // Redirect to the cart page
    header('Location: ../order/orderscreen.php');
    exit; // Make sure to stop further code execution after the redirect
} else {
    // Return failure response if the input data is invalid
    echo "Invalid product ID or quantity.";
}

// Close the database connection
$conn->close();
?>
