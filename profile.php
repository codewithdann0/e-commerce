<?php
require 'header.php';
?>
<?php
require 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Fetch user information from the database
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// Fetch user's orders from the database
$stmt = $pdo->prepare('SELECT id FROM orders WHERE user_id = ?');
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="./css/profile.css?v=1.1.14"> <!-- You may need to adjust the path -->
</head>
<body>
    <div class="container">
        <div>
        <h2>User Profile</h2>
        <!-- User Information Form -->
        <form method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?= isset($user['username']) ? htmlspecialchars($user['username']) : '' ?>" required><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= isset($user['email']) ? htmlspecialchars($user['email']) : '' ?>" required><br>
            <button type="submit">Update</button>
        </form>
        <div class="links">
            <!-- Link to View Orders -->
            <a href="order.php">Order</a><br>
            <!-- Links to Order Details -->
            
            <?php foreach ($orders as $order): ?>
               <a href="order_detail.php?id=<?php echo $order['id']; ?>">Orders</a><br>
        <?php endforeach; ?>

            
        </div>
        <!-- Logout Link -->
        <div class="logout-link">
            <a href="logout.php">Logout</a>
        </div>
     </div>
    </div>
</body>
</html>
<?php require_once 'footer.php'; ?>
