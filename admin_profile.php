<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: admin_header.php');
    exit();
}

include 'config.php'; // Include your database configuration

$conn = openDbConnection(); // Use a function to handle the DB connection

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user information
$username = $_SESSION['username'];
$userQuery = $conn->prepare("SELECT id, email, phone FROM users WHERE username = ?");
$userQuery->bind_param('s', $username);
$userQuery->execute();
$userQuery->bind_result($userId, $email, $number);
$userQuery->fetch();
$userQuery->close();

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

        <a href="logout.php" class="button">Logout</a>
        <a href="admin_dashboard.php" class="button">Return to Homepage</a>
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