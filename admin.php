<?php 
require_once 'header.php'; 
require_once 'db.php';
require_once 'functions.php'; // Use require_once to ensure it's included only once

// Check if the user is an admin
if (!isset($_SESSION['user_id']) || !isAdmin($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Fetch all users with error handling
try {
    $stmt = $pdo->query('SELECT * FROM users');
    $users = $stmt->fetchAll();
} catch (PDOException $e) {
    echo 'Error fetching users: ' . $e->getMessage();
    exit;
}

// Fetch all orders with error handling
try {
    $stmt = $pdo->query('SELECT * FROM orders');
    $orders = $stmt->fetchAll();
} catch (PDOException $e) {
    echo 'Error fetching orders: ' . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="./css/admin.css">
</head>
<body>
    <h2>Admin Dashboard</h2>
    <h3>Users</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['id']) ?></td>
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td>
                    <!-- Add edit and delete buttons if necessary -->
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h3>Orders</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>User ID</th>
            <th>Total Cost</th>
            <th>Order Date</th>
        </tr>
        <?php foreach ($orders as $order): ?>
            <tr>
                <td><?= htmlspecialchars($order['id']) ?></td>
                <td><?= htmlspecialchars($order['user_id']) ?></td>
                <td><?= htmlspecialchars($order['total_cost']) ?></td>
                <td><?= htmlspecialchars($order['order_date']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
<?php require_once 'footer.php'; ?>
