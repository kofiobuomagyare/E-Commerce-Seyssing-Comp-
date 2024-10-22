<?php
session_start();

$total = 0;
$exchangeRate = 11; // 1 USD = 11 GHS
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="styles.css">
    <script src="https://js.paystack.co/v1/inline.js"></script>
    <title>Checkout - SeyssingComp</title>
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


<section class="checkout">
    <h2>Checkout</h2>
    <div class="checkout-items">
        <?php if (!empty($_SESSION['cart'])): ?>
            <table>
                <tr>
                    <th>Product Name</th>
                    <th>Price (GHS)</th>
                    <th>Quantity</th>
                    <th>Total (GHS)</th>
                </tr>
                <?php foreach ($_SESSION['cart'] as $name => $item): ?>
                    <?php
                    $priceInGHS = $item['price'];
                    $totalInGHS = $priceInGHS * $item['quantity'];
                    ?>
                    <tr>
                        <td><?php echo $name; ?></td>
                        <td>GHS <?php echo number_format($priceInGHS, 2); ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td>GHS <?php echo number_format($totalInGHS, 2); ?></td>
                    </tr>
                    <?php $total += $totalInGHS; ?>
                <?php endforeach; ?>
            </table>
            <h3>Total: GHS <?php echo number_format($total, 2); ?></h3>
            <form id="paymentForm">
                <h3>Billing Details</h3>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required>
                <label for="city">City:</label>
                <input type="text" id="city" name="city" required>
                <label for="state">State:</label>
                <input type="text" id="state" name="state" required>
                <label for="zip">Zip Code:</label>
                <input type="text" id="zip" name="zip" required>
                <button type="button" onclick="payWithPaystack()" class="checkout-button">Complete Purchase</button>
            </form>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </div>
</section>

</body>
</html>

<script>
function payWithPaystack() {
    var handler = PaystackPop.setup({
        key: '<?php echo getenv("PAYSTACK_PUBLIC_KEY"); ?>', // Load public key from server
        email: document.getElementById('email').value,
        amount: <?php echo $total * 100; ?>, // Convert total to kobo
        currency: 'GHS', // Replace with your currency
        ref: ''+Math.floor((Math.random() * 1000000000) + 1), // Generate a random reference number
        callback: function(response) {
            var reference = response.reference;
            alert('Payment complete! Reference: ' + reference);

            // Send payment details to server for verification and further processing
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'process_checkout.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert(xhr.responseText);
                }
            };
            xhr.send('reference=' + reference + '&total=' + <?php echo $total; ?>);
        },
        onClose: function() {
            alert('Transaction was not completed, window closed.');
        }
    });
    handler.openIframe();
}
</script>


<style>
.checkout-items table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

.checkout-items table, .checkout-items th, .checkout-items td {
    border: 1px solid #ddd;
}

.checkout-items th, .checkout-items td {
    padding: 8px;
    text-align: center;
}

.checkout-items th {
    background-color: #f2f2f2;
}

form {
    display: flex;
    flex-direction: column;
}

form label {
    margin-top: 10px;
}

form input {
    padding: 8px;
    margin-top: 5px;
}

.checkout-button {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    margin-top: 20px;
    text-align: center;
    text-decoration: none;
    border-radius: 5px;
    cursor: pointer;
    border: none;
}

.checkout-button:hover {
    background-color: #45a049;
}
</style>
