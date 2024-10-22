<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

include 'config.php'; // Include your database configuration

$conn = openDbConnection(); // Use a function to handle the DB connection

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user information
$username = $_SESSION['username'];
$userQuery = $conn->prepare("SELECT id, email, number FROM users WHERE username = ?");
$userQuery->bind_param('s', $username);
$userQuery->execute();
$userQuery->bind_result($userId, $email, $number);
$userQuery->fetch();
$userQuery->close();

// Fetch cart items
$cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Fetch previously checked out items
$checkoutQuery = $conn->prepare("SELECT product_id FROM orders WHERE user_id = ?");
$checkoutQuery->bind_param('i', $userId);
$checkoutQuery->execute();
$checkoutResult = $checkoutQuery->get_result();
$checkoutItems = [];
while ($row = $checkoutResult->fetch_assoc()) {
    $checkoutItems[] = $row;
}
$checkoutQuery->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>User Profile</h1>
        <p>Username: <?php echo htmlspecialchars($username); ?></p>
        <p>Email: <?php echo htmlspecialchars($email); ?></p>
        <p>Phone Number: <?php echo htmlspecialchars($number); ?></p>

        <h2>Cart Items</h2>
        <ul>
            <?php if (empty($cartItems)): ?>
                <li>No items in cart.</li>
            <?php else: ?>
                <?php foreach ($cartItems as $item): ?>
                    <li><?php echo htmlspecialchars($item['name']); ?> - <?php echo htmlspecialchars($item['quantity']); ?></li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>

        <h2>Previously Checked Out Items</h2>
        <ul>
            <?php if (empty($checkoutItems)): ?>
                <li>No items checked out.</li>
            <?php else: ?>
                <?php foreach ($checkoutItems as $item): ?>
                    <li><?php echo htmlspecialchars($item['product_name']); ?> - <?php echo htmlspecialchars($item['checkout_date']); ?></li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>

        <a href="logout.php" class="button">Logout</a>
        <a href="index.php" class="button">Return to Homepage</a>
    </div>
</body>
</html>

<style>

    body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1, h2 {
    color: #333;
}

p {
    color: #666;
}

ul {
    list-style-type: none;
    padding: 0;
}

ul li {
    background-color: #f9f9f9;
    margin: 5px 0;
    padding: 10px;
    border: 1px solid #ddd;
}

a.button {
    display: inline-block;
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #28a745;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s;
}

a.button:hover {
    background-color: #218838;
}

</style>