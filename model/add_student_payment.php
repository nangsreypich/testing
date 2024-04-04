<?php
include_once('controller/config.php');

if (isset($_POST["do"]) && ($_POST["do"] == "add_student_payment")) {

    // Get form values
    $index_number = isset($_POST["index_number"]) ? $_POST["index_number"] : "";
    $total_sfee = isset($_POST["totalsfee"]) ? $_POST["totalsfee"] : "";
    $invoice_number = isset($_POST["invoice_number"]) ? $_POST["invoice_number"] : "";
    $status = isset($_POST['type']) ? $_POST['type'] : "";
    $paid = isset($_POST['paid']) ? $_POST['paid'] : "";
    $discount = isset($_POST['discount']) ? $_POST['discount'] : "";
    $total = isset($_POST['total']) ? $_POST['total'] : "";
    $grade_id = isset($_POST["grade_id"]) ? $_POST["grade_id"] : "";
    $teacher_id = isset($_POST["teacher_id"]) ? $_POST["teacher_id"] : "";

    // Fetch the date from the form input
    $payment_date = isset($_POST["payment_date"]) ? $_POST["payment_date"] : "";
    $payment_month = isset($_POST["payment_month"]) ? $_POST["payment_month"] : "";
    $payment_year = isset($_POST["payment_year"]) ? $_POST["payment_year"] : "";

    $msg = 0;
    $page = 1;

    // Check if the student has made previous payments
    $sql_check = "SELECT * FROM student_payment_history WHERE index_number='$index_number' LIMIT 1";
    $result_check = mysqli_query($conn, $sql_check);

    if (mysqli_num_rows($result_check) > 0) {
        // If the student has made previous payments, update the existing record
        $sql_update = "UPDATE student_payment_history
                       SET subject_fee = subject_fee + '$paid'
                       WHERE index_number='$index_number'
                       ORDER BY date DESC LIMIT 1";

        if (mysqli_query($conn, $sql_update)) {
            $msg += 1;
        } else {
            $msg += 1;
            echo "Error updating student_payment_history: " . mysqli_error($conn);
        }
    } else {
        // If it's the first payment, insert a new record
        $sql_insert = "INSERT INTO student_payment_history (index_number, grade_id, teacher_id, subject_fee, _status, invoice_number, month, year, date) 
                       VALUES ('$index_number', '$grade_id', '$teacher_id', '$paid', '$status', '$invoice_number', '$payment_month', '$payment_year', '$payment_date')";

        if (mysqli_query($conn, $sql_insert)) {
            $msg += 1;
        } else {
            $msg += 1;
            echo "Error inserting into student_payment_history: " . mysqli_error($conn);
        }
    }

    // Insert into student_payment table
    $sql_student_payment = "INSERT INTO student_payment (index_number, grade_id, teacher_id,  year, month, date, paid, discount, total, student_status, inv_number)
                           VALUES ('$index_number', '$grade_id', '$teacher_id', '$payment_year', '$payment_month', '$payment_date', '$paid', '$discount', '$total', '$status', '$invoice_number')";

    if (mysqli_query($conn, $sql_student_payment)) {
        $msg += 1;
    } else {
        $msg += 1;
        echo "Error in student_payment: " . mysqli_error($conn);
    }

    // Check if the entry already exists in student_course
    $sql_check_course = "SELECT * FROM student_course WHERE index_number='$index_number' AND grade_id='$grade_id'";
    $result_check_course = mysqli_query($conn, $sql_check_course);

    if (mysqli_num_rows($result_check_course) == 0) {
        // Insert into student_course table if no duplicate exists
        $sql_student_course = "INSERT INTO student_course (index_number, grade_id, year, reg_month, _status)
                    VALUES ('$index_number', '$grade_id', '$payment_year', '$payment_month', '')";

        if (mysqli_query($conn, $sql_student_course)) {
            $msg += 1;
        } else {
            echo "Error in student_course: " . mysqli_error($conn);
        }
    }

    // Redirect based on the showPage parameter 
    if (isset($_POST["showPage"]) && ($_POST["showPage"] == "all_student")) {
        header("Location:view/all_student.php?do=alert_from_payment_insert&msg=$msg&page=$page&index=$index_number&desc='$status'&paid=$paid&invoice_number=$invoice_number&grade_id=$grade_id&teacher_id=$teacher_id");
    }

    if (isset($_POST["showPage"]) && ($_POST["showPage"] == "all_student")) {
        header("Location:view/student_payment.php?do=alert_from_payment_insert&msg=$msg&page=$page&index=$index_number&desc='$status'&paid=$paid&invoice_number=$invoice_number&grade_id=$grade_id&teacher_id=$teacher_id");
    }
}
?>
