<?php
session_start();
require 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" 
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jacques+Francois&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/header.css">
    <title>Header</title>
</head>
<body>
    <header>
        <div class="logo">
            <a href="index.php">EthioBuy</a>
        </div>
        <nav>
            <ul>
                <li><a href="index.php" class="<?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>"><i class="fa-solid fa-house">  Home</i></a></li>
                <li><a href="product_list.php" class="<?= basename($_SERVER['PHP_SELF']) == 'product_list.php' ? 'active' : '' ?>"><i class="fa-solid fa-shop"> Products</i></a></li>
                <li><a href="cart.php" class="<?= basename($_SERVER['PHP_SELF']) == 'cart.php' ? 'active' : '' ?>"><i class="fa-solid fa-cart-shopping"> Cart </i></a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="profile.php" class="<?= basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'active' : '' ?>"><i class="fa-solid fa-user"> Profile</i></a></li>
                    <li><a href="logout.php"><i class="fa-solid fa-right-from-bracket"> Logout</i></a></li>
                    <?php if (isAdmin($_SESSION['user_id'])): ?>
                     <li><a href="admin.php" class="<?= basename($_SERVER['PHP_SELF']) == 'admin.php' ? 'active' : '' ?>"><i class="fa-brands fa-black-tie"> Admin</i></a></li>
                    <?php endif; ?>
                <?php else: ?>
                    <li><a href="login.php" class="<?= basename($_SERVER['PHP_SELF']) == 'login.php' ? 'active' : '' ?>"><i class="fa-solid fa-right-to-bracket"> Login</i></a></li>
                    <li><a href="register.php" class="<?= basename($_SERVER['PHP_SELF']) == 'register.php' ? 'active' : '' ?>"><i class="fa-solid fa-registered">Register</i></a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
</body>
</html>
