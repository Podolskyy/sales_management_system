<?php
session_start();

include('../../includes/dbconnection.php');

// Query to fetch all user information from the `users` table
$query = "SELECT * FROM users";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Information</title>
    <link rel="stylesheet" href="userstyles.css">
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

    <!-- Main Content -->
    <div class="container">
        <header>
            <h1>Roti Sri Bakery</h1>
            <p>Your Partner in Baking Excellence</p>
        </header>

        <!-- User Information Section -->
        <section id="user-info" class="section">
            <h2>All Users</h2>
            <p>Below is the list of all users in the system:</p>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th> <!-- Replaced "Phone" with "Role" -->
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && mysqli_num_rows($result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                                <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['user_email']); ?></td>
                                <td><?php echo htmlspecialchars($row['user_type']); ?></td> <!-- Removed Address & Role -->
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">No users found.</td> <!-- Adjusted column count -->
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Krispy Kreme Management System. Freshly Baked with Love.</p>
        <p>Follow us:
            <a href="#">Facebook</a> |
            <a href="#">Instagram</a> |
            <a href="#">Twitter</a>
        </p>
        <p><a href="terms.html">Terms & Conditions</a> | <a href="privacy.html">Privacy Policy</a></p>
    </footer>

    <!-- JavaScript -->
    <script>
        function toggleDrawer() {
            const drawer = document.getElementById('drawer');
            drawer.classList.toggle('open');
        }
    </script>
</body>

</html>