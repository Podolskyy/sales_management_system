<?php
session_start();
error_reporting(0);
include('dbconnect.php');

// Handle order insertion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get order details from the form
    $item_name = trim($_POST['item_name']);
    $quantity = intval($_POST['quantity']);
    $price = floatval($_POST['price']);
    $customer_info = trim($_POST['customer_info']);

    // Validate input
    if (empty($item_name) || empty($quantity) || empty($price) || empty($customer_info)) {
        echo "<p style='color: red;'>Please fill in all fields.</p>";
    } else {
        // Prepare the SQL query to insert the order data
        $stmt = $conn->prepare("INSERT INTO orders (item_name, quantity, price, customer_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('sdis', $item_name, $quantity, $price, $customer_info);

        // Execute the query and check for errors
        if ($stmt->execute()) {
            echo "<p style='color: green;'>Order submitted successfully!</p>";
        } else {
            echo "<p style='color: red;'>Error submitting the order: " . $stmt->error . "</p>";
        }

        // Close the prepared statement
        $stmt->close();
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>
    <link rel="stylesheet" href="orderstyles.css">
</head>

<body>
    <!-- Drawer Toggle Button -->
    <button class="drawer-toggle" onclick="toggleDrawer()">☰</button>

    <!-- Drawer Navigation -->
    <nav id="drawer" class="drawer">
        <div class="drawer-spacer"></div>
        <ul class="drawer-menu">
            <li><a href="clerkscreen.php">Back to Main Page</a></li> <!-- New link to the main page -->
            <li><a href="customerscreen.php">Customer Management</a></li>
            <li><a href="orderscreen.php">Order Management</a></li>
            <li><a href="purchasescreen.php">Payment Processing</a></li>
            <li><a href="inventoryscreen.php">Inventory Management</a></li>
            <li><a href="accountscreen.php">Logout</a></li>
        </ul>
    </nav>

    <!-- Header Section -->
    <header>
        <h1>Order Management</h1>
        <p>Manage your customers with ease.</p>
    </header>

    <!-- Main Content -->
    <main>
        <form method="POST" action="orderscreen.php">
            <div class="form-group">
                <input type="text" name="item_name" class="input-field" placeholder="Item Name" required>
            </div>
            <div class="form-group">
                <input type="number" name="quantity" class="input-field" placeholder="Quantity" required>
            </div>
            <div class="form-group">
                <input type="number" step="0.01" name="price" class="input-field" placeholder="Price" required>
            </div>
            <div class="form-group">
                <input type="text" name="customer_info" class="input-field" placeholder="Customer Name or ID" required>
            </div>
            <button type="submit" class="button primary-button">Submit Order</button>
        </form>

        <section class="card">
            <h2 class="section-title">Order Confirmation</h2>
            <div id="order-confirmation-details" class="confirmation-details">
                <?php
                // Display confirmation message after order submission
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if (isset($stmt) && $stmt->execute()) {
                        echo "<p>Order submitted successfully!</p>";
                    } else {
                        echo "<p>Error submitting order. Please try again later.</p>";
                    }
                }
                ?>
            </div>
            <button id="share-order" class="button secondary-button" onclick="shareOrder()">Share Confirmation</button>
        </section>


        <!-- Order Fulfillment Section -->
        <section class="card">
            <h2 class="section-title">Order Fulfillment</h2>
            <form id="fulfillment-form" onsubmit="updateOrderStatus(event)">
                <div class="form-group">
                    <input type="text" id="fulfillment-id" class="input-field" placeholder="Order ID" required>
                </div>
                <div class="form-group">
                    <select id="order-status" class="input-field" required>
                        <option value="">Select Status</option>
                        <option value="preparation">Preparation</option>
                        <option value="delivery">Delivery</option>
                        <option value="hand-over">Hand-over</option>
                    </select>
                </div>
                <button type="submit" class="button primary-button">Update Status</button>
            </form>
        </section>

        <!-- Order Data Section -->
        <section class="card">
            <h2 class="section-title">Order Data</h2>
            <form id="edit-order-form" onsubmit="editOrderData(event)">
                <div class="form-group">
                    <input type="text" id="edit-order-id" class="input-field" placeholder="Order ID" required>
                </div>
                <div class="form-group">
                    <input type="text" id="edit-item-name" class="input-field" placeholder="Item Name">
                </div>
                <div class="form-group">
                    <input type="number" id="edit-quantity" class="input-field" placeholder="Quantity">
                </div>
                <div class="form-group">
                    <input type="number" step="0.01" id="edit-price" class="input-field" placeholder="Price">
                </div>
                <button type="submit" class="button secondary-button">Update Order</button>
            </form>
        </section>
    </main>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 Customer Management System. All Rights Reserved.</p>
    </footer>

    <!-- Link to JavaScript -->
    <script src="orderscreen.js"></script>
</body>

</html>