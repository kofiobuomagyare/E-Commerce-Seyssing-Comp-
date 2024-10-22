<?php
session_start();
include 'config.php'; // Ensure this includes your database connection function

// Fetch products from the database
$conn = openDbConnection();
$query = "SELECT * FROM products";
$result = $conn->query($query);

if (!$result) {
    die("Error fetching products: " . $conn->error);
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
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
    <!-- google fonts link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
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

        // Loop through fetched products
        while ($row = $result->fetch_assoc()) {
            $price_in_ghs = $row['price'] * $conversion_rate;
            echo '<div class="row">
                <div class="row-img">
                    <img src="'.$row['image'].'" alt="Product Image">
                </div>
                <h3>'.htmlspecialchars($row['title']).'</h3>
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
                        <form method="post" action="shop.php">
                            <input type="hidden" name="product" value="'.htmlspecialchars($row['title']).'">
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
        
        // Close database connection
        $conn->close();
        ?>
    </div>
    <div class="n-btn">
        <a href="#" class="btn2">View all</a>
    </div>
</section>

</body>
</html>
