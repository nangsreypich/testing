<?php

include_once('../controller/config.php');
$id=$_GET["id"];

$sql = "SELECT * FROM student WHERE id=$id";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);
$my_son_index=$row['index_number'];

$row1=array($row['id'],$row['index_number'],$row['full_name'],$row['kh_name'],$row['address'],$row['gender'],$row['phone'],$row['email'],$row1['kh_name'],$row1['address'],$row1['phone'],$row1['email']);
echo json_encode($row1);//MSK-00117 

?>