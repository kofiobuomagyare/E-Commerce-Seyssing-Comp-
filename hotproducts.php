<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product'])) {
    $product = $_POST['product'];
    $quantity = 1;

    // Initialize the cart if it doesn't exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add product to the cart
    if (isset($_SESSION['cart'][$product])) {
        $_SESSION['cart'][$product]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$product] = ['quantity' => $quantity, 'price' => $_POST['price']];
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>SeyssingComp</title>
    <!-- box-icons link -->
    <link rel="stylesheet"
  href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
  <!-- remix-icons link -->
  <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css"
    rel="stylesheet"
/>
<!-- google fonts link -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
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


<!-- all products -->
<section class="n-product">
    <div class="center-text">
        <h2>All Products</h2>
    </div>

    <div class="n-content">
        <?php
        $conversion_rate = 11; // 1 USD = 11 GHS

        $products = [
            ["image" => "Pics/Alienware M15.png", "name" => "Alienware M15 Laptop", "price" => 1.30],
            ["image" => "Pics/Apple MacBook Pro 13.png", "name" => "Apple Macbook Pro 13\" M3 Laptop", "price" => 0.65],
            ["image" => "Pics/Asus Rog Zephrus.png", "name" => "Asus Rog Zephrus Laptop", "price" => 1.95],
            ["image" => "Pics/Dell XPS 13.png", "name" => "Dell XPS 13 Laptop", "price" => 2.50],
            ["image" => "Pics/Hp Elitebook 840 G5.png", "name" => "Hp Elitebook 840 G5 Laptop", "price" => 0.75],
            ["image" => "Pics/Microsoft surfacebook.png", "name" => "Microsoft Surfacebook Pro Laptop", "price" => 1.60]
        ];

        foreach ($products as $product) {
            $price_in_ghs = $product['price'] * $conversion_rate;
            echo '<div class="row">
                <div class="row-img">
                    <img src="'.$product['image'].'">
                </div>
                <h3>'.$product['name'].'</h3>
                <div class="stars">
                    <a href="#"><i class="ri-star-fill"></i></a>
                    <a href="#"><i class="ri-star-fill"></i></a>
                    <a href="#"><i class="ri-star-fill"></i></a>
                    <a href="#"><i class="ri-star-fill"></i></a>
                    <a href="#"><i class="ri-star-half-line"></i></a>
                    <a href="#">4.5/5</a>
                </div>
                <div class="row-in">
                    <div class="row-left">
                        <form method="post" action="">
                            <input type="hidden" name="product" value="'.$product['name'].'">
                            <input type="hidden" name="price" value="'.$price_in_ghs.'">
                            <button type="submit" class="btn">
                                Add to cart
                                <i class="ri-shopping-cart-2-fill"></i>
                            </button>
                        </form>
                    </div>
                    <div class="row-right">
                        <h6>GHS '.number_format($price_in_ghs, 2).'</h6>
                    </div>
                </div>
            </div>';
        }
        ?>
    </div>
    <div class="n-btn">
        <a href="#" class="btn2">View all</a>
    </div>
</section>

</body>
</html>
