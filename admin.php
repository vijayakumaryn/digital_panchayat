<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.html");
    exit();
}

require('conn.php');

// Update complaint status
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $complaintId = $_POST['complaint_id'];
    $newStatus = $_POST['new_status'];
    $updateQuery = "UPDATE complaints SET admin_status = '$newStatus' WHERE id = $complaintId";
    $msg = "";
    if ($con->query($updateQuery) === TRUE) {
        $msg = "<p class='success-message'>Complaint status updated successfully.</p>";
    } else {
        $msg = "<p class='error-message'>Failed to update complaint status.</p>";
    }
}

// Fetch all complaints
$complaintQuery = "SELECT id, username, complaint, admin_status FROM complaints ORDER BY id DESC";
$result = $con->query($complaintQuery);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Complaints</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Pacifico&display=swap" rel="stylesheet">
    <style>
        /* Animated gradient background */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background: linear-gradient(-45deg, #ff416c, #ff4b2b, #1fa2ff, #12d8fa);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            color: #fff;
        }

        @keyframes gradientBG {
            0% {background-position: 0% 50%;}
            50% {background-position: 100% 50%;}
            100% {background-position: 0% 50%;}
        }

        h1 {
            text-align: center;
            font-family: 'Pacifico', cursive;
            font-size: 48px;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.7);
            margin: 20px 0;
        }

        h2 {
            text-align: center;
            font-size: 28px;
            color: #fff;
            margin-bottom: 30px;
            text-shadow: 1px 1px 6px rgba(0,0,0,0.6);
        }

        .message {
            text-align: center;
            margin-bottom: 20px;
            font-size: 18px;
            font-weight: bold;
        }

        .success-message { color: #00ff00; animation: fadeIn 1s; }
        .error-message { color: #ff4b4b; animation: fadeIn 1s; }

        @keyframes fadeIn { from {opacity:0;} to {opacity:1;} }

        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 8px 25px rgba(0,0,0,0.6);
            border-radius: 12px;
            overflow: hidden;
            background-color: rgba(0,0,0,0.3);
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            transition: 0.3s;
        }

        th {
            background: linear-gradient(90deg, #ffb347, #ffcc33);
            color: #000;
            font-size: 18px;
            text-transform: uppercase;
        }

        tr {
            background: rgba(255, 255, 255, 0.1);
        }

        tr:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.02);
        }

        td select {
            padding: 5px 10px;
            border-radius: 8px;
            border: none;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        /* Different colors for dropdown options using inline styles */
        option[value="Pending"] { color: orange; font-weight: bold; }
        option[value="In Progress"] { color: deepskyblue; font-weight: bold; }
        option[value="Resolved"] { color: limegreen; font-weight: bold; }

        td button {
            padding: 6px 12px;
            border-radius: 12px;
            border: none;
            background: linear-gradient(135deg, #ff416c, #ff4b2b);
            color: #fff;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        td button:hover {
            background: linear-gradient(135deg, #ff4b2b, #ff416c);
            transform: scale(1.1);
            box-shadow: 0 6px 15px rgba(255,65,108,0.7);
        }

        .back-link {
            display: block;
            width: 200px;
            margin: 30px auto 50px auto;
            padding: 12px;
            text-align: center;
            background: linear-gradient(90deg, #ffb347, #ffcc33);
            color: #000;
            text-decoration: none;
            border-radius: 15px;
            font-weight: bold;
            box-shadow: 0 4px 15px rgba(0,0,0,0.5);
            transition: 0.3s;
        }

        .back-link:hover {
            background: linear-gradient(90deg, #ffcc33, #ffb347);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.6);
        }
    </style>
</head>
<body>
    <h1>Admin Dashboard</h1>
    <h2>Manage Complaints</h2>

    <div class="message">
        <?php if(isset($msg)) echo $msg; ?>
    </div>

    <?php if($result->num_rows > 0): ?>
    <table>
        <tr>
            <th>Complaint ID</th>
            <th>Username</th>
            <th>Complaint</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['username'] ?></td>
            <td><?= $row['complaint'] ?></td>
            <td>
                <form method="POST" action="">
                    <input type="hidden" name="complaint_id" value="<?= $row['id'] ?>">
                    <select name="new_status">
                        <option value="Pending" <?= $row['admin_status']=='Pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="In Progress" <?= $row['admin_status']=='In Progress' ? 'selected' : '' ?>>In Progress</option>
                        <option value="Resolved" <?= $row['admin_status']=='Resolved' ? 'selected' : '' ?>>Resolved</option>
                    </select>
            </td>
            <td><button type="submit" name="update">Update</button></td>
            </form>
        </tr>
        <?php endwhile; ?>
    </table>
    <?php else: ?>
        <p style="text-align:center; font-size:20px; color:#ff4b4b;">No complaints found.</p>
    <?php endif; ?>

    <a class="back-link" href="adminhome.php">Back to Admin Home</a>
</body>
</html>
