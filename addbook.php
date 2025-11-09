<?php
require_once 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $status = $_POST['status'];

    // Upload photo
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    $fileName = basename($_FILES["photo"]["name"]);
    $targetFilePath = $targetDir . $fileName;

    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFilePath)) {
        $stmt = $con->prepare("INSERT INTO books (name, photo, status) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $targetFilePath, $status);
        if ($stmt->execute()) {
            echo "✅ Book added successfully!";
        } else {
            echo "❌ Error adding book.";
        }
        $stmt->close();
    } else {
        echo "❌ Failed to upload photo.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Book - Granthalaya</title>
  <style>
    body { font-family: Arial; background:#f4f4f9; }
    .container { width:400px; margin:50px auto; padding:20px; background:#fff; border-radius:8px; box-shadow:0 0 10px #aaa; }
    h2 { text-align:center; }
    input, select { width:100%; padding:10px; margin:10px 0; }
    button { width:100%; padding:10px; background:#28a745; color:white; border:none; border-radius:5px; cursor:pointer; }
    button:hover { background:#218838; }
  </style>
</head>
<body>
  <div class="container">
    <h2>📚 Add New Book</h2>
    <form method="post" enctype="multipart/form-data">
      <input type="text" name="name" placeholder="Book Name" required>
      <input type="file" name="photo" required>
      <select name="status">
        <option value="Available">Available</option>
        <option value="Not Available">Not Available</option>
      </select>
      <button type="submit">Add Book</button>
    </form>
  </div>
</body>
</html>
