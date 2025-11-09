<?php
require('conn.php');
session_start();
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
    $checkQuery = "SELECT * FROM user_table WHERE  mobile='$mobile' OR aadhar='$aadhar' ";
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
