		<option>Select Teacher</option>
        
<?php

include_once('../controller/config.php');
$grade_id=$_GET['grade'];

$sql="select course_routing.teacher_id as t_id,teacher.i_name as t_name
from course_routing
inner join teacher
on course_routing.teacher_id=teacher.id 
where course_routing.grade_id=$grade_id";

$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result) > 0){
	while($row=mysqli_fetch_assoc($result)){
		
		
?>
        <option value="<?php echo $row["t_id"]; ?>"><?php echo $row['t_name']; ?></option><!--MSK-000122-->
<?php } } ?>