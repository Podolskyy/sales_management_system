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
    <title>Contact Us</title>
    <link rel="stylesheet" href="accountstyles.css">
</head>
<body>
    <!-- Drawer Toggle Button -->
    <button class="drawer-toggle" onclick="toggleDrawer()">&#127849;</button>

    <!-- Drawer Navigation -->
    <div class="drawer" id="drawer">
        <div class="drawer-header">
            <h3>Navigation</h3>
            <button class="close-drawer" onclick="toggleDrawer()">&times;</button>
        </div>
        <nav>
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
            <h1>Contact Us</h1>
            <p>We’re Here to Help</p>
        </header>

        <!-- Contact Form Section -->
        <section id="contact" class="section">
            <h2>Get in Touch</h2>
            <p>We’d love to hear from you! Fill out the form below, and we’ll get back to you as soon as possible.</p>
            <form>
                <div class="form-group">
                    <label for="contact-name">Name:</label>
                    <input type="text" id="contact-name" class="input-field" placeholder="Enter your name" required>
                </div>
                <div class="form-group">
                    <label for="contact-email">Email:</label>
                    <input type="email" id="contact-email" class="input-field" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="contact-message">Message:</label>
                    <textarea id="contact-message" class="input-field" placeholder="Write your message" rows="5" required></textarea>
                </div>
                <button type="submit" class="button">Send Message</button>
            </form>
            <h2>Visit Us</h2>
            <p>
                <strong>Roti Sri Bakery Headquarters</strong><br>
                123 Baking Lane, Kuala Lumpur, Malaysia<br>
                <strong>Phone:</strong> +60 123 456 789<br>
                <strong>Email:</strong> <a href="mailto:support@rotisribakery.com">support@rotisribakery.com</a>
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
