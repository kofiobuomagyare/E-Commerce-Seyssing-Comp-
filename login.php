<?php
session_start();

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
    $login = $conn->real_escape_string($_POST['login']);
    $password = $_POST['password'];

    // Check if the login input is an email or username
    if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
        $query = "SELECT id, username, email, password, role FROM users WHERE email = '$login'";
    } else {
        $query = "SELECT id, username, email, password, role FROM users WHERE username = '$login'";
    }

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on role
            if ($user['role'] === 'admin') {
                header('Location: admin_dashboard.php');
            } else {
                header('Location: index.php');
            }
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with this username or email.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <form method="POST" action="login.php">
        <h2>Login</h2>
        <label for="login">Username or Email:</label>
        <input type="text" id="login" name="login" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Login</button>
        <p>Don't have an account? <a href="register_form.php">Register</a></p>
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

    form p {
        text-align: center;
    }

    form a {
        color: #333;
    }

    form a:hover {
        text-decoration: underline;
    }
</style>
