<?php
require_once 'conn.php';

// Update payment status if form submitted
if (isset($_POST['update_status'])) {
    $paymentId = $_POST['payment_id'];
    $newStatus = $_POST['status'];
    
    $stmt = $con->prepare("UPDATE payments SET payment_status = ? WHERE id = ?");
    $stmt->bind_param('si', $newStatus, $paymentId);
    $stmt->execute();
    $stmt->close();

    header("Location: admin_payments.php"); // Refresh page
    exit();
}

// Fetch all payments after update
$result = $con->query("SELECT * FROM payments");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Payments</title>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Pacifico&display=swap" rel="stylesheet">
<style>
  /* --- Global --- */
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body {
    font-family: 'Roboto', sans-serif;
    min-height: 100vh;
    background: linear-gradient(-45deg, #ff4b2b, #ff416c, #1fa2ff, #12d8fa);
    background-size: 400% 400%;
    animation: gradientBG 15s ease infinite;
    color: #fff;
  }

  @keyframes gradientBG {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
  }

  h1 {
    text-align: center;
    font-family: 'Pacifico', cursive;
    font-size: 48px;
    color: #FFD700;
    text-shadow: 2px 2px 12px rgba(0,0,0,0.7);
    margin: 20px 0;
  }

  .container {
    max-width: 1200px;
    margin: 20px auto;
    padding: 30px;
    background: rgba(0,0,0,0.6);
    border-radius: 25px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.7);
    backdrop-filter: blur(10px);
  }

  table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 10px;
    margin-top: 20px;
  }

  th, td {
    padding: 12px;
    text-align: center;
    border-radius: 12px;
    transition: all 0.3s ease;
  }

  th {
    background: linear-gradient(45deg, #ff7e5f, #feb47b);
    font-weight: bold;
    font-size: 16px;
  }

  td {
    background: rgba(255,255,255,0.1);
    font-weight: bold;
    color: #fff;
  }

  td:hover {
    background: rgba(255,255,255,0.25);
    transform: scale(1.03);
  }

  select {
    padding: 8px 12px;
    border-radius: 12px;
    border: none;
    font-weight: bold;
    cursor: pointer;
    color: #fff;
    background: linear-gradient(45deg, #1fa2ff, #12d8fa);
    transition: all 0.3s ease;
  }

  select option[value="Pending"] { color: #FFD700; font-weight: bold; }
  select option[value="Paid"] { color: #00ff00; font-weight: bold; }
  select option[value="Cancelled"] { color: #ff4b4b; font-weight: bold; }

  input[type="submit"] {
    padding: 8px 15px;
    border-radius: 12px;
    border: none;
    background: linear-gradient(45deg, #ff416c, #ff4b2b);
    color: #fff;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s ease;
  }

  input[type="submit"]:hover {
    background: linear-gradient(45deg, #ff4b2b, #ff416c);
    transform: translateY(-3px);
    box-shadow: 0 6px 15px rgba(255,65,108,0.7);
  }

  .back-link {
    display: block;
    width: 200px;
    margin: 30px auto;
    padding: 12px;
    text-align: center;
    background: linear-gradient(90deg, #12d8fa, #1fa2ff);
    color: #fff;
    text-decoration: none;
    border-radius: 25px;
    font-weight: bold;
    box-shadow: 0 4px 15px rgba(0,0,0,0.5);
    transition: 0.3s;
  }

  .back-link:hover {
    background: linear-gradient(90deg, #1fa2ff, #12d8fa);
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.6);
  }

  .view-button {
    padding: 6px 12px;
    border-radius: 12px;
    border: none;
    background: linear-gradient(90deg, #ff9a9e, #fad0c4);
    color: #000;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s ease;
  }

  .view-button:hover {
    background: linear-gradient(90deg, #fad0c4, #ff9a9e);
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.4);
  }

</style>
</head>
<body>
<h1>Admin Payments</h1>

<div class="container">
<?php
if ($result->num_rows > 0) {
    echo '<table>';
    echo '<tr><th>Payment ID</th><th>Property ID</th><th>Owner</th><th>Amount</th><th>Method</th><th>Status</th><th>Date</th><th>Action</th></tr>';
    while ($payment = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>'.$payment['id'].'</td>';
        echo '<td>'.$payment['property_id'].'</td>';
        echo '<td>'.$payment['property_owner'].'</td>';
        echo '<td>'.$payment['payment_amount'].'</td>';
        echo '<td>'.$payment['payment_method'].'</td>';
        echo '<td>'.$payment['payment_status'].'</td>';
        echo '<td>'.$payment['payment_date'].'</td>';
        echo '<td>
                <form method="post">
                    <input type="hidden" name="payment_id" value="'.$payment['id'].'">
                    <select name="status" required>
                        <option value="Pending" '.($payment['payment_status']=='Pending'?'selected':'').'>Pending</option>
                        <option value="Paid" '.($payment['payment_status']=='Paid'?'selected':'').'>Paid</option>
                        <option value="Cancelled" '.($payment['payment_status']=='Cancelled'?'selected':'').'>Cancelled</option>
                    </select>
                    <input type="submit" name="update_status" value="Update">
                </form>
              </td>';
        echo '<td>
                <form action="payment_details.php" method="get">
                    <input type="hidden" name="payment_id" value="'.$payment['id'].'">
                    
                </form>
              </td>';
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo '<p style="text-align:center; font-size:18px; margin-top:20px;">No payment records found.</p>';
}

mysqli_close($con);
?>
<a class="back-link" href="adminhome.php">Back to Home</a>
</div>
</body>
</html>
