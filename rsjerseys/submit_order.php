<?php
session_start();
include 'database_connection.php'; // Include your database connection file

// Decode the JSON data from the request
$data = json_decode(file_get_contents("php://input"), true);

// Validate required fields
if (empty($data['name']) || empty($data['phone']) || empty($data['address']) || empty($_SESSION['cart'])) {
    echo json_encode(['success' => false, 'message' => 'Required fields or cart is missing']);
    exit;
}

// Prepare variables
$user_id = $_SESSION['user_id'] ?? null;
$order_id = strtoupper(uniqid('ORD_')); // Generate unique order ID
$cart = $_SESSION['cart']; // The cart should contain product details

// Insert into `user_orders` table
try {
    $pdo->beginTransaction(); // Begin a transaction

    $sqlUserOrder = "INSERT INTO user_orders (order_id, user_name, user_phone, user_email, delivery_address, total_cost, order_time, order_status)
                     VALUES (:order_id, :user_name, :user_phone, :user_email, :delivery_address, :total_cost, CURRENT_TIMESTAMP, 'pending')";

    $stmtUserOrder = $pdo->prepare($sqlUserOrder);
    $stmtUserOrder->execute([
        ':order_id' => $order_id,
        ':user_name' => $data['name'],
        ':user_phone' => $data['phone'],
        ':user_email' => $data['email'] ?? null, // Optional email field
        ':delivery_address' => $data['address'],
        ':total_cost' => $data['totalCost']
    ]);

    // Insert into `ordered_products` table for each product in the cart
    $sqlOrderedProducts = "INSERT INTO ordered_products (order_id, product_id, size_M, size_L, size_XL, size_XXL, total_price, order_time)
                           VALUES (:order_id, :product_id, :size_M, :size_L, :size_XL, :size_XXL, :total_price, CURRENT_TIMESTAMP)";

    $stmtOrderedProducts = $pdo->prepare($sqlOrderedProducts);

    foreach ($cart as $product) {
        $stmtOrderedProducts->execute([
            ':order_id' => $order_id,
            ':product_id' => $product['id'], // Assuming the product ID is stored in the cart
            ':size_M' => $product['size_m'] ?? 0,  // Default to 0 if not provided
            ':size_L' => $product['size_l'] ?? 0,
            ':size_XL' => $product['size_xl'] ?? 0,
            ':size_XXL' => $product['size_xxl'] ?? 0,
            ':total_price' => $product['price'] * $product['quantity'] // Calculate total price for the product
        ]);
    }

    // Commit the transaction
    $pdo->commit();

    // Clear the cart after successful order
    unset($_SESSION['cart']);

    echo json_encode(['success' => true, 'message' => 'Order placed successfully']);
} catch (Exception $e) {
    // Rollback the transaction if something goes wrong
    $pdo->rollBack();
    echo json_encode(['success' => false, 'message' => 'Failed to place order', 'error' => $e->getMessage()]);
}
?>
