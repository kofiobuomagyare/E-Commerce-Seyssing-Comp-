<?php
session_start();
include 'config.php'; // Ensure this includes and initializes $conn properly

// Check if admin is logged in
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Initialize variables
$user_id = null;

// Database connection
$conn = openDbConnection();

// Handle form submission for deleting user
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    // Prepare a delete statement
    $query = "DELETE FROM users WHERE id = ?";
    
    // Using prepared statements to prevent SQL injection
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    
    // Execute the statement
    if ($stmt->execute()) {
        // If deletion is successful, unset the session for the deleted user (if stored)
        if (isset($_SESSION['users'][$user_id])) {
            unset($_SESSION['users'][$user_id]);
        }
        
        // Redirect back to user management page after deletion
        header('Location: view_users.php');
        exit();
    } else {
        // Handle database error or deletion failure
        // You can log errors or redirect to an error page as needed
        echo "Error deleting user: " . $conn->error;
    }
    
    // Close prepared statement
    $stmt->close();
    
} else {
    // Handle cases where user_id is not provided or form method is not POST
    // Redirect to an error page or handle gracefully
    header('Location: view_users.php'); // Redirect to user management page by default
    exit();
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User - SeyssingComp</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .admin-header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 1rem 0;
        }
        .admin-dashboard {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .admin-dashboard h2 {
            margin-top: 0;
            font-size: 24px;
            color: #333;
        }
        .admin-dashboard p {
            font-size: 16px;
            margin-bottom: 20px;
            color: #666;
        }
        .admin-dashboard form {
            display: flex;
            justify-content: space-between;
        }
        .admin-dashboard .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            text-decoration: none;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .admin-dashboard .btn:hover {
            background-color: #555;
        }
        .btn-cancel {
            background-color: #cc3333;
        }
    </style>
</head>
<body>
    <!-- Include Admin Header -->
    <div class="admin-header">
        <h1>SeyssingComp Admin</h1>
        <nav>
            <ul>
                <li><a href="#">Dashboard</a></li>
                <li><a href="#">Users</a></li>
                <li><a href="#">Orders</a></li>
                <li><a href="#">Products</a></li>
            </ul>
        </nav>
    </div>

    <section class="admin-dashboard">
        <h2>Delete User</h2>
        <p>Are you sure you want to delete this user?</p>
        
        <!-- Form for deleting user -->
        <form action="" method="post">
            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">
            <button type="submit" class="btn btn-cancel">Delete User</button>
            <a href="view_users.php" class="btn">Cancel</a>
        </form>
    </section>

</body>
</html>
