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
    <link rel="stylesheet" href="./css/header.css?v=1.0.10">
    <title>Header</title>
    <style>
       
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <a href="index.php">EthioBuy</a>
            <div class="icon" onclick="toggleMenu()">
                <i class="fas fa-bars"></i>
            </div>
        </div>
        <nav>
            <ul>
                <li><a href="index.php" class="<?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>">Home</a></li>
                <li><a href="product_list.php" class="<?= basename($_SERVER['PHP_SELF']) == 'product_list.php' ? 'active' : '' ?>">Products</a></li>
                <li><a href="cart.php" class="<?= basename($_SERVER['PHP_SELF']) == 'cart.php' ? 'active' : '' ?>">Cart</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="profile.php" class="<?= basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'active' : '' ?>">Profile</a></li>
                    <li><a href="logout.php">Logout</a></li>
                    <?php if (isAdmin($_SESSION['user_id'])): ?>
                        <li><a href="admin.php" class="<?= basename($_SERVER['PHP_SELF']) == 'admin.php' ? 'active' : '' ?>">Admin</a></li>
                    <?php endif; ?>
                <?php else: ?>
                    <li><a href="login.php" class="<?= basename($_SERVER['PHP_SELF']) == 'login.php' ? 'active' : '' ?>">Login</a></li>
                    <li><a href="register.php" class="<?= basename($_SERVER['PHP_SELF']) == 'register.php' ? 'active' : '' ?>">Register</a></li>
                <?php endif; ?>
            </ul>
            <!-- Menu bar icon -->
           
        </nav>
    </header>
    
    <!-- JavaScript for toggling menu -->
    <script>
        function toggleMenu() {
            var nav = document.querySelector('nav ul');
            nav.classList.toggle('show');
        }
    </script>
</body>
</html>
