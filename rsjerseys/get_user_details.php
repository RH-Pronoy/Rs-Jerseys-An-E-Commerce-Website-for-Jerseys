<?php
session_start();
header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

$userId = $_SESSION['user_id'];

// Include your database connection
require_once('database_connection.php');

// Fetch user details from the database
try {
    $stmt = $conn->prepare("SELECT name, phone, email, address FROM users WHERE id = ?");
    if (!$stmt) {
        throw new Exception("Prepare statement failed: " . $conn->error);
    }

    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        echo json_encode($user);
    } else {
        echo json_encode(['error' => 'User not found']);
    }
} catch (Exception $e) {
    // Log error to a file
    error_log('Failed to fetch user details: ' . $e->getMessage(), 3, 'errors.log');
    echo json_encode(['error' => 'Failed to fetch user details. Please try again later.']);
}
?>
