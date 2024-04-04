<?php
include_once('../controller/config.php');
if(isset($_GET["do"])&&($_GET["do"]=="leave_student")){

	$index_number=$_GET["index_number"]; 
	$index_number=$_GET["index_number"];
	$page=$_GET["page"]; 
	$msg=0;//for alerts
	
	$sql1="update student set _status='leave' where index_number='$index_number' and index_number='$index_number'";	
	
	if(mysqli_query($conn,$sql1)){

		$sql="delete index_number2.*
		      from student index_number1
		      inner join student_course index_number2
		      on index_number1.index_number=index_number2.index_number
		      where index_number1.index_number='$index_number' and index_number1.index_number='$index_number'";	
	
		if(mysqli_query($conn,$sql)){
			$msg+=1; 
		}else{
			$msg+=2; 
		}
		
	}
	
	$res=array($msg,$page);
	echo json_encode($res);//MSK-000128-Del

}
?>
