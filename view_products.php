<?php
session_start();
include 'config.php';

// Check if admin is logged in
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Initialize message variable
$message = '';

// Handle product deletion and editing
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_product'])) {
        $product_id = $_POST['product_id'];

        // Establish database connection
        $conn = openDbConnection();

        // Delete product from database
        $delete_query = "DELETE FROM products WHERE id = ?";
        $stmt = $conn->prepare($delete_query);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $message = "Product deleted successfully!";
        } else {
            $message = "Error deleting product: " . $conn->error;
        }

        $stmt->close();
        $conn->close();

        // Redirect to refresh the page after deletion
        $_SESSION['message'] = $message;
        header('Location: view_products.php');
        exit();
    } elseif (isset($_POST['edit_product'])) {
        $product_id = $_POST['product_id'];
        header("Location: edit_product.php?id=$product_id");
        exit();
    }
}

// Fetch products from database
$conn = openDbConnection();
$query = "SELECT * FROM products";
$result = $conn->query($query);

if (!$result) {
    die("Error fetching products: " . $conn->error);
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Admin Dashboard - Products</title>
</head>
<body>

<!-- Include Admin Header -->
<?php include 'admin_header.php'; ?>

<div class="container">
    <h2>Products Management</h2>

    <?php if (!empty($_SESSION['message'])): ?>
        <div class="message"><?php echo $_SESSION['message']; ?></div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Title</th>
                <th>Price</th>
                <th>Brand Name</th>
                <th>Description</th>
                <th>Featured</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo htmlspecialchars($row['price']); ?></td>
                    <td><?php echo htmlspecialchars($row['brandname']); ?></td>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td><?php echo $row['featured'] ? 'Yes' : 'No'; ?></td>
                    <td>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="edit_product" class="btn btn-small">Edit</button>
                            <button type="submit" name="delete_product" class="btn btn-small">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div> <!-- End .container -->

</body>
</html>



<style>
/* General Styles */
/* General Styles */
body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.container {
    width: 80%;
    margin: auto;
    overflow: hidden;
    padding-top: 150px; /* Increase padding to prevent content hiding under header */
}

h2 {
    color: #333;
}

.message {
    background-color: #4CAF50;
    color: white;
    padding: 10px;
    margin-bottom: 10px;
}

.table-responsive {
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
    background: #fff;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
}

table th, table td {
    padding: 15px;
    text-align: left;
}

thead {
    background-color: #333;
    color: #fff;
}

th, td {
    border-bottom: 1px solid #ddd;
}

tbody tr:hover {
    background-color: #f2f2f2;
}

.btn {
    padding: 8px 16px;
    background-color: #007bff;
    color: white;
    border: none;
    cursor: pointer;
    border-radius: 4px;
}

.btn-small {
    font-size: 14px;
    margin-right: 5px; /* Add margin between buttons */
}

/* Responsive Design */
@media only screen and (max-width: 768px) {
    .container {
        width: 90%;
        padding-top: 170px; /* Adjust padding for mobile view if necessary */
    }

    table {
        font-size: 14px;
    }
}


</style>