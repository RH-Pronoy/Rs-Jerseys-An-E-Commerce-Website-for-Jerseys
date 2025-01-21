<?php
include('database_connection.php'); // Include your database connection file

session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit;
}

// Fetch all orders
$orderQuery = "SELECT * FROM orders";
$result = $conn->query($orderQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Manage Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        .status-btn {
            padding: 5px 10px;
            margin-right: 5px;
            cursor: pointer;
        }
        .pending { background-color: #ff9800; color: white; }
        .confirmed { background-color: #ffeb3b; color: white; }
        .shipped { background-color: #03a9f4; color: white; }
        .delivered { background-color: #4caf50; color: white; }
        .cancelled { background-color: #f44336; color: white; }
        .view-items-btn {
            background-color: #2196f3;
            color: white;
            padding: 5px 10px;
            cursor: pointer;
        }
        .order-items {
            display: none;
            margin-top: 10px;
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 10px;
        }
        .order-items table {
            width: 100%;
            border-collapse: collapse;
        }
        .order-items th, .order-items td {
            border: 1px solid #ddd;
            padding: 5px;
        }
        .order-items th {
            background-color: #f4f4f4;
        }
    </style>
    <script>
        // Toggle order items visibility
        function toggleOrderItems(orderId) {
            var itemSection = document.getElementById('order-items-' + orderId);
            if (itemSection.style.display === 'none' || itemSection.style.display === '') {
                itemSection.style.display = 'block';
            } else {
                itemSection.style.display = 'none';
            }
        }
    </script>
</head>
<body>

    <h1>Admin Panel - Manage Orders</h1>

    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>User</th>
                <th>Total Quantity</th>
                <th>Subtotal</th>
                <th>Discount</th>
                <th>Delivery Cost</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Action</th>
                <th>View Items</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['order_id']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['total_quantity']; ?></td>
                <td><?php echo number_format($row['subtotal'], 2); ?></td>
                <td><?php echo number_format($row['discount'], 2); ?></td>
                <td><?php echo number_format($row['delivery_cost'], 2); ?></td>
                <td><?php echo number_format($row['total_price'], 2); ?></td>
                <td><?php echo $row['order_status']; ?></td>
                <td>
                    <form action="update_order_status.php" method="POST" style="display:inline;">
                        <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
                        <button class="status-btn pending" type="submit" name="status" value="Pending" <?php echo ($row['order_status'] != 'Pending') ? 'disabled' : ''; ?>>Pending</button>
                        <button class="status-btn confirmed" type="submit" name="status" value="Confirmed" <?php echo ($row['order_status'] != 'Pending') ? 'disabled' : ''; ?>>Confirmed</button>
                        <button class="status-btn shipped" type="submit" name="status" value="Shipped" <?php echo ($row['order_status'] != 'Confirmed') ? 'disabled' : ''; ?>>Shipped</button>
                        <button class="status-btn delivered" type="submit" name="status" value="Delivered" <?php echo ($row['order_status'] != 'Shipped') ? 'disabled' : ''; ?>>Delivered</button>
                        <button class="status-btn cancelled" type="submit" name="status" value="Cancelled" <?php echo ($row['order_status'] == 'Delivered') ? 'disabled' : ''; ?>>Cancelled</button>
                    </form>
                </td>
                <td>
                    <button class="view-items-btn" onclick="toggleOrderItems(<?php echo $row['order_id']; ?>)">View Items</button>
                </td>
            </tr>
            <tr id="order-items-<?php echo $row['order_id']; ?>" class="order-items">
                <td colspan="10">
                    <div>
                        <?php
                        // Fetch order items for this order
                        $orderId = $row['order_id'];
                        $itemsQuery = "SELECT * FROM order_items WHERE order_id = $orderId";
                        $itemsResult = $conn->query($itemsQuery);
                        if ($itemsResult->num_rows > 0) {
                        ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Size</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($itemRow = $itemsResult->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $itemRow['product_name']; ?></td>
                                    <td><?php echo $itemRow['size']; ?></td>
                                    <td><?php echo $itemRow['quantity']; ?></td>
                                    <td><?php echo number_format($itemRow['price'], 2); ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <?php
                        } else {
                            echo "No items found for this order.";
                        }
                        ?>
                    </div>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

</body>
</html>

<?php $conn->close(); ?>
