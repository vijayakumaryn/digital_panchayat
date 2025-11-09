<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: login.html");
    exit();
} 
?>
<!DOCTYPE html>
<html>
<head>
  <title>Gram Panchayat Admin Home</title>
  <!-- Font Awesome CDN for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      margin: 0;
      padding: 0;
      background-image: url('images/im8.jpg');
      background-repeat: no-repeat;
      background-size: cover;
      background-position: center;
      color: #333;
    }

    /* Pulsating heading */
    h1 {
      color: #FFD700;
      font-style: italic;
      text-align: center;
      padding: 30px 0;
      font-size: 40px;
      text-shadow: 2px 2px 6px rgba(0,0,0,0.7);
      
    }

    @keyframes pulseHeading {
      0% { transform: scale(1); text-shadow: 2px 2px 6px rgba(0,0,0,0.7);}
      50% { transform: scale(1.05); text-shadow: 4px 4px 12px rgba(255,215,0,0.9);}
      100% { transform: scale(1); text-shadow: 2px 2px 6px rgba(0,0,0,0.7);}
    }

    /* Menu Buttons */
    .menu {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 20px;
      margin-bottom: 40px;
    }

    .menu a {
      color: #fff;
      text-decoration: none;
      padding: 12px 22px;
      border-radius: 12px;
      font-weight: bold;
      font-size: 16px;
      position: relative;
      overflow: hidden;
      display: flex;
      align-items: center;
      gap: 8px;
      background: linear-gradient(45deg, #FF6A00, #EE0979, #8E2DE2, #4A00E0);
      background-size: 300% 300%;
      animation: gradientAnimate 6s ease infinite, pulseButton 3s infinite;
      box-shadow: 0 4px 15px rgba(0,0,0,0.3);
      border: 2px solid transparent;
      transition: all 0.3s ease;
    }

    .menu a i {
      font-size: 18px;
      transition: transform 0.3s ease;
    }

    .menu a:hover {
      animation: none;
      background: linear-gradient(45deg, #00FFFF, #00F, #0FF, #4A00E0);
      transform: translateY(-5px) scale(1.05);
      box-shadow: 0 0 25px #fff, 0 0 30px #EE0979, 0 0 35px #FF6A00;
      border-color: #fff;
    }

    .menu a:hover i {
      transform: scale(1.3) rotate(15deg);
    }

    @keyframes gradientAnimate {
      0%{background-position:0% 50%;}
      50%{background-position:100% 50%;}
      100%{background-position:0% 50%;}
    }

    @keyframes pulseButton {
      0% { transform: scale(1);}
      50% { transform: scale(1.05);}
      100% { transform: scale(1);}
    }

    /* Content Box */
    .content {
      position: relative;
      margin: 0 auto 50px auto;
      padding: 35px 45px;
      background: rgba(255, 255, 255, 0.85);
      border-radius: 20px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.3);
      max-width: 950px;
      color: #333;
      overflow: hidden;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .content::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      background: linear-gradient(270deg, #ff6a00, #ee0979, #8e2de2, #4a00e0);
      background-size: 800% 800%;
      opacity: 0.15;
      border-radius: 20px;
      z-index: 0;
      animation: gradientShift 20s ease infinite;
    }

    @keyframes gradientShift {
      0% {background-position: 0% 50%;}
      50% {background-position: 100% 50%;}
      100% {background-position: 0% 50%;}
    }

    .content:hover {
      transform: scale(1.02);
      box-shadow: 0 0 35px rgba(255,106,0,0.7), 0 0 45px rgba(238,9,121,0.7);
    }

    .content h2 {
      position: relative;
      text-align: center;
      color: #4B0082;
      font-size: 34px;
      margin-bottom: 20px;
      text-shadow: 1px 1px 5px rgba(0,0,0,0.3);
      z-index: 1;
     
    }

    .content p,
    .content ul li {
      position: relative;
      z-index: 1;
      font-size: 18px;
      line-height: 1.6;
    }

    .content ul {
      list-style-type: square;
      padding-left: 20px;
    }

    /* Responsive */
    @media(max-width: 768px){
      .menu {
        flex-direction: column;
        align-items: center;
      }
      .menu a {
        width: 80%;
        justify-content: center;
      }
    }
  </style>
</head>
<body>
  <h1>Gram Panchayat Admin Home</h1>
  <div class="menu">
    <a href="usersinfo.php"><i class="fas fa-users"></i>Registered Users</a>
    <a href="admin.php"><i class="fas fa-clipboard-list"></i>Complaints Check</a>
    <a href="uploaddocs.php"><i class="fas fa-upload"></i>Upload Docs</a>
    <a href="add_book.php"><i class="fas fa-upload"></i>Grantalaya BOOKS</a>
    <a href="admin_upload_contacts.php"><i class="fas fa-address-book"></i>Contacts Upload</a>
    <li><a href="admin_items.php">Manage Items</a></li>
    <a href="admin_payments.php"><i class="fas fa-money-bill-wave"></i>Payment Status</a>
    <a href="admin_logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
  </div>
  <div class="content">
    <h2>Welcome, Admin!</h2>
    <p>On this admin home page, you can access various features and manage the Gram Panchayat effectively.</p>
    <p>Please use the navigation menu above to navigate to different sections:</p>
    <ul>
      <li><strong>Registered Users:</strong> Manage the members of the Gram Panchayat, including adding new members and updating their information.</li>
      <li><strong>Complaints:</strong> Track and update the progress of various complaints submitted by users.</li>
      <li><strong>Upload Docs:</strong> Upload important documents for users to download.</li>
      <li><strong>Budget:</strong> Monitor and manage the budget allocated for different initiatives and projects.</li>
      <li><strong>Reports:</strong> Generate reports and access important data related to the Gram Panchayat's operations.</li>
    </ul>
  </div>
</body>
</html>
