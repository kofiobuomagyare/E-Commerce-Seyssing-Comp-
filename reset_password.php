<?php
session_start();

// Define your database connection variables
$servername = "localhost:3306";
$username = "root";
$password = ""; // Use the correct password or empty if no password
$dbname = "shop_db"; // Use your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die('Database connection error: ' . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['reset_email'])) {
        // Handle password reset request
        $email = $conn->real_escape_string($_POST['reset_email']);
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            // Normally you would send an email with a reset link. Here we are skipping that step.
            echo "Password reset instructions have been sent to your email.";
        } else {
            echo "No user found with this email.";
        }
    } elseif (isset($_POST['new_password'])) {
        // Handle password update
        $email = $conn->real_escape_string($_POST['email']);
        $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);

        $query = "UPDATE users SET password = '$new_password' WHERE email = '$email'";
        if ($conn->query($query) === TRUE) {
            echo "Password updated successfully. <a href='login.php'>Login here</a>";
        } else {
            echo "Error updating password: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <form method="POST" action="reset_password.php">
        <h2>Reset Password</h2>
        <label for="reset_email">Email:</label>
        <input type="email" id="reset_email" name="reset_email" required>
        <button type="submit">Send Reset Instructions</button>
    </form>
    <br>
    <form method="POST" action="reset_password.php">
        <h2>Set New Password</h2>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="new_password">New Password:</label>
        <input type="password" id="new_password" name="new_password" required>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>

<style>
    body {
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f5f5f5;
    }

    form {
        width: 300px;
        margin: 100px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    form h2 {
        margin-bottom: 20px;
        text-align: center;
    }

    form label {
        margin: 10px 0 5px;
        display: block;
    }

    form input {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 5px;
        border: 1px solid #ddd;
    }

    form button {
        width: 100%;
        padding: 10px;
        background-color: #333;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    form button:hover {
        background-color: #555;
    }
</style>
