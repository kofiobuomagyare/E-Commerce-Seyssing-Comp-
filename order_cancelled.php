<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Order Cancelled - SeyssingComp</title>
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


<section class="order-cancelled">
    <h2>Order Cancelled</h2>
    <p>Your order has been cancelled successfully.</p>
    <a href="shop.php" class="btn">Return to Shop</a>
</section>

</body>
</html>
<style>
    
.order-cancelled {
    max-width: 600px;
    margin: 50px auto;
    background: #fff;
    padding: 20px;
    text-align: center;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.order-cancelled h2 {
    color: #d9534f;
}

.order-cancelled p {
    font-size: 1.2em;
}

.order-cancelled .btn {
    display: inline-block;
    padding: 10px 20px;
    background-color: #5cb85c;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    margin-top: 20px;
}

.order-cancelled .btn:hover {
    background-color: #4cae4c;
}

</style>