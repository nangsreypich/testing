<?php
include_once('controller/config.php');
if(isset($_POST["do"])&&($_POST["do"]=="update_student_profile")){

	$id=$_POST['id'];
	
	$full_name=$_POST['full_name'];
	$kh_name=$_POST['kh_name']; 
	$gender=$_POST['gender']; 
	$address=$_POST['address'];
	$phone=$_POST['phone'];
	
	$email=$_POST['email']; 
	$password=$_POST['password']; 
	
	$sql2="SELECT * FROM student WHERE id='$id'";
	$result2=mysqli_query($conn,$sql2);
	$row2=mysqli_fetch_assoc($result2);
	$email2=$row2['email'];
	
	$max = 31457280;
	$extention = strtolower(substr($name, strpos($name, ".")+ 1));
	$filename = date("Ymjhis");
	
	$msg=0;//for alerts  
	
	if(!$name){
		
		$sql = "update student set full_name='".$full_name."',kh_name='".$kh_name."', gender='".$gender."',address='".$address."', phone='".$phone."',email='".$email."' where id='$id'";
		
		if(mysqli_query($conn,$sql)){
							
			if($email == $email2){
				$sql1 = "update user set password='".$password."' where email='$email'";
				mysqli_query($conn,$sql1);
					
			}else{
				$sql3="DELETE FROM user WHERE email='$email2'";
				mysqli_query($conn,$sql3);
					
				$sql4="INSERT INTO user (email,password,type) 
					   VALUES ( '".$email."','".$password."','Student')";
				mysqli_query($conn,$sql4);
					
			}
			
			$msg+=1;
			//MSK-000143-U-4 The record has been successfully updated in the database.
		
		}else{
			$msg+=2;
			//MSK-000143-U-6 Connection problem	
		}
		
	}else{
		
		$msg+=3;
		
	}
	
	header("Location:view/my_profile.php?do=alert_from_update&msg=$msg");//MSK-000143-5

}
?>