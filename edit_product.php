<?php
session_start();
include 'config.php';

// Check if admin is logged in
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Initialize variables
$message = '';
$product_id = $_GET['id'] ?? null;

// Fetch product details based on product_id
$conn = openDbConnection();
$query = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Product not found.");
}

$product = $result->fetch_assoc();

// Handle form submission to update product
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $price = $_POST['price'];
    $brandname = $_POST['brandname'];
    $description = $_POST['description'];
    $featured = isset($_POST['featured']) ? 1 : 0;

    // Update product in the database
    $update_query = "UPDATE products SET title = ?, price = ?, brandname = ?, description = ?, featured = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sdsiii", $title, $price, $brandname, $description, $featured, $product_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $message = "Product updated successfully!";
    } else {
        $message = "Error updating product: " . $conn->error;
    }

    $stmt->close();
    $_SESSION['message'] = $message;
    header("Location: view_products.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Edit Product</title>
</head>
<body>

<!-- Include Admin Header -->
<?php include 'admin_header.php'; ?>

<div class="container">
    <h2>Edit Product</h2>

    <?php if (!empty($message)): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($product['title']); ?>" required>
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
        </div>
        <div class="form-group">
            <label for="brandname">Brand Name:</label>
            <input type="text" id="brandname" name="brandname" value="<?php echo htmlspecialchars($product['brandname']); ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" required><?php echo htmlspecialchars($product['description']); ?></textarea>
        </div>
        <div class="form-group">
            <input type="checkbox" id="featured" name="featured" value="1" <?php echo $product['featured'] ? 'checked' : ''; ?>>
            <label for="featured">Featured</label>
        </div>
        <button type="submit" class="btn">Update Product</button>
    </form>
</div> <!-- End .container -->

</body>
</html>

<style>
/* Add your custom styles here */
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

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    margin-bottom: 5px;
}

input[type="text"], input[type="number"], textarea {
    width: 100%;
    padding: 8px;
    box-sizing: border-box;
}

textarea {
    resize: vertical;
}

.btn {
    padding: 8px 16px;
    background-color: #007bff;
    color: white;
    border: none;
    cursor: pointer;
    border-radius: 4px;
    font-size: 16px;
}

.btn:hover {
    background-color: #0056b3;
}
</style>
