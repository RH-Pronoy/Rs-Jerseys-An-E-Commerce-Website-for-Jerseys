<?php
session_start();
include('database_connection.php'); // Include your database connection file

// Check if user is logged in
$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

// Get the product ID from the form submission
$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;

// Get the review data from the form
$rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;
$review_text = isset($_POST['review_text']) ? trim($_POST['review_text']) : '';

// Validate the review data
if ($product_id <= 0 || $rating < 1 || $rating > 5 || empty($review_text)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid review data']);
    exit;
}

// Insert the review into the database
$sql = "INSERT INTO reviews (product_id, product_type, user_id, user_name, rating, review_text, review_date) VALUES (?, ?, ?, ?, ?, ?, NOW())";
$stmt = $conn->prepare($sql);

// Assuming you have a way to determine the product type
$product_type = 'arrivals'; // Example: change this based on your application logic

$userName = $_SESSION['user_name'] ?? 'Anonymous'; // Fallback in case username is not set

$stmt->bind_param("isssis", $product_id, $product_type, $userId, $userName, $rating, $review_text);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Review submitted successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to submit review: ' . $stmt->error]); // Added error detail for debugging
}

$stmt->close();
$conn->close();
?>
