<?php
session_start();
require('conn.php');

// Check admin
if(!isset($_SESSION['admin'])){
    header("Location: login.html");
    exit();
}

// Add Item
if(isset($_POST['add'])){
    $name = $_POST['item_name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];
    $from = $_POST['available_from'];
    $to = $_POST['available_to'];

    $today = date('Y-m-d');

    // Validate dates
    if($from < $today || $to < $today){
        echo "<script>alert('⚠ Dates cannot be in the past');</script>";
    } else if($from > $to){
        echo "<script>alert('⚠ Available To date cannot be before Available From date');</script>";
    } else {
        $sql = "INSERT INTO items (item_name, description, price, available_from, available_to) 
                VALUES ('$name','$desc','$price','$from','$to')";
        $con->query($sql);
        header("Location: admin_items.php?msg=Item added");
        exit();
    }
}

// Delete Item (and related bookings)
if(isset($_GET['delete'])){
    $id = $_GET['delete'];

    // Delete related bookings first
    $con->query("DELETE FROM bookings WHERE item_id = $id");

    // Delete item
    $con->query("DELETE FROM items WHERE item_id = $id");

    header("Location: admin_items.php?msg=Item deleted");
    exit();
}

$result = $con->query("SELECT * FROM items");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin - Manage Items</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 30px;
    background: linear-gradient(135deg, #f6d365, #fda085);
    color: #333;
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
    animation: fadeInDown 1s ease;
}
form {
    background: #fff;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.25);
    margin-bottom: 30px;
    animation: fadeIn 1.2s ease;
}
form input, form button {
    padding: 12px;
    margin: 10px;
    border-radius: 10px;
    border: 1px solid #ccc;
    font-size: 16px;
    outline: none;
    transition: 0.3s;
}
form input:focus {
    border-color: #ff512f;
    box-shadow: 0 0 8px rgba(255,81,47,0.6);
}
form button {
    background: #ff512f;
    border: none;
    color: #fff;
    font-weight: bold;
    cursor: pointer;
}
form button:hover {
    background: #dd2476;
    transform: scale(1.05);
}
.view-btn {
    display: inline-block;
    padding: 12px 18px;
    margin-top: 20px;
    background: #1e3c72;
    color: #fff;
    text-decoration: none;
    border-radius: 8px;
    font-weight: bold;
    transition: 0.3s;
}
.view-btn:hover {
    background: #2a5298;
    transform: scale(1.05);
}
table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 8px 20px rgba(0,0,0,0.25);
    animation: fadeIn 1.4s ease;
}
th {
    background: #ff512f;
    color: #fff;
    padding: 16px;
    text-transform: uppercase;
    letter-spacing: 1px;
}
td {
    text-align: center;
    padding: 14px;
    border-bottom: 1px solid #eee;
}
tr:nth-child(even) {
    background: #fdf2f2;
}
tr:hover {
    background: #ffe6e6;
    transition: background 0.3s ease;
}
a.delete-btn {
    padding: 8px 14px;
    background: #ff3b3b;
    color: #fff;
    border-radius: 8px;
    text-decoration: none;
    transition: 0.3s;
    font-weight: bold;
}
a.delete-btn:hover {
    background: #c70000;
    transform: scale(1.1);
}

/* Animations */
@keyframes fadeIn { from {opacity:0; transform:translateY(20px);} to {opacity:1; transform:translateY(0);} }
@keyframes fadeInDown { from {opacity:0; transform:translateY(-20px);} to {opacity:1; transform:translateY(0);} }
</style>
<script>
function confirmDelete(itemId){
    return confirm('⚠ Are you sure you want to delete this item? This will also remove all related bookings.');
}

// Make "Available To" date dynamically update based on "Available From"
function updateToDateMin(){
    const fromDate = document.querySelector('input[name="available_from"]');
    const toDate = document.querySelector('input[name="available_to"]');
    fromDate.addEventListener('change', function(){
        toDate.min = this.value;
        if(toDate.value < this.value){
            toDate.value = this.value;
        }
    });
}
window.onload = updateToDateMin;
</script>
</head>
<body>

<center><h2>🛠 Manage Items</h2></center>

<!-- Add Item Form -->
<form method="POST">
    <input type="text" name="item_name" placeholder="Item Name" required>
    <input type="text" name="description" placeholder="Description">
    <input type="number" step="0.01" name="price" placeholder="Price" required>

    <!-- Restrict dates to today or future -->
    <input type="date" name="available_from" required min="<?= date('Y-m-d') ?>">
    <input type="date" name="available_to" required min="<?= date('Y-m-d') ?>">

    <button type="submit" name="add">➕ Add Item</button>
</form>

<!-- View Bookings Button -->
<p>
    <a href="admin_bookings.php" class="view-btn">📑 View All Bookings</a>
</p>

<h3 style="margin-top:20px;">📋 Item List</h3>
<table>
<tr>
    <th>Name</th>
    <th>Price</th>
    <th>Available From</th>
    <th>Available To</th>
    <th>Status</th>
    <th>Action</th>
</tr>
<?php while($row = $result->fetch_assoc()){ ?>
<tr>
    <td><?= $row['item_name'] ?></td>
    <td>₹<?= $row['price'] ?></td>
    <td><?= $row['available_from'] ?></td>
    <td><?= $row['available_to'] ?></td>
    <td><?= $row['status'] ?></td>
    <td>
        <a href="admin_items.php?delete=<?= $row['item_id'] ?>" class="delete-btn"
           onclick="return confirmDelete(<?= $row['item_id'] ?>)">🗑 Delete</a>
    </td>
</tr>
<?php } ?>
</table>

</body>
</html>
