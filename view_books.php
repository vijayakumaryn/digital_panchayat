<?php
session_start();

// Restrict access: only logged-in users can see books
if (!isset($_SESSION['username'])) {
    header("Location: login.html"); // Redirect if not logged in
    exit();
}

require_once 'conn.php';
$result = $con->query("SELECT * FROM books ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Grampanchayat Granthalaya</title>
  <style>
    body { 
      margin: 0; 
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #f9f9f9, #e3f2fd, #fce4ec);
      background-attachment: fixed;
    }

    /* Back button */
    .back-btn {
      position: absolute;
      top: 20px;
      left: 20px;
      text-decoration: none;
      background: #1976d2;
      color: white;
      padding: 10px 18px;
      border-radius: 25px;
      font-size: 14px;
      font-weight: bold;
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
      transition: background 0.3s, transform 0.2s;
    }
    .back-btn:hover {
      background: #0d47a1;
      transform: scale(1.05);
    }

    /* Logout button */
    .logout-btn {
      position: absolute;
      top: 20px;
      right: 20px;
      text-decoration: none;
      background: #e53935;
      color: white;
      padding: 10px 18px;
      border-radius: 25px;
      font-size: 14px;
      font-weight: bold;
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
      transition: background 0.3s, transform 0.2s;
    }
    .logout-btn:hover {
      background: #b71c1c;
      transform: scale(1.05);
    }

    h1 {
      text-align: center;
      margin: 60px 20px 20px 20px;
      color: #333;
      font-size: 36px;
    }

    .grid {
      background-image: url('images/im10.jpg');
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 25px;
      padding: 30px;
    }

    .book-card {
      background-image: url('images/im8.jpg');
      border-radius: 15px;
      padding: 20px;
      text-align: center;
      box-shadow: 0 6px 15px rgba(0,0,0,0.15);
      transition: transform 0.3s, box-shadow 0.3s;
    }
    .book-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.25);
    }

    .book-card img {
      width: 130px;
      height: 180px;
      object-fit: cover;
      border-radius: 8px;
      margin-bottom: 12px;
      border: 2px solid #ddd;
    }

    .book-card h3 {
      margin: 10px 0;
      font-size: 18px;
      color: #444;
    }

    .available {
      color: #2e7d32;
      font-weight: bold;
      background: #c8e6c9;
      padding: 5px 12px;
      border-radius: 20px;
      display: inline-block;
    }

    .not-available {
      color: #c62828;
      font-weight: bold;
      background: #ffcdd2;
      padding: 5px 12px;
      border-radius: 20px;
      display: inline-block;
    }
  </style>
</head>
<body>
  <!-- Back button -->
  <a href="index.php" class="back-btn">⬅ Back</a>

  <!-- Logout button -->
  <a href="logout.php" class="logout-btn">Logout</a>

  <h1>📖 Grampanchayat Granthalaya</h1>
  <div class="grid">
    <?php while ($book = $result->fetch_assoc()) { ?>
      <div class="book-card">
        <img src="<?php echo $book['photo']; ?>" alt="Book">
        <h3><?php echo $book['name']; ?></h3>
        <p class="<?php echo strtolower(str_replace(' ', '-', $book['status'])); ?>">
          <?php echo $book['status']; ?>
        </p>
      </div>
    <?php } ?>
  </div>
</body>
</html>
