<?php
include_once('../controller/config.php');
$id=$_GET["id"];

$sql = "select exam_timetable.id as ett_id,exam_timetable.day as ett_day,course.id as s_id, exam_timetable.start_time as ett_stime,exam_timetable.end_time as ett_etime
		from exam_timetable
		inner join course
		on exam_timetable.grade_id=course.id 
		where exam_timetable.id=$id";
		
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);

$res=array($row['ett_id'],$row['ett_day'],$row['s_id'],$row['ett_stime'],$row['ett_etime']);
echo json_encode($res);//MSK-000134

?>	