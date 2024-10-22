<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
      integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />

      <!------ICONSCOUT----->
      <link
      rel="stylesheet"
      href="https://unicons.iconscout.com/release/v4.0.0/css/line.css"
    />
    <!-- CSS -->
    <link rel="stylesheet" href="style.css" />

    <title>SeyssingComp E-commerce site</title>
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

      <section class="wrapper">
        <div class="title">
            <br />
          <h1>Our People</h1>
          <p>
            In web development, teamwork is our foundation. Each member brings their unique skills to the table, allowing us to innovate and problem-solve effectively. Together, we tackle challenges with unity and determination, driving towards success as a cohesive team.
          </p>
        </div>
  
        <div class="cards">
          <div class="card">
            <span><img src="Pics/1.jpg" alt="" /></span>
            <h2>ADU YAW EBENEZER</h2>
            <p>BC/ICT/22/306</p>
            <div class="socials">
              <a href=""><i class="uil uil-facebook"></i></a>
              <a href=""><i class="uil uil-instagram"></i></a>
              <a href=""><i class="uil uil-twitter-alt"></i></a>
            </div>
          </div>
  
          <div class="card">
            <span><img src="Pics/2.jpg" alt="" /></span>
            <h2>KOFI OBUOM AGYARE</h2>
            <p>BC/ITN/22/030</p>
            <div class="socials">
              <a href=""><i class="uil uil-facebook"></i></a>
              <a href=""><i class="uil uil-instagram"></i></a>
              <a href=""><i class="uil uil-twitter-alt"></i></a>
            </div>
          </div>

          <div class="card">
            <span><img src="Pics/3.jpg" alt="" /></span>
            <h2>MICHAEL AMPONSAH</h2>
            <p>BC/ITN/22/026</p>
            <div class="socials">
              <a href=""><i class="uil uil-facebook"></i></a>
              <a href=""><i class="uil uil-instagram"></i></a>
              <a href=""><i class="uil uil-twitter-alt"></i></a>
            </div>
          </div>
  
          <div class="card">
            <span><img src="Pics/4.jpg" alt="" /></span>
            <h2>RAMSEY MENSAH</h2>
            <p>BC/ICT/22/328</p>
            <div class="socials">
              <a href=""><i class="uil uil-facebook"></i></a>
              <a href=""><i class="uil uil-instagram"></i></a>
              <a href=""><i class="uil uil-twitter-alt"></i></a>
            </div>
          </div>
  
          <div class="card">
            <span><img src="Pics/5.jpg" alt="" /></span>
            <h2>STEWARD ADJEI</h2>
            <p>BC/ICT/22/304</p>
            <div class="socials">
              <a href=""><i class="uil uil-facebook"></i></a>
              <a href=""><i class="uil uil-instagram"></i></a>
              <a href=""><i class="uil uil-twitter-alt"></i></a>
            </div>
          </div>
  
          <div class="card">
            <span><img src="Pics/6.jpg" alt="" /></span>
            <h2>SAMUEL SAM</h2>
            <p>BC/ICT/22/352</p>
            <div class="socials">
              <a href=""><i class="uil uil-facebook"></i></a>
              <a href=""><i class="uil uil-instagram"></i></a>
              <a href=""><i class="uil uil-twitter-alt"></i></a>
            </div>
          </div>
  
          <div class="card">
            <span><img src="Pics/8.jpg" alt="" /></span>
            <h2>PASQUIN SEKYI</h2>
            <p>BC/ICT/22/305</p>
            <div class="socials">
              <a href=""><i class="uil uil-facebook"></i></a>
              <a href=""><i class="uil uil-instagram"></i></a>
              <a href=""><i class="uil uil-twitter-alt"></i></a>
            </div>
          </div>
  
          <div class="card">
            <span><img src="Pics/9.jpg" alt="" /></span>
            <h2>Clement Somuah Amonoo</h2>
            <p>BC/ITN/22/028</p>
            <div class="socials">
              <a href=""><i class="uil uil-facebook"></i></a>
              <a href=""><i class="uil uil-instagram"></i></a>
              <a href=""><i class="uil uil-twitter-alt"></i></a>
            </div>
          </div>
  
          <div class="card">
            <span><img src="Pics/10.jpg" alt="" /></span>
            <h2>Yusuff Basit Bashiru</h2>
            <p>BC/ICT/22/351</p>
            <div class="socials">
              <a href=""><i class="uil uil-facebook"></i></a>
              <a href=""><i class="uil uil-instagram"></i></a>
              <a href=""><i class="uil uil-twitter-alt"></i></a>
            </div>
          </div>
        </div>
      </section>

    </body>




    <footer>
        <h4>It is with great pleasure that we present this website as our mini-project as we really challenged ourselves to do something different other than the ordinary website people often resort to.</h4>
        <p><br />
          &copy; Made by Group 13 of Level 200 IT class group C. L200 Mini Project
        </p>
      </footer>
      <script src="script.js"></script>
    </body>
  </html>
  <style>
    .title {
  text-align: center;
  margin-block: 2rem;
}
.title h1 {
  margin-bottom: 1.5rem;
}
.title p {
  max-width: 800px;
  margin-inline: auto;
}
.wrapper {
  max-width: 90%;
  margin-inline: auto;
  margin-block: 1rem 5rem;
}
.card img {
  max-width: 7rem;
  aspect-ratio: 1;
  object-fit: cover;
  border-radius: 50%;
  border: lavender 5px solid;
}
.cards {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  align-items: center;
  gap: 1rem;
}
.cards .card {
  flex-basis: 400px;
  border-radius: 1rem;
  flex-grow: 1;
  padding: 1rem;
  padding-block: 2rem;
  text-align: center;
  background-color: white;
  box-shadow: 2px 3px 3px 1px rgb(227 227 227);
  display: flex;
  gap: 1rem;
  flex-direction: column;
  place-items: center;
}
.socials a {
  color: grey;
  text-decoration: none;
  margin-inline: 0.2rem;
}
a i {
  background-color: #8080804f;
  border-radius: 50%;
  padding: 0.2rem 0.4rem;
}
  </style>