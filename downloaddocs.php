<?php
session_start();

// Check if the user session is not active
if (!isset($_SESSION['username'])) {
    header("Location: login.html"); // Redirect to the user login page
    exit(); 
}

$uploadsDirectory = "uploads/"; // Directory where the uploaded documents are stored
$uploadedDocuments = scandir($uploadsDirectory); // Get the list of files in the uploads directory
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Home - Download Documents</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #ff6a00, #ee0979);
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            background-size: cover;
            background-position: center;
        }

        h1, h2 {
            text-align: center;
            margin: 20px 0;
            font-weight: 700;
            text-transform: uppercase;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.7);
            background: linear-gradient(90deg, #00f, #0ff, #ff0, #f0f);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: gradientAnim 5s ease infinite;
        }

        @keyframes gradientAnim {
            0% {background-position: 0% 50%;}
            50% {background-position: 100% 50%;}
            100% {background-position: 0% 50%;}
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin: 30px auto;
            border: 5px double #fff;
            border-radius: 15px;
            overflow: hidden;
            background: rgba(0,0,0,0.4);
            box-shadow: 0 8px 25px rgba(0,0,0,0.6);
        }

        th, td {
            padding: 15px 20px;
            text-align: left;
            border-bottom: 1px solid #fff;
            transition: all 0.3s ease;
        }

        th {
            background: linear-gradient(90deg, #ff512f, #dd2476);
            color: #fff;
            font-size: 18px;
            text-transform: uppercase;
        }

        tr:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.02);
            transition: all 0.3s ease;
        }

        .download-link {
            color: #00ffff;
            font-weight: 600;
            text-decoration: none;
            position: relative;
        }

        .download-link::after {
            content: '';
            position: absolute;
            width: 0%;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: #ff0;
            transition: width 0.3s;
        }

        .download-link:hover::after {
            width: 100%;
        }

        .no-documents {
            text-align: center;
            margin-top: 30px;
            font-size: 20px;
            font-weight: bold;
            color: #ffd700;
            text-shadow: 2px 2px 5px #000;
        }

        .back-btn {
            display: inline-block;
            margin: 30px auto;
            padding: 12px 30px;
            background: linear-gradient(45deg, #ff512f, #dd2476);
            color: #fff;
            font-weight: bold;
            text-decoration: none;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.5);
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            transform: translateY(-3px);
            background: linear-gradient(45deg, #00f, #0ff);
            color: #000;
        }

        @media(max-width: 768px) {
            table {
                width: 95%;
            }

            h1, h2 {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>
    <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
    <h2>Download Documents</h2>

    <?php
    if (count($uploadedDocuments) > 2) { // Exclude "." and ".."
        echo "<table>
                <tr>
                    <th>Document Name</th>
                </tr>";
        foreach ($uploadedDocuments as $document) {
            if ($document != "." && $document != "..") {
                $documentPath = $uploadsDirectory . $document;
                echo "<tr>
                        <td><a href='$documentPath' class='download-link'>$document</a></td>
                      </tr>";
            }
        }
        echo "</table>";
    } else {
        echo "<p class='no-documents'>No documents available for download.</p>";
    }
    ?>

    <a href="documents.php" class="back-btn">← Back to Documents</a>
</body>
</html>
