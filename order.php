<?php
session_start();
require 'db.php';

$message = $error = '';

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize the input data
    $user_id = $_SESSION['user_id']; // Assuming the user is logged in
    $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
    $quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);

    // Validate product ID and quantity
    if (!$product_id || $product_id <= 0) {
        $error = "Invalid product ID.";
    } elseif (!$quantity || $quantity <= 0) {
        $error = "Invalid quantity.";
    } else {
        try {
            // Calculate the total cost based on product price and quantity
            $stmt = $pdo->prepare('SELECT price FROM products WHERE id = ?');
            $stmt->execute([$product_id]);
            $product = $stmt->fetch();
            if ($product) {
                $total_cost = $product['price'] * $quantity;

                // Get the current date and time for order_date
                $order_date = date('Y-m-d H:i:s');

                // Save the order to the database
                $pdo->beginTransaction(); // Start a transaction

                // Insert into the orders table
                $stmt = $pdo->prepare('INSERT INTO orders (user_id, total_cost, order_date) VALUES (?, ?, ?)');
                $stmt->execute([$user_id, $total_cost, $order_date]);
                $order_id = $pdo->lastInsertId(); // Get the ID of the inserted order

                // Insert into the order_details table
                $stmt = $pdo->prepare('INSERT INTO order_details (order_id, product_id, quantity) VALUES (?, ?, ?)');
                $stmt->execute([$order_id, $product_id, $quantity]);

                $pdo->commit(); // Commit the transaction
                $message = "Order placed successfully!";
            } else {
                $error = "Product not found.";
            }
        } catch (Exception $e) {
            $pdo->rollBack(); // Roll back the transaction if an error occurred
            $error = "Error placing the order: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Order</title>
    <link rel="stylesheet" href="./css/order.css">
</head>
<body>
    <div class="container">
        <h2>Place Order</h2>
        <?php if ($message): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>
        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST" action="order.php">
            <label for="product_id">Product ID:</label>
            <input type="text" name="product_id" id="product_id" required><br>
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity" required><br>
            <button type="submit">Place Order</button>
        </form>
    </div>
</body>
</html>
