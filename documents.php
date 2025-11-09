<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>e-Gram Panchayat - Documents</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Segoe UI", Arial, sans-serif;
}

/* Body background */
body {
  background-image: url('images/bg3.jpg');
  background-size: cover;
  background-position: center;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  color: #fff;
}

/* Animated gradient header */
@keyframes gradientBG {
  0% {background-position: 0% 50%;}
  50% {background-position: 100% 50%;}
  100% {background-position: 0% 50%;}
}

header {
  background: linear-gradient(-45deg, #ff6600, #ffcc00, #00c6ff, #0072ff);
  background-size: 400% 400%;
  animation: gradientBG 15s ease infinite;
  padding: 25px;
  border-bottom: 4px solid #fff;
  text-align: center;
  box-shadow: 0 4px 12px rgba(0,0,0,0.3);
}

header h1 {
  font-size: 36px;
  font-style: italic;
  color: #fff;
  text-shadow: 2px 2px 8px rgba(0,0,0,0.6);
  margin-bottom: 10px;
}

/* Navigation menu */
nav {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
}

nav .menu ul {
  display: flex;
  list-style: none;
  gap: 15px;
  flex-wrap: wrap;
}

nav .menu li {
  list-style: none;
}

nav .menu li a {
  display: inline-block;
  text-decoration: none;
  padding: 10px 18px;
  border-radius: 25px;
  background: linear-gradient(135deg, #ffcc00, #ff6600);
  font-weight: bold;
  color: black;
  transition: all 0.3s ease-in-out;
}

nav .menu li a:hover {
  color: white;
  transform: scale(1.1);
  box-shadow: 0 4px 12px rgba(0,0,0,0.4);
}

/* Login/logout buttons */
.button {
  display: flex;
  gap: 10px;
  align-items: center;
}

.button a {
  text-decoration: none;
  padding: 10px 18px;
  border-radius: 20px;
  background: linear-gradient(135deg, #00c6ff, #0072ff);
  font-weight: bold;
  color: white;
  transition: all 0.3s ease-in-out;
}

.button a:hover {
  background: linear-gradient(135deg, #0072ff, #00c6ff);
  transform: scale(1.05);
}

/* Main content */
main {
  flex: 1;
  padding: 40px 20px;
  text-align: center;
}

main h2 {
  font-size: 32px;
  color: #ffcc00;
  margin-bottom: 25px;
  text-shadow: 1px 1px 5px #000;
}

/* Document cards */
.cards-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 25px;
  margin-top: 30px;
}

.card {
  background: linear-gradient(135deg, #6a11cb, #2575fc);
  padding: 25px;
  border-radius: 15px;
  box-shadow: 0 8px 20px rgba(0,0,0,0.4);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  text-align: center;
  position: relative;
  overflow: hidden;
}

.card:hover {
  transform: translateY(-10px) scale(1.05);
  box-shadow: 0 12px 25px rgba(0,0,0,0.6);
}

.card i {
  font-size: 50px;
  margin-bottom: 15px;
  color: #fff;
  text-shadow: 2px 2px 5px rgba(0,0,0,0.5);
}

.card h3 a {
  color: #fff;
  text-decoration: none;
  font-size: 22px;
  font-weight: bold;
  display: block;
  margin-top: 10px;
}

.card h3 a:hover {
  text-decoration: underline;
}

/* Footer */
footer {
  background: rgba(0,0,0,0.7);
  text-align: center;
  padding: 15px;
  color: #fff;
  border-top: 4px solid #ffcc00;
  box-shadow: 0 -4px 12px rgba(0,0,0,0.3);
}

/* Responsive */
@media(max-width:600px){
  header h1 {
    font-size: 28px;
  }
}
</style>
</head>
<body>

<header>
  <h1>E-Gram Panchayat</h1>
  <h2>Documents</h2>
  <nav>
    <div class="menu">
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="history.php">History</a></li>
        <li><a href="services.php">Services</a></li>
<li><a href="view_books.php">Grantalaya</a></li>
        <li><a href="documents.php">Documents</a></li>
        <li><a href="aboutus.html">About us</a></li>
        <li><a href="complaintform.html">Complaints</a></li>
        <li><a href="contact.php">Contact</a></li>
      </ul>
    </div>
    <div class="button">
      <?php
      if(isset($_SESSION['username'])) {
          echo "<span style='color:white; font-weight:bold;'>Logged in as: " . htmlspecialchars($_SESSION['username']) . "</span>";
          echo '<a href="logout.php">Logout</a>';
      } else {
          echo '<a href="register.html">Sign Up</a>';
          echo '<a href="login.html">Login</a>';
      }
      ?>
    </div>
  </nav>
</header>

<main>
  <h2>Important Documents</h2>

  <div class="cards-container">
    <div class="card">
      <i class="fas fa-file-pdf"></i>
      <h3><a href="downloaddocs.php" target="_blank">Document 1</a></h3>
    </div>

    <div class="card">
      <i class="fas fa-bullhorn"></i>
      <h3><a href="https://igr.karnataka.gov.in/page/Recruitment+Notifications/en" target="_blank">Recruitment Notifications</a></h3>
    </div>

    <div class="card">
      <i class="fas fa-file-contract"></i>
      <h3><a href="https://igr.karnataka.gov.in/page/Tenders/en" target="_blank">Tenders</a></h3>
    </div>
  </div>

</main>

<footer>
  <p>&copy; 2025 e-Gram Panchayat. All rights reserved.</p>
</footer>

</body>
</html>
