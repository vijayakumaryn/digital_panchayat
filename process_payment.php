<?php
// Include the database connection file
require_once 'conn.php';

// Start the session and check if the user is logged in
session_start();
if (!isset($_SESSION['username'])) {
  echo '<p>Please log in to process the payment.</p>';
  exit();
}

// Retrieve form data
$propertyId = $_POST['property_id'];
$propertyOwner = $_SESSION['username']; // Associate payment with logged-in user
$paymentAmount = $_POST['payment_amount'];
$paymentMethod = $_POST['payment_method'];

try {
  // Prepare the SQL statement
  $stmt = $con->prepare("INSERT INTO payments (property_id, property_owner, payment_amount, payment_method, payment_status, payment_date) VALUES (?, ?, ?, ?, 'Pending', NOW())");

  // Bind parameters
  $stmt->bind_param('ssds', $propertyId, $propertyOwner, $paymentAmount, $paymentMethod);

  // Execute the statement
  $stmt->execute();

  // Retrieve the inserted payment ID
  $paymentId = $con->insert_id;

  // Close the statement
  $stmt->close();

  // Close the database connection
  mysqli_close($con);

  // Redirect to the payment details page with the payment ID
  header("Location: payment_details.php?payment_id=$paymentId");
  exit();
} catch (Exception $e) {
  die('Database connection failed: ' . $e->getMessage());
}
?>
