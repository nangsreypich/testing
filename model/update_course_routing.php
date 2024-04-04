<?php
include_once('../controller/config.php');

	$id=$_GET['id'];
	$grade=$_GET['grade']; 
	$teacher=$_GET['teacher']; 
	$fee=$_GET['fee']; 

	$sql1="SELECT * FROM grade where name='$grade'";
	$result1=mysqli_query($conn,$sql1);
	$row1=mysqli_fetch_assoc($result1);
	$grade_id=$row1['id'];

	$sql3="SELECT * FROM teacher where full_name='$teacher'";
	$result3=mysqli_query($conn,$sql3);
	$row3=mysqli_fetch_assoc($result3);
	$teacher_id=$row3['id'];
	
	$sql4="SELECT * FROM course_routing where grade_id='$grade_id' and teacher_id='$teacher_id'";
	$result4=mysqli_query($conn,$sql4);
	$row4=mysqli_fetch_assoc($result4);

	$id4=$row4['id'];
	$grade_id4=$row4['grade_id'];	
	$teacher_id4=$row4['teacher_id'];
	$fee4=$row4['fee'];

	$msg=0;
	$grade1=""; 
	$teacher1=""; 
	$fee1="";  
	
	if($grade_id == $grade_id4 && $teacher_id == $teacher_id4){
		if($id == $id4){//MSK-000143-U-1
		
			if($fee == $fee4){
				$msg+=3;
				//MSK-000143-U-2 You didn't make any of changes.:D	
				
			}else{//MSK-000143-U-3
				$sql5 = "update course_routing set grade_id='".$grade_id."',teacher_id='".$teacher_id."',fee='".$fee."' where id='$id'";
				if(mysqli_query($conn,$sql5)){
					$msg+=1;
					//MSK-000143-U-4 The record has been successfully updated in the database
					
					$sql6="select course_routing.fee as s_fee,course.name as g_name,teacher.full_name as t_name
						   from course_routing
						   inner join course
						   on course_routing.grade_id=course.id 
						   inner join teacher
						   on course_routing.teacher_id=teacher.id
						   where course_routing.id='$id'";
					
					$result6=mysqli_query($conn,$sql6);
					$row6=mysqli_fetch_assoc($result6);//MSK-000143-U-5
					
					$grade1=$row6['g_name']; 
					$teacher1=$row6['t_name']; 
					$fee1=$row6['s_fee']; 
						
				}else{
					$msg+=2;
					//MSK-000143-U-6 Connection problem
				}
				
			}
			
		}else{
			$msg+=4;
			//MSK-000143-U-7 The record is duplicated
		}
		
	}else{//MSK-000143-U-8
	
		$sql5 = "update course_routing set grade_id='".$grade_id."',teacher_id='".$teacher_id."',fee='".$fee."' where id='$id'";
		
		if(mysqli_query($conn,$sql5)){

			$msg+=1;
			//MSK-000143-U-9 The record has been successfully updated in the database
			
			$sql6="select course_routing.fee as s_fee,course.name as g_name,teacher.full_name as t_name
				   from course_routing
				   inner join course
				   on course_routing.grade_id=course.id 
				   inner join teacher
				   on course_routing.teacher_id=teacher.id
				   where course_routing.id='$id'";
			
			$result6=mysqli_query($conn,$sql6);
			$row6=mysqli_fetch_assoc($result6);//MSK-000143-U-10
			
			$grade1=$row6['g_name']; 
			$teacher1=$row6['t_name']; 
			$fee1=$row6['s_fee']; 
				
		}else{
			$msg+=2;
			//MSK-000143-U-11 Connection problem
		}
		
	}

$res=array($grade1,$teacher1,$fee1,$msg);
echo json_encode($res);//MSK-000143-U-12


?>