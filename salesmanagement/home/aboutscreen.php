<?php
session_start();
error_reporting(0);
include('../includes/dbconnection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="accountstyles.css">
</head>
<body>
    <!-- Drawer Toggle Button -->
    <button class="drawer-toggle" onclick="toggleDrawer()">&#127849;</button>

    <!-- Drawer Navigation -->
    <div class="drawer" id="drawer">
        <div class="drawer-spacer"></div>
        <div class="drawer-header">
            <h3>Navigation</h3>
            <button class="close-drawer" onclick="toggleDrawer()">&times;</button>
        </div>
        <nav>
            <a href="homescreen.php">Home</a>
            <a href="accountscreen.php">My Account</a>
            <a href="productscreen.php">Products</a>
            <a href="promotionscreen.php">Special Offers</a>
            <a href="aboutscreen.php">About</a>
            <a href="contactscreen.php">Contact Us</a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="container">
        <header>
            <h1>About Us</h1>
            <p>Your Partner in Baking Excellence</p>
        </header>

        <!-- About Us Section -->
        <section id="about" class="section">
            <h2>Our Story</h2>
            <p>
                At Roti Sri Bakery, we believe in bringing people together through the joy of baking. Since our humble beginnings, we have been committed to creating the freshest and most delightful baked goods. Inspired by the love for traditional recipes and modern innovations, we deliver a wide variety of treats that cater to every taste.
            </p>
            <h2>Our Values</h2>
            <ul>
                <li><strong>Quality:</strong> Only the finest ingredients make it to our bakery.</li>
                <li><strong>Community:</strong> We strive to foster a sense of togetherness in every bite.</li>
                <li><strong>Innovation:</strong> Constantly evolving to bring you new flavors and experiences.</li>
            </ul>
            <h2>Our Mission</h2>
            <p>
                To be your go-to bakery for creating cherished moments with family and friends, while maintaining the highest standards of freshness, flavor, and service.
            </p>
            <h2>Our Vision</h2>
            <p>
                To inspire joy and connection through the universal language of delicious baked goods.
            </p>
        </section>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Roti Sri Bakery. Freshly Baked with Love.</p>
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
