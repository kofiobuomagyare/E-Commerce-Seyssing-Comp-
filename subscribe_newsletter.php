<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $email = $data['email'];

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Save the email to the session for now (you should save it to a database)
        if (!isset($_SESSION['newsletter'])) {
            $_SESSION['newsletter'] = [];
        }

        $_SESSION['newsletter'][] = $email;

        echo json_encode(['success' => true]);
        exit();
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid email address.']);
        exit();
    }
}

echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
exit();
?>
