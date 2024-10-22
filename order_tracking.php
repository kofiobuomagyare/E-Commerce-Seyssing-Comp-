<?php
include 'config.php'; // File to connect to your database

$order_id = $_GET['order_id'] ?? null;
$order = null;
$order_items = [];

if ($order_id) {
    $conn = openDbConnection();

    $stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();

    if ($order) {
        $stmt = $conn->prepare("SELECT * FROM order_items WHERE order_id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $order_items[] = $row;
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Order Tracking - SeyssingComp</title>
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


<section class="order-tracking">
    <h2>Order Tracking</h2>
    <?php if ($order): ?>
        <h3>Order ID: <?php echo $order['id']; ?></h3>
        <p>Status: <?php echo $order['status']; ?></p>
        <h3>Order Details</h3>
        <table>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
            <?php foreach ($order_items as $item): ?>
                <tr>
                    <td><?php echo $item['product_name']; ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>$<?php echo $item['price']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <form action="cancel_order.php" method="post">
            <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
            <button type="submit" class="cancel-button">Cancel Order</button>
        </form>
    <?php else: ?>
        <p>Order not found. Please check the order ID and try again.</p>
    <?php endif; ?>
</section>

</body>
</html>
<style>
 .order-tracking table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

.order-tracking table, .order-tracking th, .order-tracking td {
    border: 1px solid #ddd;
}

.order-tracking th, .order-tracking td {
    padding: 8px;
    text-align: center;
}

.order-tracking th {
    background-color: #f2f2f2;
}

.cancel-button {
    background-color: #f44336;
    color: white;
    padding: 10px 20px;
    margin-top: 20px;
    text-align: center;
    text-decoration: none;
    border-radius: 5px;
    cursor: pointer;
    border: none;
}

.cancel-button:hover {
    background-color: #d32f2f;
}

</style>