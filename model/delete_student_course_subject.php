<?php
include_once("../controller/config.php");
$index=$_GET['index'];
$page=$_GET['page'];
$msg=0;

$sql="delete id1.*
      from student_course id1
      where id1.index_number='$index'";
if(mysqli_query($conn,$sql)){

	$msg+=1;
	
}else{
	$msg+=2; 
}

	$res=array($msg,$page,$sql);
	echo json_encode($res);//MSK-000128-Del

?>


	