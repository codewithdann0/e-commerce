<?php
require 'db.php';
session_start(); // Start the session

$field_errors = ['username' => '', 'email' => '', 'password' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    if (empty($username)) {
        $field_errors['username'] = "Username is required.";
    } elseif (!preg_match('/^[a-zA-Z]+$/', $username)) {
        $field_errors['username'] = "Username should only contain alphabetic characters.";
    }

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

    // Check for duplicate username
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $count = $stmt->fetchColumn();
    if ($count > 0) {
        $field_errors['username'] = 'Username already exists';
    }

    // Check for duplicate email
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $count = $stmt->fetchColumn();
    if ($count > 0) {
        $field_errors['email'] = 'Email already exists';
    }

    if (empty($field_errors['username']) && empty($field_errors['email']) && empty($field_errors['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
        $stmt->execute([$username, $email, $password]);
        
        // Set a session variable to store the success message
        $_SESSION['registration_success'] = true;
        
        header('Location: login.php');
        exit; // Ensure script execution stops here to prevent further output
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="./css/register.css">
    <style>
        .error-border {
            border: 1px solid red;
        }
    </style>
</head>
<body>
    <div class="container-box">
        <h2>Register</h2>
        
        <!-- Display registration success message if set -->
        <?php if(isset($_SESSION['registration_success']) && $_SESSION['registration_success']): ?>
            <p style="color: green;">User registered successfully! You can now log in.</p>
            <?php unset($_SESSION['registration_success']); ?> <!-- Unset the session variable -->
        <?php endif; ?>
        
        <form method="POST" onsubmit="return validateForm()">
            <div>
                <label for="username">Name:</label>
                <input type="text" name="username" id="username" class="<?php echo !empty($field_errors['username']) ? 'error-border' : ''; ?>">
                <div id="username-error" class="error-message"><?php echo $field_errors['username']; ?></div>
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" class="<?php echo !empty($field_errors['email']) ? 'error-border' : ''; ?>">
                <div id="email-error" class="error-message"><?php echo $field_errors['email']; ?></div>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" class="<?php echo !empty($field_errors['password']) ? 'error-border' : ''; ?>">
                <div id="password-error" class="error-message"><?php echo $field_errors['password']; ?></div>
            </div>
            <button type="submit">Register</button>
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
