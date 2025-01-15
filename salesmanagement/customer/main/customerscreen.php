<?php
session_start();

// Implementing Session Fixation Protection
// Regenerate session ID to prevent session fixation attacks
if (isset($_SESSION['user_id'])) {
    session_regenerate_id(true); // Regenerate session ID to prevent session fixation
    $userId = $_SESSION['user_id']; // Access the user_id stored in the session
} else {
    // Handle case where the user is not logged in
    header('Location: ../../home/accountscreen.php');
    exit(); // Make sure no further code is executed
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Page</title>
    <link rel="stylesheet" href="customerstyles.css">
</head>



<body>
    <!-- Drawer Toggle Button -->
    <button class="drawer-toggle" onclick="toggleDrawer()">☰</button>

    <!-- Drawer Navigation -->
    <nav id="drawer" class="drawer">
        <div class="drawer-spacer"></div>
        <ul class="drawer-menu">
            <li><a href="../main/customerscreen.php">My Account</a></li>
            <li><a href="../product/productscreen.php">Order</a></li>
            <li><a href="../order/orderscreen.php">My Cart</a></li>
            <li><a href="../purchase/purchasescreen.php">My Purchases</a></li>
            <li><a href="../../home/accountscreen.php">Logout</a></li>
        </ul>
    </nav>

    <!-- Header Section -->
    <header>
        <h1>Welcome!</h1>
        <p>Roti Sri Bakery</p>
    </header>

    <!-- Main Content -->
    <main>
        <section class="dashboard">
            <h2>Dashboard</h2>
            <p>Access all your orders from here.</p>
        </section>
    </main>

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