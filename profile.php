<?php include 'header.php'; ?>
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

// Handle form submission for updating user information
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and update user information (you can add validation here)
    $username = $_POST['username'];
    $email = $_POST['email'];

    $stmt = $pdo->prepare('UPDATE users SET username = ?, email = ? WHERE id = ?');
    $stmt->execute([$username, $email, $user_id]);

    // Redirect back to profile page after updating
    header('Location: profile.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="./css/profile.css"> <!-- You may need to adjust the path -->
</head>
<body>
    <div class="container">
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
            <!-- Links to Order-related Pages -->
            <a href="order.php">View Orders</a>
            <a href="order_detail.php">Order Details</a>
        </div>
        <!-- Logout Link -->
        <div class="logout-link">
            <a href="logout.php">Logout</a>
        </div>
    </div>
</body>
</html>
<?php require_once 'footer.php'; ?>