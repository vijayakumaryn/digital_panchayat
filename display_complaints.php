<?php
$servername = "localhost";
$username = "root"; // Change this if you have a different username
$password = ""; // Change this if you have set a password for your MySQL server
$dbname = "complaints_db"; // Change this to your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM complaints";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>ID</th><th>Name</th><th>Aadhar Number</th><th>Address</th><th>Contact Number</th><th>Email</th><th>Complaint</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["name"] . "</td>";
        echo "<td>" . $row["adhn"] . "</td>";
        echo "<td>" . $row["addr"] . "</td>";
        echo "<td>" . $row["phno"] . "</td>";
        echo "<td>" . $row["emailid"] . "</td>";
        echo "<td>" . $row["comp"] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No data found.";
}

$conn->close();
?>
