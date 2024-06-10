<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> <!-- Font Awesome CSS -->
   <style>
    /* footer.css */

.footer {
    background-color: #232f3e;
    color: #ffffff;
    padding: 20px 0;
    text-align: center;
    bottom: 0;
    width: 100%;
    font-size: 14px;
}

.footer-content {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.footer-links {
    margin-bottom: 10px;
    
}

.footer-links a {
    color: #ffffff;
    text-decoration: none;
    margin: 0 10px;
    font-size: 40px;
    margin-left:30px ;
}

.footer-links a:hover {
    text-decoration: underline;
}

   </style>
</head>
<body>
    <footer class="footer">
        <div class="footer-content">
            <!-- Add your footer content here -->
            <div class="footer-links">
    <a href="https://www.google.com" target="_blank"><i class="fab fa-google"></i></a>
    <a href="https://www.mastercard.com" target="_blank"><i class="fab fa-cc-mastercard"></i></a>
    <a href="https://www.paypal.com" target="_blank"><i class="fab fa-paypal"></i></a>
    <a href="https://www.apple.com" target="_blank"><i class="fab fa-apple"></i></a>
    <a href="https://www.amazon.com" target="_blank"><i class="fab fa-amazon"></i></a>
    <!-- Add more links/icons as needed -->
</div>

            <p>&copy; <?php echo date("Y"); ?>EthioBuy.com. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
