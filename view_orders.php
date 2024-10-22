<?php
session_start();
include 'config.php';

// Check if admin is logged in
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
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
    <title>View Orders - Admin - SeyssingComp</title>
</head>
<body>

<!-- Include Admin Header -->
<?php include 'admin_header.php'; ?>

<section class="admin-dashboard">
<?php include 'admin_header.php'; ?>
    <h2>Order Management</h2>
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
<style>
    /* style.css */

/* Overall page styles */
body {
    font-family: 'Poppins', sans-serif;
    background-color: #f0f0f0;
    margin: 0;
    padding: 0;
}

.admin-dashboard {
    margin: 20px;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.admin-dashboard h2 {
    font-size: 28px;
    margin-bottom: 20px;
    color: #333;
}

/* Table styles */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    overflow-x: auto; /* Allow horizontal scrolling on smaller screens */
}

table th, table td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

table th {
    background-color: #f0f0f0;
    font-weight: bold;
    color: #555;
}

table tr:hover {
    background-color: #f9f9f9;
}

/* Button styles */
.btn {
    background-color: #4CAF50;
    color: white;
    border: none;
    padding: 8px 12px;
    cursor: pointer;
    border-radius: 4px;
    font-size: 14px;
    transition: background-color 0.3s;
    width: 100%; /* Make buttons full-width on smaller screens */
    margin-bottom: 8px; /* Add spacing between buttons */
}

.btn:hover {
    background-color: #45a049;
}

.btn-cancel {
    background-color: #f44336;
}

.btn-cancel:hover {
    background-color: #da190b;
}

/* Responsive design */
@media only screen and (max-width: 768px) {
    .admin-dashboard {
        padding: 10px;
    }
    
    table {
        font-size: 14px;
    }
    
    table th, table td {
        padding: 10px;
    }
}

</style>