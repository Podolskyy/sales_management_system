<?php
session_start();
// Include database connection file
include 'C:/xampp/htdocs/salesmanagement/includes/dbconnection.php';

// Query to get all orders from the `orders` table
$orderQuery = "SELECT order_id, user_id, total_price, status, payment_method, created_at
               FROM orders
               ORDER BY FIELD(status, 'Preparing', 'On Delivery', 'Fulfilled'), created_at DESC";

$result = $conn->query($orderQuery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Orders</title>
    <link rel="stylesheet" href="purchasestyles.css">
</head>

<body>
    <!-- Drawer Toggle Button -->
    <button class="drawer-toggle" onclick="toggleDrawer()">&#127849;</button>

    <!-- Drawer Navigation -->
    <div class="drawer" id="drawer">
        <div class="drawer-spacer"></div>
        <nav>
        <a href="../main/supervisorscreen.php">My Account</a>
            <a href="../user/userscreen.php">Manage Users</a>
            <a href="../purchase/purchasescreen.php">Manage Orders</a>
            <a href="../sales/sales_analytic.php">View Reports</a>
            <a href="../../home/accountscreen.php">Logout</a>
        </nav>
    </div>

    <header>
        All Customer Orders
    </header>

    <div class="container">
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User ID</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Payment Method</th>
                    <th>Order Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['order_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                            <td>RM<?php echo number_format($row['total_price'], 2); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                            <td><?php echo htmlspecialchars($row['payment_method']); ?></td>
                            <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                            <td>
                                <!-- Action Button to change status to "On Delivery" -->
                                <?php if ($row['status'] === 'Preparing'): ?>
                                    <form action="update_status.php" method="POST" class="action-form">
                                        <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
                                        <input type="hidden" name="status" value="On Delivery">
                                        <button type="submit" class="update-btn">To Delivery</button>
                                    </form>
                                <?php elseif ($row['status'] === 'On Delivery'): ?>
                                    <span>On Delivery</span>
                                <?php else: ?>
                                    <span>Fulfilled</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No orders found.</td>
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
