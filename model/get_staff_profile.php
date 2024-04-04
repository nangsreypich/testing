<?php

include_once('../controller/config.php');
$my_index=$_GET["my_index"];

$sql = "SELECT * FROM staff WHERE index_number='$my_index'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);
$email=$row['email'];

$sql1="SELECT * FROM user WHERE email='$email'";
$result1=mysqli_query($conn,$sql1);
$row1=mysqli_fetch_assoc($result1);

$res=array($row['id'],$row['full_name'],$row['kh_name'],$row['gender'],$row['address'],$row['phone'],$row['email'],$row1['password']);
echo json_encode($res);//MSK-00106

?>	