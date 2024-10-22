<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include configuration file
require_once 'config.php';

// Check if admin is logged in
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
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

<!-- Admin Header -->
<header>
    <a href="admin_dashboard.php" class="logo">SeyssingComp Admin</a>
    <ul class="navlist" id="navlist">
        <li><a href="admin_dashboard.php">Dashboard</a></li>
        <li><a href="view_users.php">Users</a></li>
        <li><a href="view_orders.php">Orders</a></li>
        <li><a href="view_products.php">Products</a></li> <!-- New Products link -->
    </ul>

    <div class="nav-right">
        <?php if(isset($_SESSION['username'])): ?>
            <a href="admin_profile.php"><i class="ri-user-3-line"></i><?php echo $_SESSION['username']; ?></a>
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
</body>
</html>
