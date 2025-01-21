<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit();
}

$order_id = $_GET['order_id'];
$user_id = $_SESSION['user_id'];

$conn = new mysqli("localhost", "root", "", "rsjersey");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the order belongs to the user and is not yet shipped
$sql = "SELECT * FROM orders WHERE order_id = ? AND user_id = ? AND order_status != 'shipped'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Update the order status to 'canceled'
    $sql_update = "UPDATE orders SET order_status = 'canceled' WHERE order_id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("i", $order_id);
    if ($stmt_update->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to cancel order']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Order not found or already shipped']);
}

$stmt->close();
$conn->close();
?>
