<?php
session_start();
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id']; // Access the user_id stored in the session
} else {
    // Handle case where the user is not logged in
    header('Location: ../../home/accountscreen.php');
    echo "You are not logged in.";
}

// Include database connection file
include 'C:/xampp/htdocs/salesmanagement/includes/dbconnection.php';

// Retrieve data from POST request
$productId = isset($_POST['productId']) ? (int) $_POST['productId'] : 0;
$quantity = isset($_POST['quantity']) ? (int) $_POST['quantity'] : 0;

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

    // Return success response
    echo json_encode(['status' => 'success', 'message' => 'Product added to cart']);
} else {
    // Return failure response if the input data is invalid
    echo json_encode(['status' => 'failure', 'message' => 'Invalid product ID or quantity']);
}

// Close the database connection
$conn->close();
?>
