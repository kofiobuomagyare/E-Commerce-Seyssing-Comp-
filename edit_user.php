<?php
session_start();
require_once 'config.php'; // Ensure config.php is included properly

// Check if admin is logged in
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Initialize variables
$user_id = null;
$current_user = [];

// Database connection
$conn = openDbConnection();

// Handle form submission for fetching user details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    // Fetch current user details from the database
    $query = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $current_user = $result->fetch_assoc();
        } else {
            echo "User not found.";
            exit();
        }
    } else {
        echo "Error fetching user details: " . $conn->error;
        exit();
    }

    // Close prepared statement
    $stmt->close();
}

// Handle form submission for updating user details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_user'])) {
    $user_id = $_POST['user_id'];
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Update query
    $query = "UPDATE users SET fullname=?, username=?, email=?, phone=? WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssi", $fullname, $username, $email, $phone, $user_id);
    
    if ($stmt->execute()) {
        echo "User updated successfully!";
        // Redirect or perform any other actions after successful update
    } else {
        echo "Error updating user: " . $conn->error;
    }

    // Close prepared statement
    $stmt->close();
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - SeyssingComp</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Include Admin Header -->
    <?php include 'admin_header.php'; ?>

    <section class="admin-dashboard">
        <h2>Edit User</h2>
        <!-- Example form for editing user -->
        <form action="" method="post">
            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($current_user['id']); ?>">
            
            <label for="fullname">Full Name:</label>
            <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($current_user['fullname']); ?>" required>
            
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($current_user['username']); ?>" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($current_user['email']); ?>" required>
            
            <label for="phone">Phone:</label>
            <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($current_user['phone']); ?>" required>

            <button type="submit" name="update_user" class="btn">Update User</button>
        </form>
    </section>

</body>
</html>

<style>
    /* Reset default margin and padding */
    body, html {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
    }

    /* Basic styling for the admin dashboard section */
    .admin-dashboard {
        max-width: 800px;
        margin: 20px auto;
        padding: 20px;
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    /* Form styling */
    form {
        max-width: 400px;
        margin: 0 auto;
    }

    label {
        display: block;
        margin-bottom: 8px;
    }

    input[type="text"],
    input[type="email"],
    input[type="tel"] {
        width: calc(100% - 20px);
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ddd;
        border-radius: 3px;
        font-size: 14px;
    }

    .btn {
        background-color: #4CAF50; /* Green */
        border: none;
        color: white;
        padding: 8px 12px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
        margin-top: 10px;
        cursor: pointer;
        border-radius: 3px;
    }

    .btn:hover {
        background-color: #45a049;
    }

    /* Responsive design for smaller screens */
    @media only screen and (max-width: 600px) {
        .admin-dashboard {
            padding: 10px;
        }
        form {
            max-width: 100%;
        }
    }

</style>
