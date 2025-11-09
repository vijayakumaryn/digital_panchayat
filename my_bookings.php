<?php
session_start();
require('conn.php');

if(!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

$user = $_SESSION['username'];
$userQuery = "SELECT id FROM user_table WHERE uname='$user' OR mobile='$user'";
$userRes = $con->query($userQuery);
$userData = $userRes->fetch_assoc();
$user_id = $userData['id'];

// Only show active bookings (exclude cancelled)
$query = "SELECT b.*, i.item_name, i.price 
          FROM bookings b 
          JOIN items i ON b.item_id=i.item_id 
          WHERE b.user_id='$user_id' 
          AND b.status <> 'cancelled'
          ORDER BY b.created_at DESC";
$result = $con->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Bookings</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
  body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #ff9a9e, #fad0c4);
    margin: 0;
    padding: 20px;
    color: #333;
  }

  h2 {
    text-align: center;
    font-size: 34px;
    margin-bottom: 25px;
    color: #fff;
    background: linear-gradient(to right, #ff512f, #dd2476);
    display: inline-block;
    padding: 10px 20px;
    border-radius: 12px;
    animation: fadeInDown 1s ease;
  }

  table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background: rgba(255, 255, 255, 0.9);
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 6px 15px rgba(0,0,0,0.2);
    animation: fadeIn 1.2s ease;
  }

  th {
    background: #ff512f;
    color: #fff;
    padding: 15px;
    font-size: 16px;
    letter-spacing: 1px;
    text-transform: uppercase;
  }

  td {
    padding: 15px;
    text-align: center;
    font-size: 15px;
    border-bottom: 1px solid #ddd;
  }

  tr:nth-child(even) {
    background: #f9f9f9;
  }

  tr:hover {
    background: #ffe0b2;
    transition: background 0.4s ease;
  }

  a.cancel-btn, a.receipt-btn {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 6px;
    font-weight: bold;
    text-decoration: none;
    font-size: 14px;
    transition: transform 0.3s, background 0.3s;
  }

  a.cancel-btn {
    background: #f44336;
    color: #fff;
  }
  a.cancel-btn:hover {
    background: #d32f2f;
    transform: scale(1.1);
  }

  a.receipt-btn {
    background: #4caf50;
    color: #fff;
    margin-left: 5px;
  }
  a.receipt-btn:hover {
    background: #388e3c;
    transform: scale(1.1);
  }

  /* Animations */
  @keyframes fadeIn {
    from {opacity: 0; transform: translateY(20px);}
    to {opacity: 1; transform: translateY(0);}
  }
  @keyframes fadeInDown {
    from {opacity: 0; transform: translateY(-20px);}
    to {opacity: 1; transform: translateY(0);}
  }
</style>
</head>
<body>

<center><h2>📘 My Bookings</h2></center>

<table>
<tr>
  <th>Item</th>
  <th>From</th>
  <th>To</th>
  <th>User Status</th>
  <th>Admin Decision</th>
  <th>Admin Comment</th>
  <th>Action</th>
</tr>
<?php while($row = $result->fetch_assoc()) { ?>
<tr>
  <td><b><?= $row['item_name'] ?></b><br>₹<?= $row['price'] ?></td>
  <td><?= $row['from_date'] ?></td>
  <td><?= $row['to_date'] ?></td>
  <td><?= ucfirst($row['status']) ?></td>
  <td><?= $row['admin_status'] ?? 'Pending' ?></td>
  <td><?= $row['admin_comment'] ?? '-' ?></td>
  <td>
    <?php if($row['status']=='booked') { ?>
      <a href="cancel_booking.php?id=<?= $row['booking_id'] ?>" class="cancel-btn">❌ Cancel</a>
    <?php } ?>
    <?php if($row['admin_status']=='Approved') { ?>
      <a href="download_book_receipt.php?id=<?= $row['booking_id'] ?>" target="_blank" class="receipt-btn">📄 Receipt</a>
    <?php } ?>
  </td>
</tr>
<?php } ?>
</table>

</body>
</html>
