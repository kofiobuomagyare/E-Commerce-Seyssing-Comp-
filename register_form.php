<?php
// Database connection
$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "shop_db"; // Use your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role']; // Use 'role' instead of 'status'

    // Check if email already exists
    $email_check_query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
    $result = $conn->query($email_check_query);

    if ($result->num_rows > 0) {
        echo "Error: Email already exists.";
    } else {
        if ($password == $confirm_password) {
            // Hash the password before saving
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new user into the database
            $sql = "INSERT INTO users (fullname, username, phone, email, password, role)
                    VALUES ('$fullname', '$username', '$phone', '$email', '$hashed_password', '$role')";

            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
                header("Location: login.php"); // Redirect to login page after registration
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Error: Passwords do not match.";
        }
    }
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <form method="POST" action="register_form.php">
        <h2>Register</h2>
        <label for="fullname">Full Name:</label>
        <input type="text" id="fullname" name="fullname" required>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
        <label for="role">Role:</label>
        <select id="role" name="role" required>
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>
        <button type="submit">Register</button>
        <p>Already have an account? <a href="login.php">Login</a></p>
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

form input, form select {
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
