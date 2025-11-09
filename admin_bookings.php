<?php
session_start();
require('conn.php');

if(!isset($_SESSION['admin'])) {
    header("Location: login.html");
    exit();
}

// Handle status/comment update
if(isset($_POST['update'])) {
    $booking_id = $_POST['booking_id'];
    $status = $_POST['admin_status'];
    $comment = $_POST['admin_comment'];

    $sql = "UPDATE bookings 
            SET admin_status='$status', admin_comment='$comment' 
            WHERE booking_id=$booking_id AND status <> 'cancelled'";
    $con->query($sql);
    header("Location: admin_bookings.php?msg=Updated");
    exit();
}

// Fetch active bookings
$sql = "SELECT b.*, u.uname, i.item_name 
        FROM bookings b 
        JOIN user_table u ON b.user_id=u.id 
        JOIN items i ON b.item_id=i.item_id 
        WHERE b.status <> 'cancelled' 
          AND b.admin_status <> 'Approved'
        ORDER BY b.created_at DESC";
$result = $con->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Bookings</title>
<style>
    body {
        font-family: "Segoe UI", Tahoma, sans-serif;
        background: linear-gradient(135deg, #f8f9fa, #e3f2fd);
        padding: 20px;
    }
    h2 {
        text-align: center;
        color: #2c3e50;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 25px;
    }
    .nav-links {
        text-align: center;
        margin-bottom: 20px;
    }
    .nav-links a {
        text-decoration: none;
        padding: 10px 20px;
        margin: 0 10px;
        border-radius: 6px;
        font-weight: bold;
        background: #007bff;
        color: #fff;
        transition: 0.3s;
    }
    .nav-links a:hover {
        background: #0056b3;
        transform: scale(1.05);
    }
    table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        border-radius: 12px;
        overflow: hidden;
    }
    th {
        background: linear-gradient(135deg, #2196f3, #21cbf3);
        color: white;
        padding: 12px;
        text-align: center;
        font-size: 15px;
    }
    td {
        padding: 12px;
        text-align: center;
        border-bottom: 1px solid #ddd;
    }
    tr:hover {
        background: #f1faff;
        transition: 0.3s;
    }
    select, textarea, button {
        padding: 6px;
        border-radius: 5px;
        border: 1px solid #ccc;
        outline: none;
        font-size: 14px;
    }
    select:focus, textarea:focus {
        border-color: #2196f3;
        box-shadow: 0 0 5px rgba(33, 150, 243, 0.5);
    }
    button {
        background: #28a745;
        color: white;
        cursor: pointer;
        border: none;
        font-weight: bold;
        padding: 8px 14px;
        transition: 0.3s;
    }
    button:hover {
        background: #218838;
        transform: scale(1.05);
    }
    textarea {
        resize: none;
    }
</style>
</head>
<body>

<h2>All Active Bookings</h2>

<div class="nav-links">
    <a href="admin_cancelled_bookings.php">View Cancelled Bookings</a>
    <a href="admin_approved_bookings.php">View Approved Bookings</a>
</div>

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
  <th>Action</th>
</tr>
<?php while($row = $result->fetch_assoc()) { ?>
<tr>
  <td><?= htmlspecialchars($row['uname']) ?></td>
  <td><?= htmlspecialchars($row['item_name']) ?></td>
  <td><?= $row['from_date'] ?></td>
  <td><?= $row['to_date'] ?></td>
  <td><?= ucfirst($row['status']) ?></td>
  <td><?= $row['created_at'] ?></td>
  <td>
    <form method="POST" style="display:inline;">
      <input type="hidden" name="booking_id" value="<?= $row['booking_id'] ?>">
      <select name="admin_status" required>
        <option value="Pending" <?= ($row['admin_status']=='Pending')?'selected':'' ?>>Pending</option>
        <option value="Approved" <?= ($row['admin_status']=='Approved')?'selected':'' ?>>Approved</option>
        <option value="Not Approved" <?= ($row['admin_status']=='Not Approved')?'selected':'' ?>>Not Approved</option>
      </select>
  </td>
  <td>
      <textarea name="admin_comment" placeholder="Reason..." rows="2" cols="20"><?= htmlspecialchars($row['admin_comment']) ?></textarea>
  </td>
  <td>
      <button type="submit" name="update">Save</button>
    </form>
  </td>
</tr>
<?php } ?>
</table>

</body>
</html>
