<?php
  // Include the database connection file
  require_once 'conn.php';

  // Check if the form is submitted
  if (isset($_POST['update_status'])) {
    $paymentId = $_POST['payment_id'];
    $newStatus = $_POST['status'];

    // Update the payment status in the database
    $stmt = $con->prepare("UPDATE payments SET payment_status = ? WHERE id = ?");
    $stmt->bind_param('si', $newStatus, $paymentId);
    $stmt->execute();

    // Close the statement
    $stmt->close();

    // Close the database connection
    mysqli_close($con);

    // Redirect back to the admin page
    header("Location: admin_payments.php");
    exit();
  }
?>
