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



// Query to get all orders from the `orders` table for the logged-in user and sort based on status
$orderQuery = "SELECT order_id, total_price, status, payment_method, created_at
               FROM orders 
               WHERE user_id = ?
               ORDER BY CASE status
                            WHEN 'On Delivery' THEN 1
                            WHEN 'Preparing' THEN 2
                            WHEN 'Fulfilled' THEN 3
                            ELSE 4
                        END ASC";

$stmt = $conn->prepare($orderQuery);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Purchases</title>
    <link rel="stylesheet" href="purchasestyles.css">
</head>

<body>
    <!-- Drawer Toggle Button -->
    <button class="drawer-toggle" onclick="toggleDrawer()">&#127849;</button>

    <!-- Drawer Navigation -->
    <div class="drawer" id="drawer">
        <div class="drawer-spacer"></div>
        <nav>
            <a href="../main/customerscreen.php">My Account</a>
            <a href="../product/productscreen.php">Order</a>
            <a href="../order/orderscreen.php">My Cart</a>
            <a href="">My Purchases</a>
            <a href="../../home/accountscreen.php">Logout</a>
        </nav>
    </div>

    <header>
        My Purchases
    </header>

    <div class="container">
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Payment Method</th>
                    <th>Order Date</th>
                    <th>Action</th> <!-- New Action column -->
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['order_id']); ?></td>
                            <td>RM<?php echo number_format($row['total_price'], 2); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                            <td><?php echo htmlspecialchars($row['payment_method']); ?></td>
                            <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                            <td>
                                <!-- Action Button to change status to "Fulfilled" -->
                                <?php if ($row['status'] !== 'Fulfilled'): ?>
                                    <form action="update_status.php" method="POST" class="action-form">
                                        <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
                                        <input type="hidden" name="status" value="Fulfilled">
                                        <button type="submit" class="update-btn">Order Received</button>
                                    </form>
                                <?php else: ?>
                                    <span>Order Fulfilled</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">You have not made any purchases yet.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Roti Sri Bakery System. Freshly Baked with Love.</p>
        <p>Follow us:
            <a href="#">Facebook</a> |
            <a href="#">Instagram</a> |
            <a href="#">Twitter</a>
        </p>
        <p><a href="terms.html">Terms & Conditions</a> | <a href="privacy.html">Privacy Policy</a></p>
    </footer>

    <script>
        function toggleDrawer() {
            const drawer = document.getElementById('drawer');
            drawer.classList.toggle('open');
        }
    </script>
</body>

</html>
