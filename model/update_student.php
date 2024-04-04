<?php
include_once('controller/config.php');
if(isset($_POST["do"]) && ($_POST["do"] == "update_student")){

	$index_number = $_POST['index_number'];
	$grade_id = $_POST['grade_id'];
	
	$full_name = $_POST['full_name']; 
	$kh_name = $_POST['kh_name']; 
	$address = $_POST['address']; 
	$gender = $_POST['gender']; 
	$phone = $_POST['phone']; 
	$email = $_POST['email'];
	$b_date = $_POST["b_date"];

	$msg = 0; // for alerts
	
	// Assuming $name is not needed for file uploads, so removing the related code
	
	$sql = "UPDATE student SET full_name='$full_name', kh_name='$kh_name', address='$address', gender='$gender', phone='$phone', email='$email', b_date='$b_date' WHERE index_number='$index_number'";
	
	if(mysqli_query($conn, $sql)){
		$msg += 1; 
		// MSK-000143-U-8 The record has been successfully updated into the database
	} else {
		$msg += 2; 
		// MSK-000143-U-9 Connection problem
	}
	
	header("Location: view/all_student.php?do=alert_from_update&msg=$msg&page=$c_page");
}
?>
