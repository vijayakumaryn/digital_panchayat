<?php
session_start();
require('conn.php');

if(!isset($_SESSION['admin'])) {
    header("Location: login.html");
    exit();
}

// ✅ Fetch only approved bookings
$sql = "SELECT b.*, u.uname, i.item_name 
        FROM bookings b 
        JOIN user_table u ON b.user_id=u.id 
        JOIN items i ON b.item_id=i.item_id 
        WHERE b.admin_status = 'Approved'
        ORDER BY b.created_at DESC";
$result = $con->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Approved Bookings</title>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, sans-serif;
        background: linear-gradient(135deg, #e0f7fa, #b2ebf2);
        padding: 20px;
    }
    h2 {
        text-align: center;
        color: #00796b;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 20px;
    }
    .back-btn {
        display: inline-block;
        margin-bottom: 20px;
        padding: 10px 15px;
        background: #00796b;
        color: #fff;
        text-decoration: none;
        border-radius: 6px;
        font-weight: bold;
        transition: 0.3s;
    }
    .back-btn:hover {
        background: #004d40;
        transform: scale(1.05);
    }
    table {
        width: 100%;
        border-collapse: collapse;
        background: #ffffff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }
    th {
        background: linear-gradient(135deg, #26a69a, #80cbc4);
        color: white;
        padding: 12px;
        text-align: center;
        font-size: 15px;
    }
    td {
        padding: 12px;
        text-align: center;
        border-bottom: 1px solid #e0f2f1;
        font-size: 14px;
    }
    tr:hover {
        background: #b2dfdb;
        transition: 0.3s;
    }
    td.status {
        font-weight: bold;
        color: #004d40;
    }
</style>
</head>
<body>

<h2>Approved Bookings</h2>
<a href="admin_bookings.php" class="back-btn">Back to Active Bookings</a>

<table>
<tr>
  <th>User</th>
  <th>Item</th>
  <th>From</th>
  <th>To</th>
  <th>User Status</th>
  <th>Booked At</th>
  <th>Admin Decision</th>
  <th>Admin Comment</th>
</tr>
<?php while($row = $result->fetch_assoc()) { ?>
<tr>
  <td><?= htmlspecialchars($row['uname']) ?></td>
  <td><?= htmlspecialchars($row['item_name']) ?></td>
  <td><?= $row['from_date'] ?></td>
  <td><?= $row['to_date'] ?></td>
  <td><?= $row['status'] ?></td>
  <td><?= $row['created_at'] ?></td>
  <td class="status"><?= $row['admin_status'] ?></td>
  <td><?= $row['admin_comment'] ?></td>
</tr>
<?php } ?>
</table>

</body>
</html>
