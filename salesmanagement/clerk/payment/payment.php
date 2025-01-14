<?php
session_start();
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id']; // Access the user_id stored in the session
} else {
    // Handle case where the user is not logged in
    header('Location: ../../home/accountscreen.php');
    echo "You are not logged in.";
}

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id']; // Access the user_id stored in the session
} else {
    // Handle case where the user is not logged in
    echo "You are not logged in.";
}

include 'C:/xampp/htdocs/salesmanagement/includes/dbconnection.php';

$totalPrice = 0;  // Initialize total price variable

// Step 1: Calculate total price of the items in the cart
$cartQuery = "SELECT p.product_id, p.product_name, p.product_price, c.amount as quantity
              FROM cart c
              JOIN products p ON c.product_id = p.product_id
              WHERE c.user_id = ?";
$stmt = $conn->prepare($cartQuery);
$stmt->bind_param("i", $userId);
$stmt->execute();
$cartItems = $stmt->get_result();  // Fetch the cart items here

// Calculate the total price of the items
while ($item = $cartItems->fetch_assoc()) {
    $itemTotalPrice = $item['product_price'] * $item['quantity'];
    $totalPrice += $itemTotalPrice;
}

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if payment_method and purchase_type are set
    if (
        isset($_POST['payment_method']) && !empty($_POST['payment_method']) &&
        isset($_POST['purchase_type']) && !empty($_POST['purchase_type'])
    ) {
        $paymentMethod = $_POST['payment_method'];  // Payment method from form
        $purchaseType = $_POST['purchase_type'];    // Purchase type from form
        $status = 'Preparing';

        // Step 2: Insert the order into the `orders` table
        $orderQuery = "INSERT INTO orders (user_id, total_price, status, payment_method, type) 
                       VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($orderQuery);
        $stmt->bind_param("idsss", $userId, $totalPrice, $status, $paymentMethod, $purchaseType);
        $stmt->execute();
        $orderId = $stmt->insert_id;  // Get the last inserted order_id

        // Step 3: Insert items into the `order_items` table and decrease stock
        $cartItems->data_seek(0);  // Reset result pointer to the start
        while ($item = $cartItems->fetch_assoc()) {
            $foodId = $item['product_id'];
            $quantity = $item['quantity'];
            $itemPrice = $item['product_price'];  // 'price' is the column in the products table
            $itemTotalPrice = $itemPrice * $quantity;

            // Insert each cart item into the order_items table
            $insertItemQuery = "INSERT INTO order_items (order_id, food_id, quantity, price, total_price) 
                                VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insertItemQuery);
            $stmt->bind_param("iiidi", $orderId, $foodId, $quantity, $itemPrice, $itemTotalPrice);
            $stmt->execute();

            // Step 4: Decrease stock quantity in the products table
            $updateStockQuery = "UPDATE products SET stock_quantity = stock_quantity - ? WHERE product_id = ?";
            $stmt = $conn->prepare($updateStockQuery);
            $stmt->bind_param("ii", $quantity, $foodId);
            $stmt->execute();
        }

        // Step 5: Clear the cart after order (optional)
        $clearCartQuery = "DELETE FROM cart WHERE user_id = ?";
        $stmt = $conn->prepare($clearCartQuery);
        $stmt->bind_param("i", $userId);
        $stmt->execute();

        // Set a session variable to show that the order has been placed successfully
        $_SESSION['order_placed'] = true;
    } else {
        // Handle error if payment_method or purchase_type is not provided
        echo "Error: Please select both a payment method and purchase type.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clerk Checkout</title>
    <link rel="stylesheet" href="orderstyles.css">
</head>

<body>
    <div class="container">

        <?php if (isset($_SESSION['order_placed']) && $_SESSION['order_placed']): ?>
            <!-- Receipt Section (After Order is Placed) -->
            <h2>Receipt</h2>
            <p><strong>Order ID:</strong> <?php echo $orderId; ?></p>
            <p><strong>Payment Method:</strong> <?php echo htmlspecialchars($paymentMethod); ?></p>
            <p><strong>Purchase Type:</strong> <?php echo htmlspecialchars($purchaseType); ?></p>
            <h3>Items Ordered:</h3>
            <table border='1'>
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Unit Price</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Reset the cart items for display in the receipt
                    $cartItems->data_seek(0);
                    while ($item = $cartItems->fetch_assoc()) {
                        $itemTotalPrice = $item['product_price'] * $item['quantity'];
                        echo "<tr>
                                <td>" . htmlspecialchars($item['product_name']) . "</td>
                                <td>RM " . number_format($item['product_price'], 2) . "</td>
                                <td>" . $item['quantity'] . "</td>
                                <td>RM " . number_format($itemTotalPrice, 2) . "</td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
            <p><strong>Total Price: RM <?php echo number_format($totalPrice, 2); ?></strong></p>

            <!-- Download Receipt Button -->
            <button onclick="downloadReceipt()">Download Receipt</button>

            <!-- Back Button -->
            <button onclick="window.location.href='../purchase/purchasescreen.php'">Back</button>

            <?php unset($_SESSION['order_placed']); ?>
        <?php else: ?>
            <!-- Cart and Checkout Form -->
            <h2>Your Cart</h2>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Unit Price</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Display cart items even if the form has been submitted
                    $cartItems->data_seek(0);  // Reset result pointer to the start
                    if ($cartItems->num_rows > 0) {
                        while ($row = $cartItems->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . htmlspecialchars($row['product_name']) . "</td>
                                    <td>RM" . number_format($row['product_price'], 2) . "</td>
                                    <td>" . $row['quantity'] . "</td>
                                    <td>RM" . number_format($row['product_price'] * $row['quantity'], 2) . "</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>Your cart is empty.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <div class="cart-footer">
                <p>Total: RM<?php echo number_format($totalPrice, 2); ?></p>
                <form action="" method="POST">
                    <label for="payment_method">Payment Method:</label>
                    <select name="payment_method" id="payment_method" required>
                        <option value="Cash">Cash</option>
                        <option value="Card">Card</option>
                    </select>

                    <label for="purchase_type">Purchase Type:</label>
                    <select name="purchase_type" id="purchase_type" required>
                        <option value="In-store">In-store</option>
                        <option value="Telephone">Telephone</option>
                    </select>

                    <button type="submit">Order Now</button>
                </form>
            </div>
        <?php endif; ?>

    </div>

    <script>
        // Function to download the receipt as an HTML file
        function downloadReceipt() {
            const receiptContent = document.querySelector('.container').innerHTML;
            const blob = new Blob([receiptContent], { type: 'text/html' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'receipt_order_<?php echo $orderId; ?>.html';
            link.click();
        }
    </script>

</body>

</html>
