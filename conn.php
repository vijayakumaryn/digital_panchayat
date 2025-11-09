<?php
    $uname = "root";
    $passwd = "";
    $serv = "127.0.0.1"; // IPv4 loopback
    $db = "vj";
    $port = 3307;        // or 3307 if needed

    $con = mysqli_connect($serv, $uname, $passwd, $db, $port);

    if (!$con)
        die("<h2>Connection Failed: " . mysqli_connect_error() . "</h2>");
?>
