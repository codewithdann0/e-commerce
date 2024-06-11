<?php include 'header.php'; ?>
<?php
require 'db.php';

session_start();
// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Retrieve order details
$order_id = $_GET['id'] ?? null; // Make sure the order ID is being passed correctly
if (!$order_id) {
    echo "Order ID is missing!";
    exit;
}

$user_id = $_SESSION['user_id'];




// Fetch order details from the 'orders' table
$stmt = $pdo->prepare('SELECT * FROM orders WHERE id = ? AND user_id = ?');
$stmt->execute([$order_id, $user_id]);
$order = $stmt->fetch();

if (!$order) {
    echo "Order not found in the orders table!";
    exit;
}

// Fetch order details from the 'order_details' and 'products' tables
$stmt = $pdo->prepare('SELECT od.quantity, od.price, p.name FROM order_details od JOIN products p ON od.product_id = p.id WHERE od.order_id = ?');
$stmt->execute([$order_id]);
$order_details = $stmt->fetchAll();

if (!$order_details) {
    echo "Order details not found!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link rel="stylesheet" href="./css/order_detail.css?V=1.0.3">
</head>
<body>
    <div class="container">
        <h2>Order Details</h2>
        <div>
            <p><strong>Order ID:</strong> <?= htmlspecialchars($order['id']) ?></p>
            <p><strong>Total Cost:</strong> $<?= htmlspecialchars($order['total_cost']) ?></p>
            <p><strong>Order Date:</strong> <?= htmlspecialchars($order['order_date']) ?></p>
        </div>
        <h3>Products Ordered</h3>
        <div class="order-details">
            <?php foreach ($order_details as $detail): ?>
                <div class="product">
                    <p><strong>Name:</strong> <?= htmlspecialchars($detail['name']) ?></p>
                    <p><strong>Quantity:</strong> <?= htmlspecialchars($detail['quantity']) ?></p>
                    <p><strong>Price:</strong> $<?= htmlspecialchars($detail['price']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
<?php require 'footer.php'; ?>