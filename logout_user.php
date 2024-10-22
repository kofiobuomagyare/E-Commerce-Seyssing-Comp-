<?php
session_start();
include 'config.php';

// Check if admin is logged in
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Handle form submission for logging out user
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    
    // Optional: Validate if the user ID exists or is valid in your database
    // Example: You might check if $user_id exists in your `users` table before logging them out
    
    // Retrieve user status from session or database (assuming it's stored in $_SESSION['users'][$user_id]['status'])
    $user_status = isset($_SESSION['users'][$user_id]['status']) ? $_SESSION['users'][$user_id]['status'] : 'unknown';

    // Check user status and log out accordingly
    if ($user_status === 'user') {
        // Destroy the session for a regular user
        if (isset($_SESSION['users'][$user_id])) {
            unset($_SESSION['users'][$user_id]);
        }
    } elseif ($user_status === 'admin') {
        // Optionally, handle logging out an admin (if needed)
        // This example does not log out admins, as per the requirement
        // You can add specific logic here if admins need to be logged out
        // For instance, unset($_SESSION['users'][$user_id]) for admins
    }

    // Redirect back to user management page after logout
    header('Location: view_users.php');
    exit();
} else {
    // Handle cases where user_id is not provided or form method is not POST
    // Redirect to an error page or handle gracefully
    header('Location: view_users.php'); // Redirect to user management page by default
    exit();
}
?>
