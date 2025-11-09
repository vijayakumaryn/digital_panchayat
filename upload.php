<?php
session_start();

// Check if the admin session is not active
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.html"); // Redirect to the admin login page
    exit();
}

// Handle file upload
if (isset($_POST['upload'])) {
    $targetDirectory = "uploads/"; // Directory to store the uploaded files
    $fileName = $_FILES['file']['name'];
    $targetFilePath = $targetDirectory . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Allow only certain file formats (e.g., PDF, DOCX)
    $allowedFormats = array('pdf', 'docx');
    
    if (in_array($fileType, $allowedFormats)) {
        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath)) {
            $successMessage = "File uploaded successfully.";
        } else {
            $errorMessage = "File upload failed.";
        }
    } else {
        $errorMessage = "Invalid file format. Only PDF and DOCX files are allowed.";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Home</title>
    <style>
        body {
            background-image: url('images/admin14.jpg');
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            color: blue;
        }

        h1, h2 {
            text-align: center;
            margin: 20px 0;
            color: yellow;
        }

        .upload-form {
            text-align: center;
            margin-top: 20px;
        }

        .success-message {
            color: green;
        }

        .error-message {
            color: red;
        }
    </style>
</head>
<body>
    <h1>Welcome, Admin!</h1>
    <h2>Upload Document</h2>

    <div class="upload-form">
        <form method="POST" enctype="multipart/form-data">
            <input type="file" name="file" required>
            <br><br>
            <input type="submit" name="upload" value="Upload">
        </form>

        <?php if (isset($successMessage)) { ?>
            <p class="success-message"><?php echo $successMessage; ?></p>
        <?php } ?>

        <?php if (isset($errorMessage)) { ?>
            <p class="error-message"><?php echo $errorMessage; ?></p>
        <?php } ?>
    </div>

    <a href="adminhome.php">Go back to Home</a> <!-- Link to go back to the admin home page -->
</body>
</html>
