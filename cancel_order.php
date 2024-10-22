<?php
include 'config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'];
    // Cancel the order by updating its status
    $conn = openDbConnection();
    $stmt = $conn->prepare("UPDATE orders SET status = 'cancelled' WHERE id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $conn->close();
    header("Location: order_cancelled.php");
    exit();
}
?>
