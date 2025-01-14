<?php
session_start();
include 'C:/xampp/htdocs/salesmanagement/includes/dbconnection.php';

// Check if the order_id and status are provided
if (isset($_POST['order_id']) && isset($_POST['status'])) {
    $orderId = $_POST['order_id'];
    $status = $_POST['status'];

    // Update the status of the order in the database
    $updateQuery = "UPDATE orders SET status = ? WHERE order_id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("si", $status, $orderId);

    if ($stmt->execute()) {
        // Redirect back to the purchases page after updating the status
        header("Location: purchasescreen.php"); // Or whatever page you want to redirect to
        exit();
    } else {
        echo "Error updating status: " . $stmt->error;
    }
}
?>
