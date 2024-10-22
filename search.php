<?php
session_start();

// Database connection
$host = "localhost:3306";
$db = "shop_db";
$user = "root";
$pass = "";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$searchQuery = '';
$results = [];
if (isset($_GET['query'])) {
    $searchQuery = $_GET['query'];
    $stmt = $conn->prepare("SELECT * FROM products WHERE title LIKE ? OR description LIKE ?");
    $likeQuery = '%' . $searchQuery . '%';
    $stmt->bind_param('ss', $likeQuery, $likeQuery);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $results[] = $row;
    }
    $stmt->close();
}

$_SESSION['search_results'] = $results;
$_SESSION['search_query'] = $searchQuery;

$conn->close();

header('Location: index.php');
exit();
?>
