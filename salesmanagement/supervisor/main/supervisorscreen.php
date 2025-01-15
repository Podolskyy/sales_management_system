<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supervisor Page</title>
    <link rel="stylesheet" href="supervisorstyles.css">
</head>



<body>
    <!-- Drawer Toggle Button -->
    <button class="drawer-toggle" onclick="toggleDrawer()">☰</button>

    <!-- Drawer Navigation -->
    <nav id="drawer" class="drawer">
        <div class="drawer-spacer"></div>
        <ul class="drawer-menu">
            <li><a href="supervisorscreen.php">My Account</a></li>
            <li><a href="../user/userscreen.php">Manage Users</a></li>
            <li><a href="../purchase/purchasescreen.php">Manage Orders</a></li>
            <li><a href="../sales/sales_analytic.php">View Reports</a></li>
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
            <p>Access all about our business from here.</p>
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