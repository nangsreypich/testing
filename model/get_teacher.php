<?php

include_once('../controller/config.php');
$id=$_GET["id"];
$sql = "SELECT * FROM teacher WHERE id=$id";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);

$row1=array($row['id'],$row['index_number'],$row['full_name'],$row['kh_name'],$row['address'],$row['gender'],$row['phone'],$row['dob'],$row['pob'],$row['position'],$row['join_date'],$row['email'],$row['reg_date']);
echo json_encode($row1);//MSK-00117 - Ajax Response Json

?>	