<?php
    $server ="localhost"; //IP address of server
    $user ="nkhoi";
    $pass ="1";
    $database ="sensor";

    $conn = mysqli_connect($server,$user,$pass,$database);
    if(mysqli_connect_errno())
    {
        echo "Failed to connect to DB: " . mysqli_connect_errno();
        exit();
    }
?>
