<?php
session_start();
error_reporting(0);
include('dbconnect.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user input
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    // Validate input
    if (empty($email) || empty($password) || empty($role)) {
        echo "<p style='color: red;'>Please fill in all fields.</p>";
    } else {
        // Prepare SQL query to fetch user data based on email and role
        $stmt = $conn->prepare("SELECT id, name, password, role FROM users WHERE email = ? AND role = ?");
        $stmt->bind_param('ss', $email, $role);

        // Execute query
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if user exists
        if ($result->num_rows == 1) {
            // Fetch user data
            $user = $result->fetch_assoc();

            // Verify password
            if (password_verify($password, $user['password'])) {
                // Store user info in session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_role'] = $user['role'];

                // Redirect to clerkscreen.php upon successful login
                header('Location: clerkscreen.php');
                exit;  // Make sure to exit after header redirect to avoid further processing
            } else {
                echo "<p style='color: red;'>Invalid email or password.</p>";
            }
        } else {
            echo "<p style='color: red;'>No user found with the given email and role, or incorrect credentials.</p>";
        }

        $stmt->close();
    }
}

$conn->close();
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
            <a href="homescreen.html">Home</a>
            <a href="accountscreen.html">My Account</a>
            <a href="productscreen.html">Products</a>
            <a href="promotionscreen.html">Special Offers</a>
            <a href="aboutscreen.html">About</a>
            <a href="contactscreen.html">Contact Us</a>
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
            <form method="POST">
                <div class="form-group">
                    <label for="login-email">Email:</label>
                    <input type="email" id="login-email" name="email" class="input-field" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="login-password">Password:</label>
                    <input type="password" id="login-password" name="password" class="input-field" placeholder="Enter your password" required>
                </div>
                <div class="form-group">
                    <label for="login-role">Login As:</label>
                    <select id="login-role" name="role" class="input-field" required>
                        <option value="" disabled selected>Choose your role</option>
                        <option value="admin">Administrator</option>
                        <option value="sales-supervisor">Sales Supervisor</option>
                        <option value="clerk">Clerk</option>
                    </select>
                </div>
                <button type="submit" class="button">Login</button>
            </form>
            <div class="helper-links">
                <p>
                    <a href="#" class="link">Forgotten your password?</a>
                </p>
                <p>
                    Don’t have an account? <a href="registerscreen.html" class="link">Sign up</a>
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
    <script src="accountscreen.js"></script>
    <script>
        function toggleDrawer() {
            const drawer = document.getElementById('drawer');
            drawer.classList.toggle('open');
        }
    </script>
</body>

</html>