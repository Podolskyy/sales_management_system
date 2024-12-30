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
    <title>Payment Management</title>
    <link rel="stylesheet" href="paymentstyles.css">
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
        <h1>Payment Management</h1>
        <p>Manage your customers with ease.</p>
    </header>

    <!-- Main Content -->
    <main>

        <!-- Payment Processing Section -->
        <section class="card">
            <h2 class="section-title">Payment Processing</h2>
            <form id="payment-form" onsubmit="processPayment(event)">
                <div class="form-group">
                    <label for="payment-amount">Payment Amount</label>
                    <input type="number" id="payment-amount" class="input-field" placeholder="Enter amount" required>
                </div>
                <div class="form-group">
                    <label for="payment-method">Payment Method</label>
                    <select id="payment-method" class="input-field" required>
                        <option value="">Select Payment Method</option>
                        <option value="cash">Cash</option>
                        <option value="card">Card</option>
                        <option value="online">Online</option>
                    </select>
                </div>
                <button type="submit" class="button primary-button">Record Payment</button>
            </form>
        </section>

        <!-- Payment Records Section -->
        <section class="card">
            <h2 class="section-title">Payment Records</h2>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Customer Name</th>
                            <th>Date</th>
                            <th>Payment Method</th>
                            <th>Amount</th>
                            <th>Product/Service</th>
                        </tr>
                    </thead>
                    <tbody id="payment-records">
                        <!-- Dynamic rows will be added here -->
                    </tbody>
                </table>
            </div>
        </section>

    </main>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 Customer Management System. All Rights Reserved.</p>
    </footer>

    <!-- Link to JavaScript -->
    <script src="customerscreen.js"></script>
</body>
</html>
