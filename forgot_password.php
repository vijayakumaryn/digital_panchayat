<?php
require('conn.php');
session_start();

// Check if the user is requesting password retrieval
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["forgot_password"])) {
    $mobile = $_POST["mobile"];
    $aadhar = $_POST["aadhar"];
 
    // Check if the mobile number or Aadhar number exists in the user_table
    $checkQuery = "SELECT * FROM user_table WHERE mobile='$mobile' OR aadhar='$aadhar'";
    $result = $con->query($checkQuery);

    if ($result->num_rows > 0) {
        // Mobile number or Aadhar number exists, retrieve the password and username
        $row = $result->fetch_assoc();
        $username = $row['uname'];
        $password = $row['passwd'];

        // Display the username and password
        echo "Username: $username<br>";
        echo "Password: $password";
        exit();
    } else {
        // Mobile number or Aadhar number does not exist
        $error = "Mobile number or Aadhar number does not exist.";
        header("Location: forgot_password.html?error=$error");
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
    $username = $_POST["username"];
    $mobile = $_POST["mobile"];
    $aadhar = $_POST["aadhar"];
    $state = $_POST["state"];
    $town = $_POST["town"];
    $village = $_POST["village"];
    $password = $_POST["password"];

    // Check if the username, mobile number, Aadhar, or password already exist
    $checkQuery = "SELECT * FROM user_table WHERE mobile='$mobile' OR aadhar='$aadhar'";
    $result = $con->query($checkQuery);

    if ($result->num_rows > 0) {
        $error = '';
        while ($row = $result->fetch_assoc()) {

            if ($row['mobile'] == $mobile) {
                $error .= 'Mobile number already exists. ';
            }
            if ($row['aadhar'] == $aadhar) {
                $error .= 'Aadhar number already exists. ';
            }

        }
        header("Location: register.html?error=$error");
        exit();
    }

    // Insert the new user data into the table
    $insertQuery = "INSERT INTO user_table (uname, mobile, passwd, aadhar, state, town, village)
                    VALUES ('$username', '$mobile', '$password', '$aadhar', '$state', '$town', '$village')";

    if ($con->query($insertQuery) === TRUE) {
        header("Location: login.html");
        exit();
    } else {
        header("Location: register.html?error=database");
        exit();
    }
}
?>
