<?php
session_start();

// Unset admin session variable and destroy the session
unset($_SESSION['admin']);
session_destroy();

// Redirect to the admin login page
header("Location: login.html");
exit();
?>
