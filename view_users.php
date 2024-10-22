<?php
// Start session or resume existing session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include config file for database connection
include 'config.php';

// Check if admin is logged in
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Establish database connection
$conn = openDbConnection();

// Fetch users from the database
$query = "SELECT * FROM users";
$result = $conn->query($query);

// Check for errors
if (!$result) {
    die("Error fetching users: " . $conn->error);
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

<!-- Include Admin Header -->
<?php include 'admin_header.php'; ?>

<section class="admin-dashboard">
    
    <div class="dashboard-header">
        <h2>Welcome, Admin!</h2>
        <h3>User Management</h3>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['fullname']); ?></td>
                        <td><?php echo isset($row['status']) ? htmlspecialchars($row['status']) : 'Unknown'; ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['phone']); ?></td>
                        <td>
                            <form action="edit_user.php" method="post" class="user-action-form">
                                <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="action" value="edit" class="btn btn-edit">Edit</button>
                            </form>
                            <form action="delete_user.php" method="post" class="user-action-form">
                                <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="action" value="delete" class="btn btn-delete">Delete</button>
                            </form>
                            <form action="logout_user.php" method="post" class="user-action-form">
                                <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="action" value="logout" class="btn btn-logout">Log Out</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</section>

</body>
</html>

<?php
// Close database connection
$conn->close();
?>

<style>
   /* Reset default margin and padding */
body, html {
    margin: 0;
    padding: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    line-height: 1.6;
    background-color: #f0f0f0;
}

/* Make the header fixed */
header {
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 1000;
    background-color: #fff;
    border-bottom: 1px solid #ddd;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Add top padding to main content */
.admin-dashboard {
    max-width: 1000px;
    margin: 80px auto 20px auto; /* Adjusted margin to account for the header height */
    padding: 20px;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

/* Header styling */
.dashboard-header {
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 1px solid #ddd;
}

.dashboard-header h2 {
    font-size: 28px;
    color: #333;
    margin-top: 0;
}

.dashboard-header h3 {
    font-size: 20px;
    color: #666;
    margin-top: 5px;
}

/* Styling for the table */
.table-container {
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background-color: #fff;
}

table th, table td {
    border: 1px solid #ddd;
    padding: 12px;
    text-align: left;
}

table th {
    background-color: #f2f2f2;
    font-size: 14px;
    font-weight: bold;
    color: #333;
    text-transform: uppercase;
}

table td {
    font-size: 14px;
    color: #666;
}

/* Styling for action buttons */
.btn {
    border: none;
    padding: 8px 16px;
    cursor: pointer;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

.btn.btn-edit {
    background-color: #3498db;
    color: #fff;
}

.btn.btn-delete {
    background-color: #e74c3c;
    color: #fff;
}

.btn.btn-logout {
    background-color: #f39c12;
    color: #fff;
}

.btn:hover {
    opacity: 0.8;
}

/* Responsive design for smaller screens */
@media only screen and (max-width: 768px) {
    .admin-dashboard {
        padding: 15px;
    }

    table {
        font-size: 12px;
    }

    .btn {
        padding: 6px 12px;
    }
}

</style>
