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
    <title>Product Management</title>
    <link rel="stylesheet" href="productstyles.css">
</head>
<body>
    <!-- Navigation Back to Home -->
    <button onclick="navigateToHome()" class="back-button">&larr; Back to Home</button>

    <!-- Refresh Snackbar -->
    <div class="snackbar">
        <button class="refresh-button" onclick="refreshProducts()" title="Refresh">
            <img src="refreshicon.png" alt="Refresh Icon">
        </button>
    </div>

    <header>
        <h1>Products</h1>
    </header>

    <div class="container">
        <!-- Search Product Section -->
        <section id="search-product">
            <h2>Search Product</h2>
            <form onsubmit="searchProduct(event)">
                <div class="form-group">
                    <input type="text" id="search-input" class="input-field" placeholder="Enter product name" required>
                </div>
                <button type="submit" class="button">Search</button>
            </form>
            <p id="search-message" class="message"></p>
        </section>

        <!-- Available Products Section -->
        <section id="available-products">
            <h2>Available Products</h2>
            <div id="product-list" class="product-list">
                <!-- Example products, replace with dynamic content -->
                <div class="product-item">
                    <h3>Product 1</h3>
                    <p>Price: RM10</p>
                    <p>Category: Roti Canai</p>
                </div>
                <div class="product-item">
                    <h3>Product 2</h3>
                    <p>Price: RM15</p>
                    <p>Category: Roti Sarang Burung</p>
                </div>
                <div class="product-item">
                    <h3>Product 3</h3>
                    <p>Price: RM8</p>
                    <p>Category: Roti Gardenia</p>
                </div>
            </div>
        </section>
    </div>

    <footer>
        <p>&copy; 2024 Product Management System. All Rights Reserved.</p>
    </footer>

    <script>
        function navigateToHome() {
            window.location.href = "accountscreen.php"; // Adjust path if needed
        }

        function searchProduct(event) {
            event.preventDefault();
            const searchInput = document.getElementById("search-input").value.toLowerCase();
            const productList = document.querySelectorAll(".product-item");
            let found = false;

            productList.forEach((product) => {
                const productName = product.querySelector("h3").textContent.toLowerCase();
                if (productName.includes(searchInput)) {
                    product.style.display = "block";
                    found = true;
                } else {
                    product.style.display = "none";
                }
            });

            const searchMessage = document.getElementById("search-message");
            searchMessage.textContent = found ? "" : "No products found.";
        }

        function refreshProducts() {
            // Clear search input
            document.getElementById("search-input").value = "";

            // Show all products
            const productList = document.querySelectorAll(".product-item");
            productList.forEach((product) => {
                product.style.display = "block";
            });

            // Clear search message
            const searchMessage = document.getElementById("search-message");
            searchMessage.textContent = "";
        }
    </script>
</body>
</html>
