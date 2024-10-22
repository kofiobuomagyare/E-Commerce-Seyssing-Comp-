<?php
session_start();
include 'config.php'; // Include the config file to establish the $conn properly

// Check if admin is logged in
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php'); // Redirect to login page if not logged in as admin
    exit();
}

// Establish database connection
$conn = openDbConnection();

// Fetch orders from the database
$query = "SELECT * FROM orders";
$result = $conn->query($query);

// Check for errors
if (!$result) {
    die("Error fetching orders: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Admin Dashboard - SeyssingComp</title>
</head>
<body>

<!-- Include Admin Header -->
<?php include 'admin_header.php'; ?>

<section class="admin-dashboard">
    <h2>Welcome, Admin!</h2>
    <h3>Order Management</h3>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Email</th>
                <th>Address</th>
                <th>City</th>
                <th>State</th>
                <th>ZIP</th>
                <th>Total</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['address']); ?></td>
                    <td><?php echo htmlspecialchars($row['city']); ?></td>
                    <td><?php echo htmlspecialchars($row['state']); ?></td>
                    <td><?php echo htmlspecialchars($row['zip']); ?></td>
                    <td><?php echo htmlspecialchars($row['total']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <td>
                        <form action="process_order.php" method="post" class="order-action-form">
                            <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="action" value="process" class="btn">Process Order</button>
                        </form>
                        <form action="refund_order.php" method="post" class="order-action-form">
                            <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="action" value="refund" class="btn btn-cancel">Refund Order</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</section>


</body>
</html>

<?php
// Close database connection
$conn->close();
?>
