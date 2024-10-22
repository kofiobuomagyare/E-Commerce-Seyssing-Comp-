<?php
include 'config.php';

$conn = openDbConnection();

if ($conn) {
    echo "Connection successful!";
    $conn->close();
} else {
    echo "Connection failed!";
}
?>
