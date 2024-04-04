<?php
include_once('../controller/config.php');
$id=$_GET["id"];

$sql = "select timetable.id as tt_id,timetable.day as tt_day, teacher.id as t_id,timetable.start_time as tt_stime,timetable.end_time as tt_etime,timetable.grade_id as g_id
		from timetable
		inner join course
		on timetable.grade_id=course.id 
		inner join teacher
		on timetable.teacher_id=teacher.id
		where timetable.id=$id";
		
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);

$res=array($row['tt_id'],$row['tt_day'],$row['t_id'],$row['tt_stime'],$row['tt_etime'],$row['g_id']);
echo json_encode($res);//MSK-000134

?>	