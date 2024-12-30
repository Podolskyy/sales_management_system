<?php
session_start();
error_reporting(0);
include('dbconnect.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user input
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);
    
    // Validate input
    if (empty($name) || empty($email) || empty($password) || empty($role)) {
        echo "<p style='color: red;'>All fields are required.</p>";
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        
        // Prepare SQL query
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssss", $name, $email, $hashedPassword, $role);
        
        // Execute query
        if ($stmt->execute()) {
            echo "<p style='color: green;'>User added successfully!</p>";
        } else {
            echo "<p style='color: red;'>Error adding user: " . $conn->error . "</p>";
        }
        
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Management</title>
    <link rel="stylesheet" href="customerstyles.css">
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
        <h1>Customer Management</h1>
        <p>Manage your customers with ease.</p>
    </header>

    <!-- Main Content -->
    <main>
        <!-- Add New Customer Section -->
        <section class="add-customer">
            <h2 class="section-title">Add New Customer</h2>
            <form id="customer-form" onsubmit="addCustomer(event)" method="post">
                <div class="form-group">
                    <input type="text" id="customer-name" class="input-field" placeholder="Full Name" required>
                </div>
                <div class="form-group">
                    <input type="email" id="customer-email" class="input-field" placeholder="Email Address" required>
                </div>
                <div class="form-group">
                    <input type="text" id="customer-address" class="input-field" placeholder="Delivery Address" required>
                </div>
                <button type="submit" class="button primary-button">Add Customer</button>
            </form>
        </section>

        <!-- Search Customer Section -->
        <section class="search-customer">
            <h2 class="section-title">Search Customer</h2>
            <form onsubmit="searchCustomer(event)">
                <div class="form-group">
                    <input type="text" id="search-input" class="input-field" placeholder="Search by name" required>
                </div>
                <button type="submit" class="button primary-button">Search</button>
            </form>
            <p id="search-message" class="message"></p>
        </section>

        <!-- Customer List -->
        <section class="customer-list">
            <h2 class="section-title">Customer List</h2>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="customer-list">
                        <tr>
                            <td>John Doe</td>
                            <td>john.doe@example.com</td>
                            <td>123 Main Street</td>
                            <td>
                                <button onclick="editCustomer(this)" class="button secondary-button">Edit</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Jane Smith</td>
                            <td>jane.smith@example.com</td>
                            <td>456 Elm Street</td>
                            <td>
                                <button onclick="editCustomer(this)" class="button secondary-button">Edit</button>
                            </td>
                        </tr>
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
