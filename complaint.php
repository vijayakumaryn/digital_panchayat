<?php
require('conn.php');
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete'])) {
        $complaintId = $_POST['delete'];

        // Delete the complaint from the database
        $deleteQuery = "DELETE FROM complaints WHERE id = $complaintId";
        if ($con->query($deleteQuery) === TRUE) {
            echo "<p class='msg success'>Complaint deleted successfully.</p>";
        } else {
            echo "<p class='msg error'>Failed to delete the complaint.</p>";
        }
    } else if (isset($_POST['comp'])) {
        $complaint = $_POST["comp"];
        $username = $_SESSION['username'];

        // Store the complaint in the database with admin_status as 'Pending'
        $insertQuery = "INSERT INTO complaints (username, complaint) VALUES ('$username', '$complaint')";
        if ($con->query($insertQuery) === TRUE) {
            echo "<p class='msg success'>Complaint added successfully.</p>";
        } else {
            echo "<p class='msg error'>Failed to store the complaint.</p>";
        }
    }
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Complaints</title>
<style>
    body {
        background-image: url('images/im14.jpg');
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        color: white;
        text-align: center;
    }

    .top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 30px;
        background: rgba(0, 0, 0, 0.6);
    }

    .logout-btn {
        background: linear-gradient(135deg, #ff512f, #dd2476);
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: bold;
        text-decoration: none;
        transition: 0.3s;
    }

    .logout-btn:hover {
        background: linear-gradient(135deg, #dd2476, #ff512f);
        transform: scale(1.1);
    }

    h2 {
        margin: 20px;
        color: #FFD700;
        text-shadow: 2px 2px 5px black;
    }

    table {
        border-collapse: collapse;
        width: 90%;
        margin: 20px auto;
        box-shadow: 0 0 15px rgba(0,0,0,0.5);
        border-radius: 10px;
        overflow: hidden;
    }

    th {
        background: linear-gradient(135deg, #4facfe, #00f2fe);
        color: white;
        padding: 12px;
        font-size: 16px;
    }

    td {
        padding: 12px;
        border: 1px solid #ddd;
        font-size: 15px;
        background: rgba(0,0,0,0.6);
    }

    tr:nth-child(even) td {
        background: rgba(0,0,50,0.6);
    }

    .delete-btn {
        background: linear-gradient(135deg, #ff416c, #ff4b2b);
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
        transition: 0.3s;
    }

    .delete-btn:hover {
        transform: scale(1.1);
        background: linear-gradient(135deg, #ff1e56, #f05053);
    }

    .msg {
        font-size: 18px;
        margin: 15px;
        padding: 10px;
        border-radius: 5px;
        display: inline-block;
    }
    .msg.success { background: rgba(0,255,0,0.2); color: lime; }
    .msg.error { background: rgba(255,0,0,0.2); color: #ff4d4d; }

    .back-btn {
        margin: 20px;
        display: inline-block;
        background: linear-gradient(135deg, #43cea2, #185a9d);
        color: white;
        text-decoration: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: bold;
        transition: 0.3s;
    }

    .back-btn:hover {
        background: linear-gradient(135deg, #185a9d, #43cea2);
        transform: scale(1.1);
    }
</style>
</head>
<body>

<div class="top-bar">
    <h2>Welcome, <?php echo $username; ?>!</h2>
    <a href="?logout=true" class="logout-btn">Logout</a>
</div>

<?php
// Retrieve the registered complaints for the logged-in user
$complaintQuery = "SELECT id, complaint, admin_status FROM complaints WHERE username='$username'";
$result = $con->query($complaintQuery);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr>
            <th>Complaint ID</th>
            <th>Registered Complaint</th>
            <th>Complaint Status</th>
            <th>Action</th>
          </tr>";

    while ($row = $result->fetch_assoc()) {
        $complaintId = $row["id"];
        $registeredComplaint = $row["complaint"];
        $complaintStatus = $row["admin_status"];

        echo "<tr>";
        echo "<td>$complaintId</td>";
        echo "<td>$registeredComplaint</td>";
        echo "<td>$complaintStatus</td>";
        echo "<td>
                <form method='POST' action='' style='margin:0;'>
                    <button type='submit' name='delete' value='$complaintId' class='delete-btn'>Delete</button>
                </form>
              </td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p class='msg error'>No registered complaints found for the user.</p>";
}
?>

<a href="complaintform.html" class="back-btn">⬅ Back to Register Complaint</a>

</body>
</html>
