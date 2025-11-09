<?php
require('conn.php');
session_start();

// Handle contact upload
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $designation = $_POST["designation"];
    $phone_number = $_POST["phone_number"];
    $address = $_POST["address"];

    $insertQuery = "INSERT INTO contacts (name, designation, phone_number, address)
                    VALUES ('$name', '$designation', '$phone_number', '$address')";
    if (mysqli_query($con, $insertQuery)) {
        $successMessage = "Contact uploaded successfully!";
    } else {
        $errorMessage = "Error: " . mysqli_error($con);
    }
}

// Handle contact deletion
if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];
    $deleteQuery = "DELETE FROM contacts WHERE id = $deleteId";
    if (mysqli_query($con, $deleteQuery)) {
        $successMessage = "Contact deleted successfully!";
    } else {
        $errorMessage = "Error: " . mysqli_error($con);
    }
}

// Retrieve contacts from the table
$contactsQuery = "SELECT * FROM contacts";
$contactsResult = mysqli_query($con, $contactsQuery);
$contacts = [];
while ($row = mysqli_fetch_assoc($contactsResult)) {
    $contacts[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Upload Contacts</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Pacifico&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background: linear-gradient(-45deg, #ff416c, #ff4b2b, #1fa2ff, #12d8fa);
            background-size: 400% 400%;
            animation: gradientBG 20s ease infinite;
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
            font-size: 50px;
            margin: 20px 0;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.7);
        }

        h2 {
            text-align: center;
            font-size: 28px;
            margin: 20px 0;
            text-shadow: 1px 1px 6px rgba(0,0,0,0.6);
        }

        /* Card styling and animation */
        .card {
            background: rgba(0,0,0,0.5);
            margin: 20px auto;
            padding: 25px;
            border-radius: 20px;
            width: 90%;
            max-width: 700px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.6);
            transform: translateY(50px);
            opacity: 0;
            animation: cardFade 1s forwards;
        }

        @keyframes cardFade {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card:hover {
            transform: translateY(-5px);
            background: rgba(0,0,0,0.6);
            transition: all 0.3s ease;
        }

        form label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
            color: #ffd700;
        }

        form input[type="text"],
        form input[type="tel"] {
            width: 100%;
            padding: 10px;
            border-radius: 12px;
            border: none;
            margin-bottom: 15px;
        }

        form input[type="submit"] {
            padding: 12px 25px;
            border: none;
            border-radius: 25px;
            background: linear-gradient(45deg, #12d8fa, #1fa2ff);
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0,0,0,0.4);
            transition: all 0.3s ease;
        }

        form input[type="submit"]:hover {
            background: linear-gradient(45deg, #1fa2ff, #12d8fa);
            transform: translateY(-3px);
        }

        .message {
            text-align: center;
            font-size: 18px;
            margin-top: 10px;
        }
        .success-message { color: #00ff00; }
        .error-message { color: #ff4b4b; }

        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: separate;
            border-spacing: 0 15px;
        }

        th, td {
            padding: 12px 15px;
            text-align: center;
            border-radius: 12px;
        }

        th {
            background: linear-gradient(45deg, #ff416c, #ff4b2b);
            color: #fff;
            font-size: 16px;
        }

        td {
            background: rgba(255,255,255,0.2);
            color: #fff;
            font-weight: bold;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeSlide 0.8s forwards;
        }

        td:nth-child(1) { animation-delay: 0.1s; }
        td:nth-child(2) { animation-delay: 0.2s; }
        td:nth-child(3) { animation-delay: 0.3s; }
        td:nth-child(4) { animation-delay: 0.4s; }
        td:nth-child(5) { animation-delay: 0.5s; }
        td:nth-child(6) { animation-delay: 0.6s; }

        @keyframes fadeSlide {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .delete-btn {
            padding: 6px 12px;
            border-radius: 12px;
            border: none;
            background: linear-gradient(135deg, #ff416c, #ff4b2b);
            color: #fff;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .delete-btn:hover {
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

    <div class="card">
        <h2>Upload New Contact</h2>
        <form action="" method="post">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" pattern="[A-Za-z]+" required>

            <label for="designation">Designation:</label>
            <input type="text" name="designation" id="designation" pattern="[A-Za-z]+" required>

            <label for="phone_number">Phone Number:</label>
            <input type="tel" name="phone_number" id="phone_number" pattern="[0-9]{10}" maxlength="10" required>

            <label for="address">Address:</label>
            <input type="text" name="address" id="address" required>

            <input type="submit" value="Upload Contact">
        </form>

        <div class="message">
            <?php if(isset($successMessage)) echo "<span class='success-message'>$successMessage</span>"; ?>
            <?php if(isset($errorMessage)) echo "<span class='error-message'>$errorMessage</span>"; ?>
        </div>
    </div>

    <h2 style="text-align:center; color:#ffd700;">Contact List</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Designation</th>
            <th>Phone Number</th>
            <th>Address</th>
            <th>Action</th>
        </tr>
        <?php foreach ($contacts as $contact): ?>
            <tr>
                <td><?php echo $contact['id']; ?></td>
                <td><?php echo $contact['name']; ?></td>
                <td><?php echo $contact['designation']; ?></td>
                <td><?php echo $contact['phone_number']; ?></td>
                <td><?php echo $contact['address']; ?></td>
                <td>
                    <form method="get" action="" onsubmit="return confirm('Are you sure you want to delete this contact?');">
                        <input type="hidden" name="delete_id" value="<?php echo $contact['id']; ?>">
                        <button type="submit" class="delete-btn">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <a class="back-link" href="adminhome.php">Back to Admin Home</a>
</body>
</html>
