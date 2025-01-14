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


// Check if the form has been submitted to clear the cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'clear') {
    // Delete all products in the cart for the logged-in user
    $clearQuery = "DELETE FROM cart WHERE user_id = ?";
    $stmt = $conn->prepare($clearQuery);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        // Redirect back to the cart page or show success message
        header("Location: orderscreen.php"); // Make sure orderscreen.php is the correct file for displaying cart
        exit();
    } else {
        echo "Failed to clear the cart.";
    }
}

// Check if the form has been submitted to update cart quantity
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    // If action is update
    if ($_POST['action'] === 'update') {
        $productId = (int) $_POST['productId'];
        $quantity = (int) $_POST['quantity'];

        // Ensure quantity is valid (greater than 0)
        if ($quantity > 0) {
            // Update the cart table with the new quantity for the specific user and product
            $updateQuery = "UPDATE cart SET amount = ? WHERE user_id = ? AND product_id = ?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("iii", $quantity, $userId, $productId);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                // Successfully updated, redirect back to the cart page
                header("Location: orderscreen.php");
                exit();
            } else {
                echo "Failed to update the cart.";
            }
        }
    }

    // If action is remove
    if ($_POST['action'] === 'remove') {
        $productId = (int) $_POST['productId'];

        // Remove the product from the cart
        $removeQuery = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
        $stmt = $conn->prepare($removeQuery);
        $stmt->bind_param("ii", $userId, $productId);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Successfully removed, redirect back to the cart page
            header("Location: orderscreen.php");
            exit();
        } else {
            echo "Failed to remove the product from the cart.";
        }
    }
}

// Handle order submission (placing the order)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'place_order') {
    // Calculate total price for the order
    $totalPrice = 0;
    $items = [];
    $getCartQuery = "SELECT p.product_id, p.product_name, p.product_price, c.amount AS quantity 
                     FROM cart c
                     JOIN products p ON c.product_id = p.product_id
                     WHERE c.user_id = ?";
    $stmt = $conn->prepare($getCartQuery);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $cartResult = $stmt->get_result();

    // Collect the cart items and calculate total price
    while ($row = $cartResult->fetch_assoc()) {
        $totalPrice += $row['product_price'] * $row['quantity'];
        $items[] = $row;
    }

    // Insert the order into the orders table
    $paymentMethod = $_POST['payment_method'];
    $status = 'Preparing'; // Default status for new orders

    $insertOrderQuery = "INSERT INTO orders (user_id, total_price, status, payment_method) 
                         VALUES (?, ?, ?, ?)";
    $orderStmt = $conn->prepare($insertOrderQuery);
    $orderStmt->bind_param("idss", $userId, $totalPrice, $status, $paymentMethod);
    $orderStmt->execute();

    // Get the order_id for the inserted order
    $orderId = $orderStmt->insert_id;

    // Insert the items into the order_items table
    foreach ($items as $item) {
        $foodId = $item['product_id'];
        $quantity = $item['quantity'];
        $price = $item['product_price'];
        $totalPriceItem = $price * $quantity;

        $insertOrderItemQuery = "INSERT INTO order_items (order_id, food_id, quantity, price, total_price) 
                                 VALUES (?, ?, ?, ?, ?)";
        $orderItemStmt = $conn->prepare($insertOrderItemQuery);
        $orderItemStmt->bind_param("iiidd", $orderId, $foodId, $quantity, $price, $totalPriceItem);
        $orderItemStmt->execute();
    }

    // Clear the cart after the order has been placed
    $clearCartQuery = "DELETE FROM cart WHERE user_id = ?";
    $clearCartStmt = $conn->prepare($clearCartQuery);
    $clearCartStmt->bind_param("i", $userId);
    $clearCartStmt->execute();

    // Redirect to a confirmation or order summary page
    header("Location: order_confirmation.php"); // Create a page to confirm the order
    exit();
}

// Redirect back to the orderscreen.php if no valid action is found
header('Location: orderscreen.php');
exit();
?>
