<?php
require_once 'database_connection.php';

$deliveryOption = $_POST['deliveryOption'];
$subtotal = $_POST['subtotal'];

updateDeliveryCost($deliveryOption, $subtotal);

echo json_encode(array('success' => true));
?>