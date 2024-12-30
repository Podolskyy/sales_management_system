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
    <title>Home</title>
    <link rel="stylesheet" href="homestyles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="homescreen.js"></script>
</head>
<body>
    <!-- Drawer Toggle Button -->
    <button class="drawer-toggle" onclick="toggleDrawer()">&#127849;</button>

    <!-- Drawer Navigation -->
    <div class="drawer" id="drawer">
        <div class="drawer-spacer"></div>
        <nav>
            <a href="accountscreen.php">My Account</a>
            <a href="productscreen.php">Products</a>
            <a href="promotionscreen.php">Special Offers</a>
            <a href="aboutscreen.php">About</a>
            <a href="contactscreen.php">Contact Us</a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="main-content">
        <header>
            <h1>Roti Sri Bakery</h1>
            <p>Your Partner in Baking Excellence</p>
        </header>

        <!-- Hero Section -->
        <section class="hero">
            <img src="bakeryhero.png" alt="Freshly baked goods" style="width: 100%; max-height: 400px; object-fit: cover; border-bottom: 5px solid #d42b1e;">
            <h2>Welcome to the Roti Sri Bakery</h2>
            <p>Track sales, manage orders, and grow your bakery business with ease.</p>
        </section>

        <div class="container">
            <!-- Highlights Section -->
            <section class="highlights">
                <h2>Highlights</h2>
                <div class="charts">
                    <canvas id="barChart" style="max-width: 600px; margin: 0 auto;"></canvas>
                    <canvas id="pieChart" style="max-width: 600px; margin: 20px auto;"></canvas>
                </div>
            </section>

            <!-- Customer Reviews Section -->
            <section class="reviews">
                <h2>What Our Customers Say</h2>
                <div class="review-container">
                    <blockquote>
                        <p>"The best bakery in town! Their cakes are always fresh and delicious."</p>
                        <footer>- Happy Customer</footer>
                    </blockquote>
                    <blockquote>
                        <p>"Excellent service and amazing variety. Highly recommend!"</p>
                        <footer>- Loyal Patron</footer>
                    </blockquote>
                </div>
            </section>

            <!-- Daily Specials Section -->
            <section class="specials">
                <h2>Today's Specials</h2>
                <ul>
                    <li>Chocolate Fudge Cake</li>
                    <li>Blueberry Muffins</li>
                    <li>Artisan Sourdough Bread</li>
                    <li>Classic Croissants</li>
                    <li>Gluten-Free Brownies</li>
                </ul>
            </section>
        </div>

        <!-- Footer -->
        <footer>
            <p>&copy; 2024 Bakery Management System. Freshly Baked with Love.</p>
            <p>Follow us: 
                <a href="#">Facebook</a> | 
                <a href="#">Instagram</a> | 
                <a href="#">Twitter</a>
            </p>
            <p><a href="terms.html">Terms & Conditions</a> | <a href="privacy.html">Privacy Policy</a></p>
        </footer>
    </div>

    <script>
        // Drawer Toggle Function
        function toggleDrawer() {
            const drawer = document.getElementById('drawer');
            const mainContent = document.getElementById('main-content');
            drawer.classList.toggle('open');
            mainContent.classList.toggle('drawer-open');
        }

        // Bar Chart for Key Focus Areas
        const barCtx = document.getElementById('barChart').getContext('2d');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Cake Sales', 'Pastries', 'Cookies', 'Breads'],
                datasets: [{
                    label: 'Popularity (%)',
                    data: [75, 60, 50, 80],
                    backgroundColor: ['#ffd1dc', '#ffeb99', '#c1e1c1', '#ffb3b3'],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    title: { display: true, text: 'Top-Selling Bakery Items' }
                },
                scales: {
                    y: { beginAtZero: true, max: 100 }
                }
            }
        });

        // Pie Chart for Revenue Contribution
        const pieCtx = document.getElementById('pieChart').getContext('2d');
        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: ['Online Orders', 'In-Store Purchases'],
                datasets: [{
                    data: [55, 45],
                    backgroundColor: ['#ffd1dc', '#c1e1c1']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' },
                    title: { display: true, text: 'Revenue Contribution: Online vs In-Store' }
                }
            }
        });
    </script>
</body>
</html>
