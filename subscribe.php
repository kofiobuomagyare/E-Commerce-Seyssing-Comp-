<?php
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $email = $data['email'];

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "your_database";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]);
            exit();
        }

        $stmt = $conn->prepare("INSERT INTO subscribers (email) VALUES (?)");
        if (!$stmt) {
            echo json_encode(['success' => false, 'message' => 'Prepare statement failed: ' . $conn->error]);
            exit();
        }

        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Subscription successful!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Execute statement failed: ' . $stmt->error]);
        }

        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid email address.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
