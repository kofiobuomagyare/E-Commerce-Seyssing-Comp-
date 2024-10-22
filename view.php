<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product = $_POST['product'];

    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        switch ($action) {
            case 'add_to_cart':
                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = [];
                }
                if (isset($_SESSION['cart'][$product])) {
                    $_SESSION['cart'][$product]['quantity'] += 1;
                } else {
                    $_SESSION['cart'][$product] = ['quantity' => 1, 'price' => $_POST['price']];
                }
                break;

            case 'remove_from_viewed':
                if (isset($_SESSION['recently_viewed'])) {
                    $key = array_search($product, $_SESSION['recently_viewed']);
                    if ($key !== false) {
                        unset($_SESSION['recently_viewed'][$key]);
                    }
                }
                break;
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
    <title>Recently Viewed Products</title>
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


<!-- Recently Viewed Products -->
<section class="viewed">
    <div class="center-text">
        <h2>Recently Viewed Products</h2>
    </div>

    <div class="viewed-content">
        <?php
        if (isset($_SESSION['recently_viewed']) && !empty($_SESSION['recently_viewed'])) {
            foreach ($_SESSION['recently_viewed'] as $product) {
                // Example product data, replace with actual product details
                $price = 1000; // Replace with actual price
                $image = "Pics/Example.png"; // Replace with actual image path

                echo '<div class="col">
                    <div class="col-img">
                        <img src="'.$image.'">
                    </div>
                    <div class="col-icon">
                        <form method="post" action="">
                            <input type="hidden" name="product" value="'.$product.'">
                            <input type="hidden" name="price" value="'.$price.'">
                            <button type="submit" name="action" value="add_to_cart"><i class="ri-shopping-cart-2-line"></i></button>
                            <button type="submit" name="action" value="remove_from_viewed"><i class="ri-delete-bin-line"></i></button>
                        </form>
                    </div>
                    <h3>'.$product.'</h3>
                    <p>$'.$price.'</p>
                </div>';
            }
        } else {
            echo '<p>No recently viewed products.</p>';
        }
        ?>
    </div>
</section>
</body>
</html>
