<?php
include_once('controller/config.php');

if (isset($_POST["do"]) && ($_POST["do"] == "update_staff")) {
    $id = $_POST['id'];
    $full_name = $_POST['full_name'];
    $kh_name = $_POST['kh_name'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $dob=$_POST['dob'];
	$pob=$_POST['pob'];
    $position=$_POST['position'];
	$join_date=$_POST['join_date'];
	$stop_date=$_POST['stop_date'];
    $email = $_POST['email'];

    
    $c_page = $_POST['c_page']; // current table page

    $sql = "SELECT * FROM staff WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    $msg = 0; // for alerts

    if (!$row) {
        $msg += 2;
        // MSK-000143-U-9 Connection problem or staff not found
    } else {
        // Assuming $std_index is the correct variable for the staff's index
        $std_index = $row['index_number'];

        $sql = "UPDATE staff SET full_name='$full_name', kh_name='$kh_name', address='$address', gender='$gender', phone='$phone', dob='$dob', pob='$pob',  position='$position', join_date='$join_date', stop_date='$stop_date', email='$email' WHERE index_number='$std_index'";

        if (mysqli_query($conn, $sql)) {
            $msg += 1;
            // MSK-000143-U-8 The record has been successfully updated into the database
        } else {
            $msg += 2;
            // MSK-000143-U-9 Connection problem
        }
    }

    header("Location: view/all_staff.php?do=alert_from_update&msg=$msg&page=$c_page");
}
?>
