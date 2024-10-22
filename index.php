<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

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
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <!-- remix-icons link -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>
    <!-- google fonts link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
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


<!-- home --> 
<section class="home">
 
<!-- header -->   
<!--<header>
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
</header>-->
<script>
    document.getElementById('menu-icon').addEventListener('click', function() {
        this.classList.toggle('active');
        document.getElementById('navlist').classList.toggle('active');
    });
</script>

    <div class="home-text">
        <h6>New Arrivals</h6>
        <h1>New Arrivals <br> get your <br> geek on</h1>
        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.  </p>
        <a href="newarrivals.php" class="btn">
            Shop now
            <i class="ri-arrow-right-line"></i>
        </a>
    </div>
</section>

<!-- brands --> 
<div class="brands">
    <div class="main-brands">
        <div class="brands-c">
            <img src="Pics/Alienware logo.jpg">
            <img src="Pics/Apple logo.jpg">
            <img src="Pics/Asus logo.jpg">
            <img src="Pics/Dell logo.jpg">
            <img src="Pics/Hp logo.jpg"> 
            <img src="Pics/Microsoft logo.png">
        </div>
    </div>
</div>

<!-- all products -->
<section class="n-product">
    <div class="center-text">
        <h2>All Products</h2>
    </div>

    <div class="n-content">
        <?php
        // Check if there are search results
        if (isset($_SESSION['search_results']) && !empty($_SESSION['search_results'])) {
            echo '<div class="center-text"><h2>Search Results for "' . htmlspecialchars($_SESSION['search_query']) . '"</h2></div>';
            $products = $_SESSION['search_results'];
            // Clear the search results from the session after displaying
            unset($_SESSION['search_results']);
            unset($_SESSION['search_query']);
        } else {
            // Default products if no search results
            $products = [
                ["image" => "Pics/Alienware M15.png", "name" => "Alienware M15 Laptop", "price" => 3749.00],
                ["image" => "Pics/Apple MacBook Pro 13.png", "name" => "Apple Macbook Pro 13\" M3 Laptop", "price" => 1599.00],
                ["image" => "Pics/Asus Rog Zephrus.png", "name" => "Asus Rog Zephrus Laptop", "price" => 1649.00],
                ["image" => "Pics/Dell XPS 13.png", "name" => "Dell XPS 13 Laptop", "price" => 999.00],
                ["image" => "Pics/Hp Elitebook 840 G5.png", "name" => "Hp Elitebook 840 G5 Laptop", "price" => 1199.00],
                ["image" => "Pics/Microsoft surfacebook.png", "name" => "Microsoft Surfacebook Pro Laptop", "price" => 1299.00]
            ];
        }

        $conversion_rate = 11; // 1 USD = 11 GHS
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

<!-- feature -->
<section class="feature">
    <div class="feature-content">
        <div class="box">
            <div class="f-icon">
            <i class="ri-bank-card-fill"></i>
            </div>
            <div class="f-text">
                <h3>Cash on Delivery</h3>
                <p>Ratione vel hic inventore libero quo a pariatur ducimus, in dicta laudantium cum. </p>
            </div>
        </div>

        <div class="box">
            <div class="f-icon">
            <i class="ri-truck-fill"></i>
            </div>
            <div class="f-text">
                <h3>Free Delivery</h3>
                <p>Ratione vel hic inventore libero quo a pariatur ducimus, in dicta laudantium cum. </p>
            </div>
        </div>

        <div class="box">
            <div class="f-icon">
            <i class="ri-customer-service-2-fill"></i>
            </div>
            <div class="f-text">
                <h3>35 days return</h3>
                <p>Ratione vel hic inventore libero quo a pariatur ducimus, in dicta laudantium cum. </p>
            </div>
        </div>
    </div>
</section>

<!-- best selling -->
<section class="selling">
    <div class="center-text">
        <h2>Best Seller</h2>
    </div>

    <div class="selling-content">
        <div class="col">
            <div class="col-img">
                <img src="Pics/Macbook (2).png" >
            </div>
            <div class="col-icon">
                <a href="#"><i class="ri-heart-line"></i></a>
                <a href="#"><i class="ri-eye-line"></i></a>
                <a href="#"><i class="ri-shopping-cart-2-line"></i></a>
            </div>
        </div>

        <div class="col">
            <div class="col-img">
                <img src="Pics/Asus Rog Zephrus black.png" >
            </div>
            <div class="col-icon">
                <a href="#"><i class="ri-heart-line"></i></a>
                <a href="#"><i class="ri-eye-line"></i></a>
                <a href="#"><i class="ri-shopping-cart-2-line"></i></a>
            </div>
        </div>

        <div class="col">
            <div class="col-img">
                <img src="Pics/Hp Elitebook 840 G5.png" >
            </div>
            <div class="col-icon">
                <a href="favorites.php"><i class="ri-heart-line"></i></a>
                <a href="view.php"><i class="ri-eye-line"></i></a>
                <a href="cart.php"><i class="ri-shopping-cart-2-line"></i></a>
            </div>
        </div>
    </div>
</section>

<!-- newsletter section-->
<section class="newsletter">
    <div class="newsletter-content">
        <div class="newsletter-text">
            <h2>Wanna Hear from us?</h2>
            <p>Sign up with your email address to receive tech information and updates on new products.</p>
        </div>
        <form id="newsletter-form">
            <input type="email" id="email" name="email" placeholder="Your email..." required>
            <input type="submit" value="Subscribe" class="btnnn">
        </form>
        <div id="message"></div>
    </div>
</section>

<script src="newsletter.js"></script>


<!-- footer section-->
<section class="footer">
    <div class="footer-box">
        <h3>Company</h3>
        <a href="about.php">About</a>
        <a href="#">Features</a>
        <a href="#">Works</a>
        <a href="#">Career</a>
    </div>

    <div class="footer-box">
        <h3>FAQ</h3>
        <a href="#">Account</a>
        <a href="#">Features</a>
        <a href="#">Works</a>
        <a href="#">Career</a>
    </div>

    <div class="footer-box">
        <h3>Resources</h3>
        <a href="#">Youtube Playlist</a>
        <a href="#">Features</a>
        <a href="#">Works</a>
    </div>

    <div class="footer-box">
        <h3>Social</h3>
        <div class="social">
        <a href="#"><i class="ri-facebook-circle-fill"></i></a>
        <a href="#"><i class="ri-instagram-fill"></i></a>
        <a href="#"><i class="ri-twitter-x-fill"></i></a>
        <a href="#"><i class="ri-pinterest-fill"></i></a>
        </div>
    </div>
</section>

<!-- copyright-->
<div class="copyright">
    <div class="end-text">
        <p>CopyRight 2024 By Agyare Kofi Obuom</p>
    </div>

    <div class="Payments">
    <!-- Payment icons -->    
    <a href="#"><i class="ri-visa-fill"></i></a>
        <a href="#"><i class="ri-paypal-fill"></i></i></a>
        <a href="#"><i class="ri-mastercard-fill"></i></i></a>
        </div>
    </div>
</div>


<!-- javascript link -->
<script src="script.js"></script>
</body>
</html>
