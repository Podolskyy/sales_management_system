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

    <!-- Custom Modal -->
    <div id="custom-modal" class="modal">
        <div class="modal-content">
            <h2>Add Product to Cart</h2>
            <p>Enter the Product ID to add to cart:</p>
            <input type="text" id="product-id-input" placeholder="Enter Product ID">
            <div class="modal-actions">
                <button onclick="confirmAddToCart()" class="modal-btn confirm">Add</button>
                <button onclick="closeModal()" class="modal-btn cancel">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Drawer Navigation -->
    <div class="drawer" id="drawer">
        <div class="drawer-spacer"></div>
        <nav>
            <a href="../main/customerscreen.php">My Account</a>
            <a href="../product/productscreen.php">Order</a>
            <a href="../order/orderscreen.php">My Cart</a>
            <a href="../purchase/purchasescreen.php">My Purchases</a>
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