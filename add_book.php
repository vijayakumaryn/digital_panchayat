<?php
include("conn.php");

// Add book
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $status = $_POST['status'];

    // Handle image upload
    $img = $_FILES['photo']['name'];
    $tmp = $_FILES['photo']['tmp_name'];
    $folder = "uploads/" . $img;
    move_uploaded_file($tmp, $folder);

    $sql = "INSERT INTO books (name, photo, status) VALUES ('$name', '$folder', '$status')";
    if (mysqli_query($con, $sql)) {
        $msg = "✅ Book added successfully!";
    } else {
        $msg = "❌ Error: " . mysqli_error($con);
    }
}

// Delete book
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM books WHERE id=$id";
    if (mysqli_query($con, $sql)) {
        $msg = "🗑️ Book deleted successfully!";
    } else {
        $msg = "❌ Error: " . mysqli_error($con);
    }
}

// Toggle availability
if (isset($_GET['toggle'])) {
    $id = $_GET['toggle'];
    $sql = "UPDATE books SET status = IF(status='Available','Not Available','Available') WHERE id=$id";
    if (mysqli_query($con, $sql)) {
        $msg = "🔄 Book status updated successfully!";
    } else {
        $msg = "❌ Error: " . mysqli_error($con);
    }
}

// Fetch books
$result = mysqli_query($con, "SELECT * FROM books");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Books</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #74ebd5, #ACB6E5);
            margin: 0;
            padding: 0;
        }
        .container {
            width: 95%;
            margin: 20px auto;
        }
        h1 {
            text-align: center;
            color: #333;
            text-shadow: 1px 1px 2px #fff;
        }
        .message {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
            padding: 10px;
            border-radius: 6px;
            margin: 10px auto;
            width: 60%;
            text-align: center;
            font-weight: bold;
        }
        form {
            background: #ffffffcc;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0px 4px 8px rgba(0,0,0,0.2);
            width: 50%;
            margin-left: auto;
            margin-right: auto;
        }
        form input, form select, form button {
            width: 95%;
            margin: 10px auto;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
        }
        form input, form select {
            background: #f0f0f0;
        }
        form button {
            background: #28a745;
            color: white;
            cursor: pointer;
            font-weight: bold;
        }
        form button:hover {
            background: #218838;
        }
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
        }
        .card {
            background: #ffffffee;
            padding: 15px;
            border-radius: 15px;
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
            text-align: center;
            transition: transform 0.2s;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 12px;
        }
        .card h3 {
            margin: 10px 0;
            color: #333;
        }
        .status {
            font-weight: bold;
            margin: 5px 0;
            color: #007bff;
        }
        .btn {
            display: inline-block;
            margin: 5px;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 13px;
            text-decoration: none;
            font-weight: bold;
        }
        .delete {
            background: #dc3545;
            color: white;
        }
        .delete:hover {
            background: #b02a37;
        }
        .toggle {
            background: #ffc107;
            color: #212529;
        }
        .toggle:hover {
            background: #e0a800;
        }
        .back-btn {
            display: block;
            width: 150px;
            margin: 20px auto;
            padding: 12px;
            background: #007bff;
            color: white;
            text-align: center;
            font-weight: bold;
            border-radius: 8px;
            text-decoration: none;
        }
        .back-btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>📚 Manage Library Books</h1>

    <?php if (isset($msg)) { echo "<div class='message'>$msg</div>"; } ?>

    <!-- Add Book Form -->
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Enter Book Name" required>
        <input type="file" name="photo" required>
        <select name="status">
            <option value="Available">Available</option>
            <option value="Not Available">Not Available</option>
        </select>
        <button type="submit" name="add">➕ Add Book</button>
    </form>

    <!-- Book Display -->
    <div class="cards">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="card">
                <img src="<?php echo $row['photo']; ?>" alt="Book">
                <h3><?php echo $row['name']; ?></h3>
                <p class="status">Status: <?php echo $row['status']; ?></p>
                <a class="btn delete" href="?delete=<?php echo $row['id']; ?>">🗑️ Delete</a>
                <a class="btn toggle" href="?toggle=<?php echo $row['id']; ?>">🔄 Change Status</a>
            </div>
        <?php } ?>
    </div>

    <!-- Back Button -->
    <a class="back-btn" href="adminhome.php">⬅ Back to Admin Home</a>
</div>
</body>
</html>
