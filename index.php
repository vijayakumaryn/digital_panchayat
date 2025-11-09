<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>e-Gram Panchayat Dashboard</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Segoe UI", Arial, sans-serif;
}

body {
  background-image: url('images/im10.jpg');
  background-size: cover;
  background-position: center;
  background-attachment: fixed;
  min-height: 100vh;
  color: #fff;
  display: flex;
  flex-direction: column;
}

/* Gradient animated header */
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
  border-bottom: 5px solid #fff;
  text-align: center;
  box-shadow: 0 4px 12px rgba(0,0,0,0.3);
}

header h1 {
  font-size: 38px;
  font-style: italic;
  color: #fff;
  text-shadow: 2px 2px 10px rgba(0,0,0,0.7);
}

/* Navigation menu */
nav {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  margin-top: 15px;
}

nav .menu ul {
  display: flex;
  list-style: none;
  gap: 15px;
  flex-wrap: wrap;
  justify-content: center;
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
  position: relative;
  overflow: hidden;
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

main h6 p {
  font-size: 18px;
  color: #000;
  font-weight: bold;
  background: rgba(255,255,255,0.7);
  display: inline-block;
  padding: 10px 20px;
  border-radius: 10px;
  margin-bottom: 20px;
}

marquee {
  margin: 20px 0;
  font-size: 22px;
  font-weight: bold;
}

/* Cards */
@keyframes float {
  0%, 100% { transform: translateY(0);}
  50% { transform: translateY(-10px);}
}

.cards-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 25px;
  margin-top: 30px;
}

.card {
  background: linear-gradient(135deg, #ff9966, #ff5e62);
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
  animation: float 3s ease-in-out infinite;
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

footer {
  background: rgba(0,0,0,0.7);
  text-align: center;
  padding: 15px;
  color: #fff;
  border-top: 4px solid #ffcc00;
  box-shadow: 0 -4px 12px rgba(0,0,0,0.3);
}

@media(max-width:600px){
  header h1 {
    font-size: 28px;
  }
  main h6 p {
    font-size: 16px;
  }
}
</style>
</head>
<body>

<header>
  <h1>Welcome to E-Gram Panchayat</h1>
  <nav>
    <div class="menu">
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="history.php">History</a></li>
        <li><a href="services.php">Services</a></li>
        <li><a href="view_books.php">Grantalaya</a></li>
        <li><a href="items.php">Book Items</a></li>
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
  <section>
    <h6>
      <p>Welcome to the online platform for our Gram Panchayat. Access various services and information conveniently.</p>
    </h6>

    <marquee direction="left" scrollamount="10">
      <p style="color: blue;">Stay updated with the latest announcements and developments in our village.</p>
    </marquee>
  </section>

  <div class="cards-container">
    <div class="card">
      <i class="fas fa-tint"></i>
      <h3><a href="https://swachhamevajayate.org/" target="_blank">Water & Sanitation Dept</a></h3>
    </div>
    <div class="card">
      <i class="fas fa-hand-holding-usd"></i>
      <h3><a href="schemes.html">Government Schemes</a></h3>
    </div>
    <div class="card">
      <i class="fas fa-road"></i>
      <h3><a href="https://rdpr.karnataka.gov.in/info-2/Rural+Connectivity/Rural+Development/kn" target="_blank">Rural Development</a></h3>
    </div>
    <div class="card">
      <i class="fas fa-broom"></i>
      <h3><a href="https://rdpr.karnataka.gov.in/info-2/Swachh+Bharat+Mission+(Rural)/kn" target="_blank">Swachh Bharat Mission</a></h3>
    </div>
    <div class="card">
      <i class="fas fa-info-circle"></i>
      <h3><a href="https://rdpr.karnataka.gov.in/info-1/About+Us/kn" target="_blank">About Us</a></h3>
    </div>
  </div>
</main>

<footer>
  <p>&copy; 2025 e-Gram Panchayat. All rights reserved.</p>
</footer>

</body>
</html>
