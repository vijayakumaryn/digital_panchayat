<?php
session_start();
require('conn.php');

$response = array('status' => 'error', 'message' => 'Invalid request!');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $login_type = $_POST["login_type"];

    if ($login_type == "Admin") {
        if ($username === "admin" && $password === "admin123") {
            $_SESSION['admin'] = $username;
            $response = array('status'=>'success', 'redirect'=>'adminhome.php');
        } else {
            $response = array('status'=>'error', 'message'=>'Invalid Admin Username or Password!');
        }
    } else {
        $username = stripslashes($username);
        $username = mysqli_real_escape_string($con,$username);
        $password = stripslashes($password);
        $password = mysqli_real_escape_string($con,$password);

        $query = "SELECT * FROM user_table WHERE (uname='$username' OR mobile='$username') AND passwd='$password'";
        $result = mysqli_query($con,$query);
        $d = mysqli_fetch_array($result);

        if(!$d) {
            $response = array('status'=>'error', 'message'=>'Invalid User Username/Mobile or Password!');
        } else {
            $_SESSION['username'] = $username;
            $response = array('status'=>'success', 'redirect'=>'index.php');
        }
    }
}

header('Content-Type: application/json');
echo json_encode($response);
?>
