<?php
session_start();

// Handle quantity update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['product']) && isset($_POST['action'])) {
        $product = $_POST['product'];
        if ($_POST['action'] == 'increase' && isset($_SESSION['cart'][$product])) {
            $_SESSION['cart'][$product]['quantity'] += 1;
        }
        if ($_POST['action'] == 'decrease' && isset($_SESSION['cart'][$product])) {
            if ($_SESSION['cart'][$product]['quantity'] > 1) {
                $_SESSION['cart'][$product]['quantity'] -= 1;
            } else {
                unset($_SESSION['cart'][$product]);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Cart - SeyssingComp</title>
    <!-- Include CSS links for icons and fonts -->
    <!-- Replace with your actual links -->
</head>
<body>

<!-- header -->   
<header>
    <a href="index.php" class="logo">SeyssingComp.co</a>
    <ul class="navlist" id="navlist">
        <li><a href="shop.php">Shop</a></li>
        <li><a href="hotproducts.php">Hot Products</a></li>
        <li><a href="newarrivals.php">New Arrivals</a></li>
        <li><a href="brands.php">Brands</a></li>
        <li><a href="contact.php">Contact</a></li>
    </ul>

    <div class="nav-right">
        <a href="cart.php"><i class="ri-shopping-cart-2-line"></i><span><?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?></span></a>
        <?php if(isset($_SESSION['username'])): ?>
            <a href="user-profile.php"><i class="ri-user-3-line"></i><?php echo $_SESSION['username']; ?></a>
            <a href="logout.php"><i class="ri-logout-box-r-line"></i></a>
        <?php else: ?>
            <a href="login.php"><i class="ri-user-3-line"></i>Login</a>
        <?php endif; ?>
        <div class="bx bx-menu" id="menu-icon"></div>
    </div>
</header>
<script>
    document.getElementById('menu-icon').addEventListener('click', function() {
        this.classList.toggle('active');
        document.getElementById('navlist').classList.toggle('active');
    });
</script>


<section class="cart">
    <h2>Your Shopping Cart</h2>
    <div class="cart-items">
        <?php 
        $conversion_rate = 11; // 1 USD = 11 GHS
        if (!empty($_SESSION['cart'])): ?>
            <table>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                </tr>
                <?php foreach ($_SESSION['cart'] as $name => $item): ?>
                    <tr>
                        <td><?php echo $name; ?></td>
                        <td>GHS <?php echo number_format($item['price']  ); ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="product" value="<?php echo $name; ?>">
                                <button type="submit" name="action" value="decrease">-</button>
                            </form>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="product" value="<?php echo $name; ?>">
                                <button type="submit" name="action" value="increase">+</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <div class="checkout">
                <a href="checkout.php" class="checkout-button">Proceed to Checkout</a>
            </div>
        <?php else: ?>
            <p>Your cart is empty.</p>
            <br>
            <a href="index.php" class="btn">
            Continue Shopping
            <i class="ri-arrow-right-line"></i>
        </a>
        <?php endif; ?>
    </div>
</section>

</body>
</html>

<style>
    .cart-items table {
    width: 100%;
    border-collapse: collapse;
}

.cart-items table, .cart-items th, .cart-items td {
    border: 1px solid #ddd;
}

.cart-items th, .cart-items td {
    padding: 8px;
    text-align: center;
}

.cart-items th {
    background-color: #f2f2f2;
}

form button {
    background-color: #4CAF50;
    color: white;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
}

form button:hover {
    background-color: #45a049;
}

.checkout {
    margin-top: 20px;
    text-align: right;
}

.checkout-button {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 5px;
}

.checkout-button:hover {
    background-color: #45a049;
}

</style>
