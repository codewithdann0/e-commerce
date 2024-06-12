
<?php
session_start();
require 'db.php';

$field_errors = ['email' => '', 'password' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email)) {
        $field_errors['email'] = "Email is required.";
    }

    if (empty($password)) {
        $field_errors['password'] = "Password is required.";
    }

    if (empty($field_errors['email']) && empty($field_errors['password'])) {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header('Location: product_list.php');
            exit;
        } else {
            $field_errors['email'] = "Incorrect email or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>   
    <link rel="stylesheet" type="text/css" href="./css/login.css?v=1.0.4">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
     .container-box .iconp{
        position: absolute;
        color:#007bff;
        top: 55.5%;
        right: 61.5%;
        transform: translateY(-50%);
        font-size: 20px;
    }
    .container-box .icone{
       position:absolute;
       color:#007bff;
        top: 42%;
        right: 61%;
        transform: translateY(-50%);
        font-size: 20px;
    } 
  </style>
</head> 
<body>
    <div class="container-box">
        <h2>Login</h2>
        <form method="POST" onsubmit="return validateForm()">
            <div>
                <label for="email">Email:</label>
                <span class="icone"><i class="fas fa-envelope"></i></span>
                <input type="email" name="email" id="email" class="<?php echo !empty($field_errors['email']) ? 'error-border' : ''; ?>"><br>
                <div id="email-error" class="error-message"><?php echo $field_errors['email']; ?></div>
            </div>
            <div>
                <label for="password">Password:</label>
                <span class="iconp"><i class="fas fa-lock"></i></span>
                <input type="password" name="password" id="password" class="<?php echo !empty($field_errors['password']) ? 'error-border' : ''; ?>"><br>
                <div id="password-error" class="error-message"><?php echo $field_errors['password']; ?></div>
            </div>
            <button type="submit">Login</button>
            <a href="register.php">Don't Have An Account?</a>
        </form>
    </div>
    <script>
        function validateForm() {
            let valid = true;
            let fields = ['email', 'password'];

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
