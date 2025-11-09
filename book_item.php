<?php
session_start();
require('conn.php');

if(!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

$user = $_SESSION['username'];
$item_id = $_POST['item_id'];
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];

// get user_id
$userQuery = "SELECT id FROM user_table WHERE uname='$user' OR mobile='$user'";
$userRes = $con->query($userQuery);
$userData = $userRes->fetch_assoc();
$user_id = $userData['id'];

$sql = "INSERT INTO bookings (user_id, item_id, from_date, to_date) 
        VALUES ('$user_id','$item_id','$from_date','$to_date')";
if($con->query($sql)) {
    header("Location: my_bookings.php?msg=Booking successful");
} else {
    header("Location: items.php?error=Booking failed");
}
?>
