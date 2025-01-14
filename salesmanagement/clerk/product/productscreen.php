<?php
session_start();
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id']; // Access the user_id stored in the session
} else {
    // Handle case where the user is not logged in
    header('Location: ../../home/accountscreen.php');
    echo "You are not logged in.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="productstyles.css?v=<?php echo time(); ?>">
    <title>Product Screen</title>
    <script src="productscreen.js"></script>
</head>

<body>
    <!-- Drawer Toggle Button -->
    <button class="drawer-toggle" onclick="toggleDrawer()">&#127849;</button>

    <button class="fab-add-to-cart" onclick="window.location.href='../order/orderscreen.php';">
        <img src="cart.png" alt="Cart" class="fab-icon">
    </button>



    <!-- Drawer Navigation -->
    <div class="drawer" id="drawer">
        <div class="drawer-spacer"></div>
        <nav>
            <a href="../main/clerkscreen.php">My Account</a>
            <a href="../product/productscreen.php">In-store Order</a>
            <a href="../purchase/purchasescreen.php">Manage Order</a>
            <a href="../../home/accountscreen.php">Logout</a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="main-content"></div>
    <header>
        <h1>Products</h1>
    </header>

    <section class="search-container">
        <input
            type="text"
            id="search-input"
            placeholder="Search for products..."
            onkeypress="handleKeyPress(event)" />
        <button id="search-button" onclick="searchProducts()">Search</button>
    </section>

    <section class="tabs">
        <button class="tab active" data-category="All">All</button>
        <button class="tab" data-category="Bread">Bread</button>
        <button class="tab" data-category="Pastries">Pastries</button>
        <button class="tab" data-category="Cakes">Cakes</button>
    </section>

    <section class="orders" id="product-list">
        <!-- Products will be dynamically loaded here -->
    </section>

    <footer>
        <p>&copy; 2024 Roti Sri Bakery System. Freshly Baked with Love.</p>
        <p>Follow us:
            <a href="#">Facebook</a> |
            <a href="#">Instagram</a> |
            <a href="#">Twitter</a>
        </p>
        <p><a href="terms.html">Terms & Conditions</a> | <a href="privacy.html">Privacy Policy</a></p>
    </footer>
</body>

</html>