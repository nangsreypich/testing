<?php
include_once('controller/config.php');

if (isset($_POST["do"]) && ($_POST["do"] == "add_teacher_salary")) {

    $index = $_POST['index_number'];
    $paid = $_POST['paid'];
    $invoice_number = $_POST['invoice_number'];

    $month = date('F');
    $year = date('Y');
    $date = date("Y-m-d");

    $msg = 0;
    $page = 1;

    $sql = "SELECT course_routing.fee as sr_fee, course_routing.grade_id as sr_id
            FROM course_routing
            INNER JOIN course ON course_routing.grade_id = course.id
            WHERE course_routing.teacher_id='$index'";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $grade_id = $row['sr_id'];
            $subject_fee = $row['sr_fee'];

            // Count students directly from student_payment_history
            $sql_student_count = "SELECT COUNT(DISTINCT index_number) as student_count
                                 FROM student_payment_history
                                 WHERE teacher_id = '$index'
                                 AND grade_id = '$grade_id'
                                 AND (_status = '1Month' OR _status = '3Months' OR _status = '6Months' OR _status = '9Months' OR _status = '1Year')
                                 AND month = '$month'";

            $result_student_count = mysqli_query($conn, $sql_student_count);
            $row_student_count = mysqli_fetch_assoc($result_student_count);
            $student_count = $row_student_count['student_count'];

            // Calculate the total salary
            $total = $subject_fee * $student_count;

            // Update teacher_salary_history table
            $sql2 = "INSERT INTO teacher_salary_history(index_number, grade_id, subject_fee, student_count, total, paid, month, year, date, invoice_number) 
                     VALUES ('$index', '$grade_id', '$subject_fee', '$student_count', '$total', '$paid', '$month', '$year', '$date', '$invoice_number')";

            mysqli_query($conn, $sql2);
        }
    } else {
        echo "Error in SQL: " . mysqli_error($conn);
    }

    // Update teacher_salary table
    $sql3 = "INSERT INTO teacher_salary(index_number, month, year, date, paid, _status) 
             VALUES ('$index', '$month', '$year', '$date', '$paid', '')";

    if (mysqli_query($conn, $sql3)) {
        $msg += 1; // The record has been successfully inserted into the database.
    } else {
        $msg += 2; // Connection problem.
    }

    header("Location: view/all_teacher.php?do=alert_from_insert&msg=$msg");
}
