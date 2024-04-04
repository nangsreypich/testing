<?php

include_once('../controller/config.php');
$index=$_GET['index'];
$grade_id=$_GET['grade'];

$sql1="SELECT * FROM teacher WHERE index_number='$index'";
$result1=mysqli_query($conn,$sql1);
$row1=mysqli_fetch_assoc($result1);
$id=$row1['id'];

$sql="select course_routing.grade_id as s_id,course.name as s_name
      from course_routing
      inner join course
      on course_routing.grade_id=course.id 
      where course_routing.grade_id=$grade_id and course_routing.teacher_id=$id";

$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result) > 0){
	while($row=mysqli_fetch_assoc($result)){
			
?>
        <option value="<?php echo $row["s_id"]; ?>"><?php echo $row['s_name']; ?></option><!--MSK-000122-->
<?php } } ?>