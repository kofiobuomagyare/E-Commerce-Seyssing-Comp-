<?php 
session_start();

$conn = mysqli_connect('localhost', 'root');
mysqli_select_db($conn, 'seyssingcomp');
$sql = "SELECT * FROM products WHERE featured=1";
$featured = $conn->query($sql);

if(isset($_POST["add"])){
    $productId=$_GET["id"];
    $productName=$_GET["hidden_name"];
    $productImage=$_GET["hidden_image"];
    $productPrice=$_GET["hidden_price"];
    $productQuantity=$_GET["quantity"];

    $sql="INSERT INTO `products_second` (`description`, `image`,`price`, 'quantity') VALUES ('$productName', '$productImage', '$productPrice', '$productQuantity', );";
    mysqli_query($query, $sql);
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
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
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

<div class="col-md8">
    <div class="row">
    <div class="center-text"><h2 class="text-center">Product Details:</h2> <br> </div>
        <h2 class="text-center">Product Details:</h2> <br> 
        <?php 
            while($product = mysqli_fetch_assoc($featured)):
        ?>

        <div class="container">
            <div class="row text-center py-5">
            <div class="col-md-3 col-sm-6 my-3 my-md-0">
            <form action="details.php" method="post">
                <div class="card shadow">
                
            <img src="<?= $product['image'];?>" alt="<?=$product['title'];?>" class="img-fluid card-img-top">
            <h4> <?= $product['title'];?></h4>
            <p class="card.text">
            <p class="desc">About: <?= $product['description']?></p>
            <p class="bname">Brand: <?= $product['brandname']?></p>
            </p>
            <h5><span class="price">
            <p class="1price">Price: $<?= $product['price']?></p>
            </span> </h5>
            <input type="text" id="quantity" name="quantity" value="1">
            <input type="hidden"  name="hidden_image" value="<?php echo $product['image'];?>"> 
            <input type="hidden"  name="hidden_name" value="<?php echo $product['description'];?>">
            <input type="hidden"  name="hidden_price" value="<?php echo $product['price'];?>">     
            <button type="submit" class="btn btn-warning my-3" name="add">Add to Cart<i class="ri-shopping-cart-2-fill"></i></button> 
            
            <style>
                img{
                    max-width:100%;
                    height: auto;
                    background: white;
                    background: radial-gradient(white 20%, grey 80%);
                }
                
            </style> 
                </div>
            </form>
            
        </div>
            </div>
        </div>
        <?php endwhile; ?>

    </div>
  
</div>


</body>
</html>

