<?php
include_once('../controller/config.php');
$id=$_GET["id"];

$sql = "select course_routing.id as sr_id,course_routing.fee as s_fee, course.name as g_name,teacher.full_name as t_name
		from course_routing
		inner join course
		on course_routing.grade_id=course.id 
		inner join teacher
		on course_routing.teacher_id=teacher.id
		where course_routing.id=$id";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);

$res=array($row['sr_id'],$row['g_name'],$row['t_name'],$row['s_fee']);
echo json_encode($res);//MSK-00106

?>	