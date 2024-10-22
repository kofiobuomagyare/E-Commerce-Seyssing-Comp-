<?php
session_start();
include 'config.php'; // Ensure this contains your database connection and environment loading logic

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$name = $email = $address = $city = $state = $zip = "";
$total = 0;
$order_id = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['name'], $_POST['email'], $_POST['address'], $_POST['city'], $_POST['state'], $_POST['zip'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $zip = $_POST['zip'];

        if (!empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            // Save order details to the database
            $conn = openDbConnection();
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $stmt = $conn->prepare("INSERT INTO orders (name, email, address, city, state, zip, total) VALUES (?, ?, ?, ?, ?, ?, ?)");
            if (!$stmt) {
                die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
            }

            $stmt->bind_param("ssssssd", $name, $email, $address, $city, $state, $zip, $total);
            if ($stmt->execute()) {
                $order_id = $stmt->insert_id;

                foreach ($_SESSION['cart'] as $product_name => $item) {
                    $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_name, quantity, price) VALUES (?, ?, ?, ?)");
                    if (!$stmt) {
                        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
                    }
                    $stmt->bind_param("isid", $order_id, $product_name, $item['quantity'], $item['price']);
                    $stmt->execute();
                }

                // Clear the cart
                unset($_SESSION['cart']);
            } else {
                echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }

            // Close the statement and database connection
            $stmt->close();
            $conn->close();
        }
    } elseif (isset($_POST['reference'])) {
        $reference = $_POST['reference'];
        $total = $_POST['total'];

        // Load Paystack secret key from environment variable or secure location
        $secret_key = getenv('PAYSTACK_SECRET_KEY') ?: 'sk_test_xxxxxxxxxxxxxx'; // Fallback to test key for dev environment
        $url = 'https://api.paystack.co/transaction/verify/' . $reference;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $secret_key]);
        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response);
        if ($result->status && $result->data->status == 'success') {
            // Payment was successful

            // Clear the cart
            unset($_SESSION['cart']);

            echo 'Payment successful. Order processed.';
        } else {
            // Payment failed
            echo 'Payment verification failed.';
        }
    } else {
        echo 'No reference supplied.';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Order Confirmation - SeyssingComp</title>
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

<section class="order-confirmation">
    <h2>Order Confirmation</h2>
    <p>Thank you for your purchase, <?php echo htmlspecialchars($name); ?>!</p>
    <p>A confirmation email has been sent to <?php echo htmlspecialchars($email); ?>.</p>
    <p>Total amount: $<?php echo htmlspecialchars(number_format($total, 2)); ?></p>
    <p>Shipping to:</p>
    <p>
        <?php echo htmlspecialchars($address); ?><br>
        <?php echo htmlspecialchars($city); ?>, <?php echo htmlspecialchars($state); ?> <?php echo htmlspecialchars($zip); ?>
    </p>
    <p>Your order number is: <?php echo htmlspecialchars($order_id); ?></p>
    
    <!-- Add Order Tracking and Cancel Order buttons -->
    <form action="track_order.php" method="get" class="order-action-form">
        <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order_id); ?>">
        <button type="submit" class="btn">Track Order</button>
    </form>
    <form action="cancel_order.php" method="post" class="order-action-form">
        <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order_id); ?>">
        <button type="submit" class="btn btn-cancel">Cancel Order</button>
    </form>
</section>

</body>
</html>
