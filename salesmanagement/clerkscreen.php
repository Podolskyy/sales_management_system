
<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Home - Sales Management System</title>
    <link rel="stylesheet" href="clerkstyles.css">
</head>
<body>
    <!-- Drawer Toggle Button -->
    <button class="drawer-toggle" onclick="toggleDrawer()">☰</button>

    <!-- Drawer Navigation -->
    <nav id="drawer" class="drawer">
        <div class="drawer-spacer"></div>
        <ul class="drawer-menu">
            <li><a href="customerscreen.php">Customer Management</a></li>
            <li><a href="orderscreen.php">Order Management</a></li>
            <li><a href="purchasescreen.php">Payment Processing</a></li>
            <li><a href="inventoryscreen.php">Inventory Management</a></li>
            <li><a href="accountscreen.php">Logout</a></li>
        </ul>
    </nav>

    <!-- Header Section -->
    <header>
        <h1>Welcome, Clerk!</h1>
        <p>Sales Management System</p>
    </header>

    <!-- Main Content -->
    <main>
        <section class="dashboard">
            <h2>Dashboard</h2>
            <p>Access all key functionalities for sales order processing and data management.</p>
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