<?php
require_once 'database_connection.php';

$couponCode = $_POST['couponCode'];
$subtotal = $_POST['subtotal'];

$discountedSubtotal = applyCoupon($couponCode, $subtotal);

echo json_encode(array('success' => true, 'discountedSubtotal' => $discountedSubtotal));
?>
