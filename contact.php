<!DOCTYPE html>
<html lang="en">
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

<form id="contact"  method="#" action="#">
        
          <h3>Contact Me Below</h3>
          <h4>It is always a pleasure to hear from you!</h4>
          <fieldset>
            <input placeholder="Your name" name="name" type="text"  required>
          </fieldset>
          <fieldset>
            <input placeholder="Subject" name="name" type="text"  required>
          </fieldset>
          <fieldset>
            <input placeholder="Email Address" name="email" type="email"  required>
          </fieldset>
          <fieldset>
            <input placeholder="Phone Number" name="pnum"type="tel"  required>
          </fieldset>
          <fieldset>
            <textarea placeholder="Type your message here..." name="mess" required></textarea>
          </fieldset>
          <fieldset>
            <button name="submit" type="submit" id="contact-submit" data-submit="...Sending" value"Submit">Submit</button>
          </fieldset>
          
        </form>
      </div>


</body>
</html>
<style>
     .contact-container {
    max-width: 400px;
    width: 100%;
    margin: 0 auto;
    position: relative;
  }
  
  #contact input[type="text"],
  #contact input[type="email"],
  #contact input[type="tel"],
  #contact input[type="url"],
  #contact textarea,
  #contact button[type="submit"] {
    font: 400 12px/16px "Roboto", Helvetica, Arial, sans-serif;
  }
  
  #contact {
    background: var(--bg-color);
    padding: 25px;
    margin: 100px 0;
    box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
  }
  
  #contact h3 {
    display: block;
    font-size: 30px;
    font-weight: 300;
    margin-bottom: 10px;
  }
  
  #contact h4 {
    margin: 5px 0 15px;
    display: block;
    font-size: 13px;
    font-weight: 400;
  }
  
  fieldset {
    border: medium none !important;
    margin: 0 0 10px;
    min-width: 100%;
    padding: 0;
    width: 100%;
  }
  
  #contact input[type="text"],
  #contact input[type="email"],
  #contact input[type="tel"],
  #contact input[type="url"],
  #contact textarea {
    width: 90%;
    border: 1px solid #ccc;
    background: var(--bg-color);
    margin: 0 0 5px;
    padding: 10px;
  }
  
  #contact input[type="text"]:hover,
  #contact input[type="email"]:hover,
  #contact input[type="tel"]:hover,
  #contact input[type="url"]:hover,
  #contact textarea:hover {
    border: 1px solid #aaa;
  }
  
  #contact textarea {
    height: 100px;
    max-width: 90%;
    resize: none;
  }
  
  #contact button[type="submit"] {
    cursor: pointer;
    width: 60%;
    border: none;
    background: var(--other-color);
    color: var(--bg-color);
    margin: 0 auto 5px;
    padding: 10px;
    font-size: 15px;
    display: grid;
    place-items: center;
  }
  
  #contact button[type="submit"]:hover {
    background: var(--text-color);
    color: var(--bg-color);
    -webkit-transition: background 0.3s ease-in-out;
    -moz-transition: background 0.3s ease-in-out;
    transition: background-color 0.3s ease-in-out;
  }

</style>