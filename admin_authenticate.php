<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Admin authentication logic
    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['admin'] = true; // Set the admin session variable
        header("Location: adminhome.php"); // Redirect to the admin page
        exit();
    } else {
        echo "<p>Invalid username or password.</p>";
    }
}
?>
