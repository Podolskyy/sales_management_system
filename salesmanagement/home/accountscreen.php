<?php
session_start();
session_unset();  // Remove all session variables
session_destroy();  // Destroy the session
session_start();


include('../includes/dbconnection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $email = mysqli_real_escape_string($conn, $_POST['login-email']);
    $password = $_POST['login-password'];
    $role = mysqli_real_escape_string($conn, $_POST['login-role']);

    // Query to fetch user information
    $query = "SELECT user_id, user_password, user_type FROM users WHERE user_email = '$email'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Verify password and role
        if (password_verify($password, $row['user_password']) && $role === $row['user_type']) {
            // Set the session variable for user_id
            $_SESSION['user_id'] = $row['user_id']; // Store the user ID in the session

            // Redirect based on role
            if ($role === 'Customer') {
                header('Location: ../customer/main/customerscreen.php');
            } elseif ($role === 'Clerk') {
                header('Location: ../clerk/main/clerkscreen.php');
            } elseif ($role === 'Supervisor') {
                header('Location: ../supervisor/main/supervisorscreen.php');
            }
            exit(); // Ensure no further execution
        } else {
            $error_message = "User info is not correct.";
        }
    } else {
        $error_message = "User info is not correct.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Krispy Kreme Login</title>
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

        <!-- Login Section -->
        <section id="login" class="section">
            <h2>Welcome Back!</h2>
            <p>Please log in to your account</p>
            <?php if (isset($error_message)): ?>
                <p class="error-message"><?php echo $error_message; ?></p>
            <?php endif; ?>
            <form method="POST">
                <div class="form-group">
                    <label for="login-email">Email:</label>
                    <input type="email" id="login-email" name="login-email" class="input-field" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="login-password">Password:</label>
                    <input type="password" id="login-password" name="login-password" class="input-field" placeholder="Enter your password" required>
                </div>
                <div class="form-group">
                    <label for="login-role">Login As:</label>
                    <select id="login-role" name="login-role" class="input-field" required>
                        <option value="" disabled selected>Choose your role</option>
                        <option value="Customer">Customer</option>
                        <option value="Clerk">Clerk</option>
                        <option value="Supervisor">Supervisor</option>
                    </select>
                </div>
                <button type="submit" class="button">Login</button>
            </form>
            <div class="helper-links">
                <p>
                    <a href="#" class="link">Forgotten your password?</a>
                </p>
                <p>
                    Don’t have an account? <a href="registerscreen.php" class="link">Sign up</a>
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
