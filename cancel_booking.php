<?php
session_start();
require('conn.php');

if(!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

$booking_id = $_GET['id'];
$sql = "UPDATE bookings SET status='cancelled' WHERE booking_id='$booking_id'";
$con->query($sql);

header("Location: my_bookings.php?msg=Booking Cancelled");
?>
