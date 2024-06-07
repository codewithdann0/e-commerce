<?php
session_start();
require 'db.php';

// Check if the user is an admin (implement admin check as needed)
if (!isset($_SESSION['user_id']) /* || !isAdmin($_SESSION['user_id']) */) {
    header('Location: login.php');
    exit;
}

// Handle product actions (add, edit, delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add product
    if (isset($_POST['add'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $image = $_POST['image'];

        $stmt = $pdo->prepare('INSERT INTO products (name, description, price, image) VALUES (?, ?, ?, ?)');
        $stmt->execute([$name, $description, $price, $image]);
    }
    // Edit product
    elseif (isset($_POST['edit'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $image = $_POST['image'];

        $stmt = $pdo->prepare('UPDATE products SET name = ?, description = ?, price = ?, image = ? WHERE id = ?');
        $stmt->execute([$name, $description, $price, $image, $id]);
    }
    // Delete product
    elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];

        $stmt = $pdo->prepare('DELETE FROM products WHERE id = ?');
        $stmt->execute([$id]);
    }
}

// Fetch all products
$stmt = $pdo->query('SELECT * FROM products');
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
</head>
<body>
    <h2>Manage Products</h2>
    <form method="POST">
        <input type="hidden" name="id" value="">
        <input type="text" name="name" placeholder="Name" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <input type="number" name="price" placeholder="Price" required>
        <input type="text" name="image" placeholder="Image URL" required>
        <button type="submit" name="add">Add Product</button>
    </form>
    <h3>Existing Products</h3>
    <?php foreach ($products as $product): ?>
        <div>
            <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
            <h3><?= htmlspecialchars($product['name']) ?></h3>
            <p><?= htmlspecialchars($product['description']) ?></p>
            <p>$<?= htmlspecialchars($product['price']) ?></p>
            <form method="POST">
                <input type="hidden" name="id" value="<?= $product['id'] ?>">
                <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
                <textarea name="description" required><?= htmlspecialchars($product['description']) ?></textarea>
                <input type="number" name="price" value="<?= htmlspecialchars($product['price']) ?>" required>
                <input type="text" name="image" value="<?= htmlspecialchars($product['image']) ?>" required>
                <button type="submit" name="edit">Edit</button>
                <button type="submit" name="delete">Delete</button>
            </form>
        </div>
    <?php endforeach; ?>
</body>
</html>
