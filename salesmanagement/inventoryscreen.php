<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management - Sales Management System</title>
    <link rel="stylesheet" href="inventorystyles.css">
</head>
<body>
    <!-- Drawer Toggle Button -->
    <button class="drawer-toggle" onclick="toggleDrawer()">☰</button>

    <!-- Drawer Navigation -->
    <nav id="drawer" class="drawer">
        <ul class="drawer-menu">
            <li><a href="clerkscreen.php">🏠 Dashboard</a></li>
            <li><a href="customerscreen.php">👥 Customer Management</a></li>
            <li><a href="orderscreen.php">📦 Order Management</a></li>
            <li><a href="inventoryscreen.php" class="active">📋 Inventory Management</a></li>
            <li><a href="accountscreen.php" onclick="return confirm('Are you sure you want to logout?')">🔒 Logout</a></li>
        </ul>
    </nav>

    <!-- Header Section -->
    <header>
        <h1>Inventory Management</h1>
        <p>Manage stock levels efficiently during order processing.</p>
    </header>

    <!-- Main Content -->
    <main>
        <section class="inventory">
            <h2>Inventory Data</h2>
            <table class="inventory-table">
                <thead>
                    <tr>
                        <th>Item ID</th>
                        <th>Item Name</th>
                        <th>Category</th>
                        <th>Stock Level</th>
                        <th>Last Updated</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>101</td>
                        <td>Item A</td>
                        <td>Electronics</td>
                        <td>50</td>
                        <td>2024-12-28</td>
                    </tr>
                    <tr>
                        <td>102</td>
                        <td>Item B</td>
                        <td>Home Appliances</td>
                        <td>20</td>
                        <td>2024-12-28</td>
                    </tr>
                    <!-- Additional rows can be dynamically added -->
                </tbody>
            </table>
        </section>
    </main>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 Sales Management System. All Rights Reserved.</p>
    </footer>

    <!-- Script for Drawer -->
    <script>
        function toggleDrawer() {
            const drawer = document.getElementById('drawer');
            drawer.classList.toggle('open');
        }
    </script>
</body>
</html>
