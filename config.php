<?php
function openDbConnection() {
    $servername = "localhost:3306";
    $username = "root";
    $password = "";
    $dbname = "shop_db";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}
?>