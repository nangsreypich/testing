<?php
include_once('controller/config.php');
if(isset($_POST["do"])&&($_POST["do"]=="add_teacher")){

	$index_number = $_POST["index_number"];		
	$full_name = $_POST["full_name"];
	$kh_name = $_POST["kh_name"];
	// $i_name= $_POST["i_name"];
	$gender = $_POST["gender"];
	$address = $_POST["address"];
	$phone = $_POST["phone"];
	$dob = $_POST["dob"];
	$pob = $_POST["pob"];
	$email = $_POST["email"];
	$position = $_POST["position"];
	$join_year = $_POST["join_year"];
	$join_date = $_POST["join_date"];

	$current_date=date("Y-m-d");
	
	$max = 31457280;
	$extention = strtolower(substr($name, strpos($name, ".")+ 1));
	$filename = date("Ymjhis");
	
	$sql1="SELECT * FROM teacher where index_number='$index_number'";	
	$result1=mysqli_query($conn,$sql1);
	$row1=mysqli_fetch_assoc($result1);
	$index_number1=$row1['index_number'];
	
	$sql2="SELECT * FROM teacher where email='$email'";	
	$result2=mysqli_query($conn,$sql2);
	$row2=mysqli_fetch_assoc($result2);
	$email2=$row2['email'];
	
	$msg=0;//for alerts

	if($index_number == $index_number1 ){
		//MSK-000143-1 The index number is duplicated.
		$msg+=1;
		
		if($email == $email2){
			//MSK-000143-2 Both index number and email duplicate. 
			$msg+=3; //(Note: msg value is not equel to 3, its value is 1+=3 -> 1+3 = 4 :D)
		}

	}else if($email == $email2){
		
		//MSK-000143-3 Only email address duplicates.
		$msg+=5;
		
	}else{
		//MSK-000143-   																					
				//MSK-000143-5	
				
				$sql = "INSERT INTO teacher (index_number, full_name, kh_name, gender, address, phone, dob, pob, email, reg_date, position, join_year, join_date)
			            VALUES ('".$index_number."', '".$full_name."','".$kh_name."','".$gender."','".$address."','".$phone."','".$dob."','".$pob."','".$email."','".$current_date."','".$position."','".$join_year."','".$join_date."')";
				if(mysqli_query($conn,$sql)){
					$msg+=2;  
					//MSK-000143-6 The record has been successfully inserted into the database.
					$sql3= "INSERT INTO user (email,password,type)
			                VALUES ('".$email."','12345','Teacher')";
					
					mysqli_query($conn,$sql3);
				}else{
					$msg+=3;  
					//MSK-000143-7 Connection problem.
				}

	}
	header("Location: view/teacher.php?do=alert_from_insert&msg=$msg");//MSK-000143-9
}
?>