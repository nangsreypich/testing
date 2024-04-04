<?php
include_once('../controller/config.php');

$id=$_GET["id"];
$sql = "SELECT * FROM book WHERE id=$id";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);

$res=array($row['id'],$row['title'],$row['author'],$row['publish_date'],$row['price']);
echo json_encode($res);//MSK-00106

?>	