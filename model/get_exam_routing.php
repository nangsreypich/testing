<?php
include_once('../controller/config.php');
$id=$_GET["id"];

$sql = "select exam_routing.id as exr_id,course.id as g_id,exam.id as e_id
		from exam_routing
		inner join course
		on exam_routing.grade_id=course.id 
		inner join exam
		on exam_routing.exam_id=exam.id
		where exam_routing.id=$id";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);

$res=array($row['exr_id'],$row['g_id'],$row['e_id']);
echo json_encode($res);//MSK-00106

?>	