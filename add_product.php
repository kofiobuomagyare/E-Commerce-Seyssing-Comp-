<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'config.php';

// Check if admin is logged in
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Establish database connection
$conn = openDbConnection();

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $title = $_POST['title'];
    $price = $_POST['price'];
    $brandname = $_POST['brandname'];
    $description = $_POST['description'];
    $featured = isset($_POST['featured']) ? 1 : 0;

    // File upload handling
    $image = ''; // Placeholder for image path or filename

    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['image']['tmp_name'];
        $filename = basename($_FILES['image']['name']);
        $upload_dir = 'uploads/'; // Directory where images will be stored
        $image = $upload_dir . $filename;
        move_uploaded_file($tmp_name, $image);
    }

    // Insert into database
    $query = "INSERT INTO products (title, price, brandname, description, featured, image) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sdssis", $title, $price, $brandname, $description, $featured, $image);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Product added successfully!";
    } else {
        echo "Error adding product: " . $conn->error;
    }

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
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Admin Dashboard - SeyssingComp</title>
</head>
<body>

<!-- Include Admin Header -->
<?php include 'admin_header.php'; ?>

<section class="admin-dashboard">
    <h2>Welcome to the Admin Dashboard!</h2>
    <p>Use the navigation menu to manage users and orders.</p>
</section>

<section class="add_products">
    <form action="add_product.php" method="post" enctype="multipart/form-data">
        <label>Title:</label>
        <input type="text" name="title" required><br><br>

        <label>Price:</label>
        <input type="number" step="0.01" name="price" required><br><br>

        <label>Brand Name:</label>
        <input type="text" name="brandname"><br><br>

        <label>Description:</label><br>
        <textarea name="description" rows="4"></textarea><br><br>

        <label>Featured:</label>
        <input type="checkbox" name="featured" value="1"><br><br>

        <label>Image:</label>
        <input type="file" name="image" accept="image/*" required><br><br>

        <button type="submit" name="submit">Add Product</button>
    </form>
</section>
</body>
</html>


<style>
    /* Form Styles */
form {
    max-width: 600px;
    margin: 20px auto;
    padding: 20px;
    background: #fff;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

form label {
    display: block;
    margin-bottom: 8px;
}

form input[type=text],
form input[type=number],
form textarea {
    width: calc(100% - 20px);
    padding: 8px;
    margin-bottom: 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

form input[type=file] {
    margin-top: 8px;
}

form button[type=submit] {
    display: inline-block;
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

form button[type=submit]:hover {
    background-color: #0056b3;
}

/* Table Styles */
table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    background: #fff;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

table th,
table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

thead {
    background-color: #007bff;
    color: white;
}

tbody tr:hover {
    background-color: #f2f2f2;
}

tbody td {
    vertical-align: middle;
}

/* Status Colors */
td.active {
    color: green;
}

td.inactive {
    color: red;
}

/* Responsive Design */
@media only screen and (max-width: 768px) {
    form {
        max-width: 100%;
    }

    table {
        font-size: 14px;
    }
}

@media only screen and (max-width: 480px) {
    form {
        padding: 10px;
    }

    form input[type=text],
    form input[type=number],
    form textarea {
        width: 100%;
    }

    form button[type=submit] {
        padding: 8px 16px;
        font-size: 14px;
    }

    table {
        font-size: 12px;
    }
}

</style>