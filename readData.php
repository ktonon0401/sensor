<?php
header('Content-Type: application/json');

// dang nhap vao database
include("config.php");

// Doc gia tri RGB tu database
$sql = "select * from thuthap where stt>(select max(stt) from thuthap)-20";
$result = mysqli_query($conn,$sql);

$data = array();
foreach ($result as $row){
    $data[] = $row;
}
mysqli_query($conn,$sql);

mysqli_close($conn);
echo json_encode($data);

?>
