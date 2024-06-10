<?php
session_start();

// Unset all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect to the login page after logout
header('Location: login.php');
exit;
?>
