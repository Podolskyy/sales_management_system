<?php
session_start();
include('../includes/dbconnection.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data and sanitize
    $user_name = mysqli_real_escape_string($conn, $_POST['signup-name']);
    $user_email = mysqli_real_escape_string($conn, $_POST['signup-email']);
    $user_password = mysqli_real_escape_string($conn, $_POST['signup-password']);
    $user_confirmpassword = mysqli_real_escape_string($conn, $_POST['signup-confirmpassword']);
    $user_address = mysqli_real_escape_string($conn, $_POST['signup-address']);

    // Check if passwords match
    if ($user_password !== $user_confirmpassword) {
        echo "Passwords do not match.";
    } else {
        // Hash the password using bcrypt
        $hashed_password = password_hash($user_password, PASSWORD_BCRYPT);

        // Insert data into database
        $query = "INSERT INTO users (user_name, user_email, user_password, user_address, user_type) 
                  VALUES ('$user_name', '$user_email', '$hashed_password', '$user_address', 'Customer')";

        if (mysqli_query($conn, $query)) {
            echo "Registration successful!";
            // Optionally, redirect to a login page or home
            header("Location: homescreen.php");
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
            <h1>Roti Sri Bakery</h1>
            <p>Your Partner in Baking Excellence</p>
        </header>

        <!-- Registration Section -->
        <section id="signup" class="section">
            <h2>Create Your Account</h2>
            <form method="POST">
                <div class="form-group">
                    <label for="signup-name">Name:</label>
                    <input type="text" id="signup-name" name="signup-name" class="input-field" placeholder="Enter your name" required>
                </div>
                <div class="form-group">
                    <label for="signup-address">Address:</label>
                    <input type="text" id="signup-address" name="signup-address" class="input-field" placeholder="Enter your name" required>
                </div>
                <div class="form-group">
                    <label for="signup-email">Email:</label>
                    <input type="email" id="signup-email" name="signup-email" class="input-field" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="signup-password">Password:</label>
                    <input type="password" id="signup-password" name="signup-password" class="input-field" placeholder="Enter your password" required>
                </div>
                <div class="form-group">
                    <label for="signup-confirmpassword">Confirm Password:</label>
                    <input type="password" id="signup-confirmpassword" name="signup-confirmpassword" class="input-field" placeholder="Confirm your password" required>
                </div>
                <button type="submit" class="button">Sign Up</button>
            </form>
            <div class="helper-links">
                <p>
                    Already have an account? <a href="accountscreen.php" class="link">Login here</a>
                </p>
            </div>
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
