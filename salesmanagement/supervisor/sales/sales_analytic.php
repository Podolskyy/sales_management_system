<?php
session_start();
// Include database connection file
include 'C:/xampp/htdocs/salesmanagement/includes/dbconnection.php';

// Total revenue
$totalRevenueQuery = "SELECT SUM(total_price) AS total_revenue FROM orders";
$totalRevenueResult = $conn->query($totalRevenueQuery);
$totalRevenue = $totalRevenueResult->fetch_assoc()['total_revenue'];

// Sales by status
$salesByStatusQuery = "SELECT status, COUNT(order_id) AS total_orders, SUM(total_price) AS revenue
                       FROM orders GROUP BY status";
$salesByStatusResult = $conn->query($salesByStatusQuery);

// Sales by payment method
$paymentMethodQuery = "SELECT payment_method, COUNT(order_id) AS total_orders, SUM(total_price) AS revenue
                       FROM orders GROUP BY payment_method";
$paymentMethodResult = $conn->query($paymentMethodQuery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Analytics</title>
    <link rel="stylesheet" href="analyticsstyles.css">
</head>

<body>
    <!-- Drawer Toggle Button -->
    <button class="drawer-toggle" onclick="toggleDrawer()">&#9776;</button>

    <!-- Drawer Navigation -->
    <div class="drawer" id="drawer">
        <div class="drawer-spacer"></div>
        <nav>
            <a href="../main/supervisorscreen.php">My Account</a>
            <a href="../user/userscreen.php">Manage Users</a>
            <a href="../purchase/purchasescreen.php">Manage Orders</a>
            <a href="../inventory/inventoriescreen.php">Manage Stock</a>
            <a href="../report/reportscreen.php">View Reports</a>
            <a href="../../home/accountscreen.php">Logout</a>
        </nav>
    </div>

    <header>
        Sales Analytics
    </header>

    <div class="container">
        <h2>Total Revenue: RM<?php echo number_format($totalRevenue, 2); ?></h2>

        <h3>Sales by Status</h3>
        <table class="analytics-table">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Total Orders</th>
                    <th>Revenue</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $salesByStatusResult->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td><?php echo htmlspecialchars($row['total_orders']); ?></td>
                        <td>RM<?php echo number_format($row['revenue'], 2); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h3>Sales by Payment Method</h3>
        <table class="analytics-table">
            <thead>
                <tr>
                    <th>Payment Method</th>
                    <th>Total Orders</th>
                    <th>Revenue</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $paymentMethodResult->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['payment_method']); ?></td>
                        <td><?php echo htmlspecialchars($row['total_orders']); ?></td>
                        <td>RM<?php echo number_format($row['revenue'], 2); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Sales Management System. Analytics for Better Decisions.</p>
    </footer>

    <script>
        function toggleDrawer() {
            const drawer = document.getElementById('drawer');
            drawer.classList.toggle('open');
        }
    </script>
</body>

</html>