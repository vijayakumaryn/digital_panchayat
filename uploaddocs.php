<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.html");
    exit();
}

$newUpload = '';

if (isset($_POST['upload'])) {
    $targetDirectory = "uploads/"; 
    $fileName = $_FILES['file']['name'];
    $targetFilePath = $targetDirectory . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    $allowedFormats = array('pdf', 'docx');

    if (in_array($fileType, $allowedFormats)) {
        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath)) {
            $successMessage = "File uploaded successfully.";
            $newUpload = $fileName; // Track newly uploaded file
        } else {
            $errorMessage = "File upload failed.";
        }
    } else {
        $errorMessage = "Invalid file format. Only PDF and DOCX allowed.";
    }
}

if (isset($_GET['delete'])) {
    $documentPath = $_GET['delete'];
    if (file_exists($documentPath)) {
        unlink($documentPath);
        $successMessage = "Document deleted successfully.";
    } else {
        $errorMessage = "Document not found.";
    }
}

$uploadsDirectory = "uploads/";
$uploadedDocuments = scandir($uploadsDirectory);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - Upload Docs</title>
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
            font-size: 48px;
            margin: 30px 0;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.7);
        }

        h2 {
            text-align: center;
            font-size: 28px;
            margin-bottom: 20px;
            text-shadow: 1px 1px 6px rgba(0,0,0,0.6);
        }

        .card {
            background: rgba(0,0,0,0.4);
            margin: 20px auto;
            padding: 20px;
            border-radius: 20px;
            width: 90%;
            max-width: 600px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.6);
            transition: transform 0.3s ease, background 0.5s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            background: rgba(0,0,0,0.6);
        }

        .upload-form {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        input[type="file"] {
            padding: 10px;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            background: rgba(255,255,255,0.2);
            color: #fff;
            font-weight: bold;
        }

        input[type="submit"] {
            margin-top: 10px;
            padding: 12px 25px;
            border: none;
            border-radius: 25px;
            background: linear-gradient(45deg, #12d8fa, #1fa2ff);
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.4);
        }

        input[type="submit"]:hover {
            background: linear-gradient(45deg, #1fa2ff, #12d8fa);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.6);
        }

        .message {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-top: 15px;
        }

        .success-message { color: #00ff00; animation: fadeIn 1s; }
        .error-message { color: #ff4b4b; animation: fadeIn 1s; }
        @keyframes fadeIn { from {opacity:0;} to {opacity:1;} }

        .document-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(135deg, rgba(255,255,255,0.1), rgba(255,255,255,0.2));
            padding: 15px 20px;
            border-radius: 15px;
            margin: 10px auto;
            box-shadow: 0 4px 15px rgba(0,0,0,0.5);
            font-weight: bold;
            color: #fff;
            transition: transform 0.3s ease, background 0.5s ease;
        }

        .document-card.new-upload {
            animation: slideIn 0.7s ease forwards;
        }

        @keyframes slideIn {
            from { transform: translateX(-100%) scale(0.9); opacity: 0; }
            to { transform: translateX(0) scale(1); opacity: 1; }
        }

        .document-card:hover {
            transform: scale(1.02);
            background: linear-gradient(135deg, rgba(255,255,255,0.15), rgba(255,255,255,0.25));
        }

        .delete-button {
            padding: 6px 12px;
            border-radius: 12px;
            border: none;
            background: linear-gradient(135deg, #ff416c, #ff4b2b);
            color: #fff;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .delete-button:hover {
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
    <div class="card upload-form">
        <h2>Upload Document</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="file" name="file" required>
            <br><br>
            <input type="submit" name="upload" value="Upload">
        </form>
        <div class="message">
            <?php if(isset($successMessage)) echo "<span class='success-message'>$successMessage</span>"; ?>
            <?php if(isset($errorMessage)) echo "<span class='error-message'>$errorMessage</span>"; ?>
        </div>
    </div>

    <?php if(count($uploadedDocuments) > 2): ?>
        <?php foreach($uploadedDocuments as $document):
            if($document != "." && $document != ".."):
                $documentPath = $uploadsDirectory . $document;
                $newClass = ($document === $newUpload) ? 'new-upload' : '';
        ?>
                <div class="card document-card <?= $newClass ?>">
                    <span><?= $document ?></span>
                    <button class="delete-button" onclick="deleteDocument('<?= $documentPath ?>')">Delete</button>
                </div>
        <?php endif; endforeach; ?>
    <?php else: ?>
        <p style="text-align:center; font-size:20px; color:#ff4b4b;">No documents available.</p>
    <?php endif; ?>

    <script>
        function deleteDocument(documentPath){
            if(confirm("Are you sure you want to delete this document?")){
                window.location.href = "uploaddocs.php?delete=" + documentPath;
            }
        }
    </script>

    <a class="back-link" href="adminhome.php">Back to Admin Home</a>
</body>
</html>
