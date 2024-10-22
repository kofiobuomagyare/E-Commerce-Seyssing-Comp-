<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $product = $data['product'];
    $rating = (int) $data['rating'];

    if ($rating < 1 || $rating > 5) {
        echo json_encode(['success' => false, 'message' => 'Invalid rating value.']);
        exit();
    }

    if (!isset($_SESSION['ratings'])) {
        $_SESSION['ratings'] = [];
    }

    $_SESSION['ratings'][$product] = $rating;

    $new_rating = 4.5; // This should be calculated based on actual ratings

    echo json_encode(['success' => true, 'new_rating' => $new_rating]);
    exit();
}

echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
exit();
?>
