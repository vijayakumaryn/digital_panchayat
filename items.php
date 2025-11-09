<?php
session_start();
require('conn.php');

if(!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

$query = "SELECT * FROM items WHERE status='available'";
$result = $con->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Available Items</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #6a11cb, #2575fc);
    margin: 0;
    padding: 30px;
    color: #fff;
}

h2 {
    text-align: center;
    font-size: 36px;
    margin-bottom: 25px;
    color: #fff;
    background: linear-gradient(to right, #ff512f, #dd2476);
    padding: 15px 25px;
    border-radius: 15px;
    display: inline-block;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    animation: fadeInDown 1s ease;
}

.view-btn {
    display: inline-block;
    margin: 20px auto;
    padding: 12px 25px;
    background: #ffb347;
    background: linear-gradient(to right, #ffcc33, #ff7e5f);
    color: #fff;
    font-weight: bold;
    border-radius: 12px;
    text-decoration: none;
    font-size: 16px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    transition: 0.3s ease;
}
.view-btn:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 15px rgba(0,0,0,0.4);
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background: rgba(255,255,255,0.1);
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    animation: fadeIn 1.2s ease;
}

th {
    background: linear-gradient(to right, #ff512f, #dd2476);
    color: #fff;
    padding: 15px;
    font-size: 18px;
    text-transform: uppercase;
    letter-spacing: 1px;
    border-bottom: 3px solid #fff;
}

td {
    padding: 14px;
    text-align: center;
    font-size: 16px;
    border-bottom: 1px solid rgba(255,255,255,0.2);
}

tr:nth-child(even) {
    background: rgba(255,255,255,0.05);
}

tr:hover {
    background: rgba(255,255,255,0.15);
    transform: scale(1.01);
    transition: 0.3s ease;
}

form {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
}

input[type="date"] {
    padding: 8px;
    border-radius: 8px;
    border: 1px solid #fff;
    outline: none;
    font-size: 14px;
    transition: 0.3s ease;
    background: rgba(255,255,255,0.2);
    color: #fff;
}
input[type="date"]:focus {
    border-color: #ff7e5f;
    box-shadow: 0 0 8px #ff7e5f;
}

button {
    padding: 10px 18px;
    border-radius: 10px;
    border: none;
    background: linear-gradient(to right, #11998e, #38ef7d);
    color: #fff;
    font-weight: bold;
    cursor: pointer;
    transition: transform 0.3s, background 0.3s, box-shadow 0.3s;
}
button:hover {
    transform: scale(1.1);
    background: linear-gradient(to right, #38ef7d, #11998e);
    box-shadow: 0 6px 15px rgba(0,0,0,0.4);
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

<h2>✨ Available Items for Booking ✨</h2>

<div style="text-align:center;">
  <a href="my_bookings.php" class="view-btn">📘 View My Bookings</a>
</div>

<table>
<tr>
  <th>Item</th>
  <th>Description</th>
  <th>Price</th>
  <th>From</th>
  <th>To</th>
  <th>Action</th>
</tr>
<?php while($row = $result->fetch_assoc()) { ?>
<tr>
  <td><?= $row['item_name'] ?></td>
  <td><?= $row['description'] ?></td>
  <td>₹<?= $row['price'] ?></td>
  <td><?= $row['available_from'] ?></td>
  <td><?= $row['available_to'] ?></td>
  <td>
    <form method="POST" action="book_item.php">
      <input type="hidden" name="item_id" value="<?= $row['item_id'] ?>">
      <input type="date" name="from_date" required 
             min="<?= $row['available_from'] ?>" 
             max="<?= $row['available_to'] ?>">
      <input type="date" name="to_date" required 
             min="<?= $row['available_from'] ?>" 
             max="<?= $row['available_to'] ?>">
      <button type="submit">Book Now 🚀</button>
    </form>
  </td>
</tr>
<?php } ?>
</table>

</body>
</html>
