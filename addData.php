<?php
    //ket noi
    include("config.php");
    //doc du lieu
    $SampR = $_POST["rate"];
    $Digital = $_POST["dlpf"];
    $ACC = $_POST["AccFS"];
    $Gyro = $_POST["GFS"];
    $Int = $_POST["INT"];

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        //gui xuong database
        $sql = "update thietlap set Sample=$SampR,DLPF=$Digital,Accelorometer=$ACC,Gyroscope=$Gyro,Interrupt=$Int";
        //$sql = "insert into thuthap(Sample,DLPF,Accelorometer,Gyroscope,Interrupt) values ($SampR,$Digital,$ACC,$Gyro,$Int);";
        mysqli_query($conn,$sql);
        mysqli_close($conn); 
    }
?>
