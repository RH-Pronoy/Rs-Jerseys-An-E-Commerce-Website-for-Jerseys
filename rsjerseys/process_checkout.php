<?php
session_start();
include('database_connection.php'); // Include your database connection file

// Check if user is logged in
$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}


$deliveryOption = $_POST['delivery-option'] ?? '0';
// Get form data
$name = $_POST['name'] ?? '';
$phone = $_POST['phone'] ?? '';
$email = $_POST['email'] ?? '';
$address = $_POST['address'] ?? '';
$district = $_POST['district'] ?? '';
$cartData = $_POST['cart'] ?? '[]';
//$deliveryOption = isset($_POST['delivery-option']) ? (int)$_POST['delivery-option'] : 0;
$couponCode = $_POST['coupon'] ?? ''; // Coupon code

$orderItems = []; // Array to hold order items for later insertion

// Function to get product price from multiple tables
function getProductPrice($productName, $conn) {
    $tables = ['arrivals', 'season24_25', 'season23_24', 'retro', 'national', 'fan_edition'];
    foreach ($tables as $table) {
        $priceQuery = "SELECT price FROM $table WHERE name = ?";
        $stmtPrice = $conn->prepare($priceQuery);
        $stmtPrice->bind_param("s", $productName);
        $stmtPrice->execute();
        $stmtPrice->bind_result($productPrice);
        if ($stmtPrice->fetch()) {
            $stmtPrice->close();
            return $productPrice;
        }
        $stmtPrice->close();
    }
    return null; // Return null if product not found in any table
}

// Function to calculate discount based on coupon code
function applyDiscount($subtotal, $couponCode) {
    $validCoupon = 'RS10JERSEYS'; // Example: 10% discount for valid coupon
    if ($couponCode === $validCoupon) {
        return $subtotal * 0.10; // 10% discount
    }
    return 0; // No discount if the coupon is invalid
}

// Calculate subtotal and total quantity
$cart = json_decode($cartData, true);
$subtotal = 0;
$totalQuantity = 0;

foreach ($cart as $item) {
    $productName = $item['name'];
    
    // Fetch the product price from the multiple tables
    $productPrice = getProductPrice($productName, $conn);
    if ($productPrice === null) {
        echo json_encode(['status' => 'error', 'message' => "Product '$productName' not found"]);
        exit;
    }

    // Calculate subtotal and quantities for each size
    foreach (['M', 'L', 'XL', 'XXL'] as $size) {
        $sizeQuantity = $item["size{$size}Quantity"];
        if ($sizeQuantity > 0) {
            $subtotal += $sizeQuantity * $productPrice; // Use fetched product price
            $totalQuantity += $sizeQuantity;

            // Store order item details
            $orderItems[] = [
                'product_name' => $productName,
                'size' => $size,
                'quantity' => $sizeQuantity,
                'price' => $productPrice
            ];
        }
    }
}

// Apply coupon discount
$discount = applyDiscount($subtotal, $couponCode);
$discountedSubtotal = $subtotal - $discount; // Subtotal after discount

// Calculate total cost
$totalCost = $discountedSubtotal + $deliveryOption;

// Insert order into 'orders' table
// Insert order into 'orders' table, now including delivery_cost
$orderQuery = "INSERT INTO orders (user_id, username, userphone, useremail, useraddress, userdistrict, total_quantity, subtotal, discount, delivery_cost, total_price, order_status) 
               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending')";

$stmt = $conn->prepare($orderQuery);
$stmt->bind_param("isssssidddd", $userId, $name, $phone, $email, $address, $district, $totalQuantity, $subtotal, $discount, $deliveryOption, $totalCost);


if ($stmt->execute()) {
    $orderId = $stmt->insert_id; // Get the last inserted order ID

    // Prepare order items insertion for each item
    $orderItemsQuery = "INSERT INTO order_items (order_id, user_id, product_name, size, quantity, price) 
                        VALUES (?, ?, ?, ?, ?, ?)";

    $stmtDetail = $conn->prepare($orderItemsQuery);
    foreach ($orderItems as $item) {
        $stmtDetail->bind_param("iissid", $orderId, $userId, $item['product_name'], $item['size'], $item['quantity'], $item['price']);
        if (!$stmtDetail->execute()) {
            file_put_contents('checkout_error.log', "Failed to insert order item: " . $stmtDetail->error . "\n", FILE_APPEND);
        }
    }

    echo json_encode(['status' => 'success', 'message' => 'Order placed successfully']);
    // Clear cart here if needed
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to place order']);
}

$stmt->close();
$stmtDetail->close();
$conn->close();
?>
