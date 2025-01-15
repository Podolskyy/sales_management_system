<?php
session_start();
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id']; // Access the user_id stored in the session
} else {
    // Handle case where the user is not logged in
    echo "You are not logged in.";
}

// Include database connection file
include 'C:/xampp/htdocs/salesmanagement/includes/dbconnection.php';


// Initialize the total price
$totalPrice = 0;

// Fetch the cart details from the database
$query = "SELECT p.product_id, p.product_name, p.product_price, p.product_image, c.amount as quantity 
          FROM cart c
          JOIN products p ON c.product_id = p.product_id
          WHERE c.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="orderstyles.css">
</head>

<body>
    <!-- Drawer Toggle Button -->
    <button class="drawer-toggle" onclick="toggleDrawer()">&#127849;</button>

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

    <header>
        Shopping Cart
    </header>

    <div class="container">
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="product-info">
                                <img src="<?php echo htmlspecialchars($row['product_image']); ?>" alt="<?php echo htmlspecialchars($row['product_name']); ?>" class="product-image">
                                <span><?php echo htmlspecialchars($row['product_name']); ?></span>
                            </td>
                            <td>RM<?php echo number_format($row['product_price'], 2); ?></td>
                            <td>
                                <form action="order.php" method="POST" class="quantity-form">
                                    <input type="hidden" name="action" value="update">
                                    <input type="hidden" name="productId" value="<?php echo $row['product_id']; ?>">
                                    <input type="number" name="quantity" value="<?php echo $row['quantity']; ?>" min="1" class="quantity-input">
                                    <button type="submit" class="update-btn">Update</button>
                                </form>
                            </td>
                            <td>RM<?php echo number_format($row['product_price'] * $row['quantity'], 2); ?></td>
                            <td>
                                <form action="order.php" method="POST" class="action-form">
                                    <input type="hidden" name="action" value="remove">
                                    <input type="hidden" name="productId" value="<?php echo $row['product_id']; ?>">
                                    <button type="submit" class="remove-btn">Remove</button>
                                </form>
                            </td>
                        </tr>
                        <?php
                        // Update the total price by adding the current product's total
                        $totalPrice += $row['product_price'] * $row['quantity'];
                        ?>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">Your cart is empty.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="cart-footer">
            <p>Total: RM<?php echo number_format($totalPrice, 2); ?></p>
            <form action="order.php" method="POST">
                <input type="hidden" name="action" value="clear">
                <button type="submit" class="clear-btn">Clear Cart</button>
            </form>
            <a href="../payment/payment.php"><button class="checkout-btn">Checkout</button></a>
        </div>
    </div>

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
