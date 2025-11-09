<?php
require('conn.php');
session_start();

// Retrieve contacts from the table
$contactsQuery = "SELECT * FROM contacts";
$contactsResult = mysqli_query($con, $contactsQuery); 
$contacts = [];
while ($row = mysqli_fetch_assoc($contactsResult)) {
    $contacts[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Contacts</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-image: url('images/im15.jpg');
            background-size: cover;
            background-position: center;
            font-family: "Segoe UI", Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #fff;
        }

        header {
            background: linear-gradient(135deg, #ff6600, #ffcc00);
            text-align: center;
            padding: 20px 0;
            box-shadow: 0 4px 8px rgba(0,0,0,0.4);
        }

        header h1 {
            font-size: 36px;
            text-shadow: 2px 2px 8px rgba(0,0,0,0.6);
            margin: 0;
        }

        main {
            padding: 40px 20px;
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
        }

        table {
            width: 90%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.5);
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
        }

        th {
            background: linear-gradient(135deg, #0072ff, #00c6ff);
            color: #fff;
            font-size: 18px;
        }

        tr:nth-child(even) {
            background-color: rgba(255,255,255,0.1);
        }

        tr:nth-child(odd) {
            background-color: rgba(0,0,0,0.2);
        }

        tr:hover {
            background-color: rgba(255,255,255,0.3);
            transform: scale(1.01);
            transition: all 0.3s ease-in-out;
        }

        td {
            font-size: 16px;
        }

        .back-button {
            margin-top: 30px;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 25px;
            background: linear-gradient(135deg, #ffcc00, #ff6600);
            color: black;
            font-weight: bold;
            transition: all 0.3s ease-in-out;
        }

        .back-button:hover {
            background: linear-gradient(135deg, #0072ff, #00c6ff);
            color: white;
            transform: scale(1.05);
        }

        h2 {
            margin-top: 20px;
            font-size: 28px;
            color: #ffcc00;
            text-shadow: 1px 1px 5px rgba(0,0,0,0.7);
        }

        @media(max-width: 768px){
            table {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>User Contacts</h1>
    </header>

    <main>
        <h2>Contact List</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Designation</th>
                <th>Phone Number</th>
                <th>Address</th>
            </tr>
            <?php foreach ($contacts as $contact): ?>
            <tr>
                <td><?php echo htmlspecialchars($contact['id']); ?></td>
                <td><?php echo htmlspecialchars($contact['name']); ?></td>
                <td><?php echo htmlspecialchars($contact['designation']); ?></td>
                <td><?php echo htmlspecialchars($contact['phone_number']); ?></td>
                <td><?php echo htmlspecialchars($contact['address']); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>

        <a href="contact.php" class="back-button"><i class="fas fa-arrow-left"></i> Back</a>
    </main>
</body>
</html>
