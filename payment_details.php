<!DOCTYPE html>
<html>
<head>
  <title>Payment Details</title>
  <style> 
    body {
      font-family: Arial, sans-serif;
      background-image: url('images/im11.jpg');
      background-size: cover;
      background-position: center;
      color: #333;
    }

    h1 {
      text-align: center;
      color: #fff;
      text-shadow: 2px 2px 5px #000;
    }

    .container {
      max-width: 900px;
      margin: 0 auto;
      padding: 20px;
      background-color: rgba(255, 129, 0, 0.95);
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.4);
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      border-radius: 8px;
      overflow: hidden;
    }

    th, td {
      padding: 12px;
      text-align: center;
      border-bottom: 1px solid #ccc;
    }

    th {
      background-color: #333;
      color: #fff;
    }

    .btn {
      padding: 8px 15px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-weight: bold;
    }

    .btn-download {
      background-color: #28a745;
      color: #fff;
    }

    .btn-download:hover {
      background-color: #218838;
    }

    .btn-pending {
      background-color: #aaa;
      color: #fff;
      cursor: not-allowed;
    }

    /* Back button top-left */
    .btn-back {
      position: absolute;
      top: 20px;
      left: 20px;
      background-color: #007bff;
      color: #fff;
      padding: 8px 15px;
      border-radius: 4px;
      text-decoration: none;
      font-weight: bold;
      box-shadow: 2px 2px 6px rgba(0,0,0,0.3);
    }

    .btn-back:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
  <!-- Back button top-left -->
  <a href="homebill.html" class="btn-back">⬅ Back</a>

  <h1>Payment Details</h1>

  <div class="container">
    <?php
      session_start();
      if (!isset($_SESSION['username'])) {
        echo '<p>Please log in to view payment details.</p>';
        exit();
      }

      $username = $_SESSION['username'];
      require_once 'conn.php';

      $stmt = $con->prepare("SELECT * FROM payments WHERE property_owner = ?");
      $stmt->bind_param('s', $username);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
        echo '<table>';
        echo '<tr>
                <th>Property ID</th>
                <th>Property Owner</th>
                <th>Payment Amount</th>
                <th>Payment Method</th>
                <th>Payment Status</th>
                <th>Payment Date</th>
                <th>Receipt</th>
              </tr>';

        while ($paymentDetails = $result->fetch_assoc()) {
          echo '<tr>';
          echo '<td>' . $paymentDetails['property_id'] . '</td>';
          echo '<td>' . $paymentDetails['property_owner'] . '</td>';
          echo '<td>' . $paymentDetails['payment_amount'] . '</td>';
          echo '<td>' . $paymentDetails['payment_method'] . '</td>';
          echo '<td>' . $paymentDetails['payment_status'] . '</td>';
          echo '<td>' . $paymentDetails['payment_date'] . '</td>';

          if (strtolower($paymentDetails['payment_status']) === 'paid') {
            echo '<td><a href="generate_receipt.php?id=' . $paymentDetails['id'] . '" target="_blank">
                  <button class="btn btn-download">Download</button></a></td>';
          } else {
            echo '<td><button class="btn btn-pending">Pending</button></td>';
          }

          echo '</tr>';
        }
        echo '</table>';
      } else {
        echo '<p>No payment records found.</p>';
      }

      $stmt->close();
      mysqli_close($con);
    ?>
  </div>
</body>
</html>
