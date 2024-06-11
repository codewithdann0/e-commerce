<?php include 'header.php'; ?>
<?php

require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $user_id = $_SESSION['user_id'];

    // Add product to cart
    $stmt = $pdo->prepare('INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)
                           ON DUPLICATE KEY UPDATE quantity = quantity + 1');
    $stmt->execute([$user_id, $product_id]);
}

// Fetch cart items
$stmt = $pdo->prepare('SELECT p.id, p.name, p.price, p.image, c.quantity
                       FROM cart c
                       JOIN products p ON c.product_id = p.id
                       WHERE c.user_id = ?');
$stmt->execute([$_SESSION['user_id']]);
$cart_items = $stmt->fetchAll();

// Calculate total cost
$total_cost = 0;
foreach ($cart_items as $item) {
    $total_cost += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    
    <link rel="stylesheet" href="./css/cart.css?v=1.0.4">
</head>
<body>
    <h2>Shopping Cart</h2>
    <div class="container">
        <?php if ($cart_items): ?>
            <?php foreach ($cart_items as $item): ?>
                <div class="cart-item">
                    <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                    <h3><?= htmlspecialchars($item['name']) ?></h3>
                    <p>Quantity: <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1"></p>
                    <div class="buttons">
                        <form method="POST" action="update_cart.php">
                            <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                            <input type="hidden" name="quantity" value="<?= $item['quantity'] ?>">
                            <button type="submit">Update</button>
                        </form>
                        <form method="POST" action="remove_from_cart.php">
                            <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                            <button type="submit">Remove</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="total-cost">
                <h3>Total Cost: $<?= htmlspecialchars($total_cost) ?></h3>
            </div>
        <?php else: ?>
            <p>Your cart is empty!</p>
        <?php endif; ?>
    </div>
</body>
</html>
<?php require 'footer.php'; ?>