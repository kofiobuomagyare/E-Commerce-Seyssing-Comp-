<?php
session_start();
include 'config.php'; // Ensure this file establishes $conn properly

// Check if admin is logged in
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php'); // Redirect to login page if not logged in as admin
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id']) && $_POST['action'] == 'refund') {
    $order_id = $_POST['order_id'];

    // Update order status to 'refunded'
    $stmt = $conn->prepare("UPDATE orders SET status = 'refunded' WHERE id = ?");
    $stmt->bind_param("i", $order_id);
    if ($stmt->execute()) {
        echo "Order refunded successfully.";
    } else {
        echo "Error refunding order: " . $conn->error;
    }
    
    $stmt->close();
}

$conn->close();
header('Location: admin.php');
exit();
?>
