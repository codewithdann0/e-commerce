<?php
require 'header.php';
?>
<?php
require 'db.php';

$limit = 15;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$query = 'SELECT * FROM products WHERE 1';
$params = [];

if (!empty($_GET['search'])) {
    $query .= ' AND name LIKE ?';
    $params[] = '%' . $_GET['search'] . '%';
}

if (!empty($_GET['min_price']) && !empty($_GET['max_price'])) {
    $query .= ' AND price BETWEEN ? AND ?';
    $params[] = $_GET['min_price'];
    $params[] = $_GET['max_price'];
}

$totalQuery = str_replace('SELECT *', 'SELECT COUNT(*)', $query);
$stmt = $pdo->prepare($totalQuery);
$stmt->execute($params);
$total = $stmt->fetchColumn();
$pages = ceil($total / $limit);

$query .= ' LIMIT ? OFFSET ?';
$params[] = $limit;
$params[] = $offset;

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" href="./css/product_list.css?v=1.0.16">
</head>
<style>
</style>
<body>
    <h2>Products</h2>
    <form method="GET">
        <input type="text" name="search" placeholder="Search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
        <input type="number" name="min_price" placeholder="Min Price" value="<?= htmlspecialchars($_GET['min_price'] ?? '') ?>">
        <input type="number" name="max_price" placeholder="Max Price" value="<?= htmlspecialchars($_GET['max_price'] ?? '') ?>">
        <button type="submit">Filter</button>
    </form>
    <div class="container">
        <?php foreach ($products as $product): ?>
            <div>
                <img id="pro-img" src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                <h2><?= htmlspecialchars($product['name']) ?></h2>
                <p><?= htmlspecialchars($product['description']) ?></p>
                <p>$<?= htmlspecialchars($product['price']) ?></p>
                <a href="product_detail.php?id=<?= $product['id'] ?>">View Details</a>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="pages">
        <?php for ($i = 1; $i <= $pages; $i++): ?>
            <a href="?page=<?= $i ?>&search=<?= htmlspecialchars($_GET['search'] ?? '') ?>&min_price=<?= htmlspecialchars($_GET['min_price'] ?? '') ?>&max_price=<?= htmlspecialchars($_GET['max_price'] ?? '') ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
</body>
</html>
<?php require 'footer.php'; ?>
