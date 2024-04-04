<?php
include_once('../controller/config.php');

$id=$_GET["id"];
$sql = "SELECT * FROM book_sale WHERE id=$id";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);

$res=array($row['id'],$row['cus_name'],$row['phone'],$row['address'],$row['book_id'],$row['qty'],$row['unit_price'],$row['teacher_price'],$row['efk_price'],$row['company'],$row['paid_date']);
echo json_encode($res);//MSK-00106

?>	