<?php
include_once('../controller/config.php');

$index = $_GET["index"];
$total_sfee = $_GET["totalsfee"];
$invoice_number = $_GET["inv_num"];

$current_month = date('F');
$current_year = date('Y');
$current_date = date('Y-m-d');

$msg = 0;
$msg_mfee = 0;

if ($total_sfee) {
    $sql = "INSERT INTO student_payment(index_number, paid, student_status, year, month, date) 
            VALUES ('$index', '$total_sfee', 'Yearly Fee', '$current_year', '$current_month', '$current_date')";

    if (mysqli_query($conn, $sql)) {
        $msg_mfee += 1;
    } else {
        $msg_mfee += 1;
    }
}

// Handle other student statuses
$sql3 = "SELECT * FROM student_course WHERE index_number='$index'";
$result3 = mysqli_query($conn, $sql3);

while ($row3 = mysqli_fetch_assoc($result3)) {
    $id = $row3['sr_id'];

    $sql2 = "SELECT course.id as s_id, course_routing.fee as s_fee, course_routing.teacher_id as t_id
            FROM course_routing
            INNER JOIN course ON course_routing.grade_id = course.id
            WHERE course_routing.id='$id'";

    $result2 = mysqli_query($conn, $sql2);

    while ($row2 = mysqli_fetch_assoc($result2)) {
        $grade_id = $row2['s_id'];
        $teacher_id = $row2['t_id'];
        $subject_fee = $row2['s_fee'];

        // Adjust student_status based on your requirements
        $student_status = 'Monthly Fee'; // You can modify this based on your logic

        $sql4 = "INSERT INTO student_payment_history (index_number, grade_id, teacher_id, subject_fee, student_status, invoice_number, month, year, date) 
                VALUES ('$index', '$grade_id', '$teacher_id', '$subject_fee', '$student_status', '$invoice_number', '$current_month', '$current_year', '$current_date')";

        mysqli_query($conn, $sql4);
    }
}

if ($msg_mfee == 1) {
    $msg += 1;
} else {
    $msg += 1;
}

$alert = array($msg);
echo json_encode($alert);
// MSK-000141
?>
