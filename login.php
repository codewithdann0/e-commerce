<?php
session_start();
require 'db.php';
$field_errors = ['email' => '', 'password' => ''];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email)) {
        
        $field_errors['email'] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        
        $field_errors['email'] = "Invalid email format.";
    }

    if (empty($password)) {
      
        $field_errors['password'] = "Password is required.";
    } elseif (!preg_match('/^(?=.*[A-Z])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,}$/', $password)) {

        $field_errors['password'] = "Password should contain at least one capital letter and one special character.";
    }


  if(empty($field_errors)){
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header('Location: product_list.php');
        exit;
    } else {
        $error = 'email'; 
    }
    
}}
?>

<<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="./css/login.css">
</head>
<body>
    <div class="container-box">
    <h2>Login</h2>
    <form method="POST">
        <label for="email" >Email:</label>
        <input type="email" name="email" id="email" class="<?php echo !empty($field_errors['email']) ? 'error-border' : ''; ?>"><br>
        <div id="email-error" class="error-message"><?php echo $field_errors['email']; ?></div>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" class="<?php echo !empty($field_errors['password']) ? 'error-border' : ''; ?>"><br>
        <div id="password-error" class="error-message"><?php echo $field_errors['password']; ?></div>
        <button type="submit">Login</button>
    </form>
</div>
<script>
        function validateForm() {
            let valid = true;
            let fields = ['username', 'email', 'password'];

            fields.forEach(field => {
                let input = document.getElementById(field);
                let errorMessage = document.getElementById(field + '-error');
                if (input.value.trim() === '') {
                    input.classList.add('error-border');
                    errorMessage.textContent = field.charAt(0).toUpperCase() + field.slice(1) + " is required.";
                    valid = false;
                } else {
                    input.classList.remove('error-border');
                    errorMessage.textContent = '';
                }
            });
            return valid;
        }
    </script>
</body>
</html>
