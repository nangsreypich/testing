<?php

include_once('../controller/config.php');
$id=$_GET["id"];
$sql = "SELECT * FROM course WHERE id=$id";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);

$row1=array($row['id'],$row['name'],$row['admission_fee'],$row['generation']);
echo json_encode($row1);//MSK-00106

?>	


