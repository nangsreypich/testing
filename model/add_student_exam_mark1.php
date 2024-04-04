<?php
include_once('controller/config.php');

if (isset($_POST["do"]) && ($_POST["do"] == "add_student_exam_mark1")) {
    $my_index = isset($_POST['my_index']) ? $_POST['my_index'] : '';
    $std_index = isset($_POST['std_index']) ? $_POST['std_index'] : '';
    $exam_id = isset($_POST['exam_id']) ? $_POST['exam_id'] : '';
    $page = isset($_POST['current_page']) ? $_POST['current_page'] : '';
    
    $current_year = date('Y');
    $date = date("Y-m-d");
    $msg = 0; // for alerts

    $grade_ids = isset($_POST['grade_id']) ? $_POST['grade_id'] : array();
    $exam_marks = isset($_POST['exam_mark']) ? $_POST['exam_mark'] : array();

    for ($i = 0; $i < count($grade_ids); $i++) {
        $current_grade_id = $grade_ids[$i];
        $mark = $exam_marks[$i];

        $sql = "INSERT INTO student_exam(index_number, grade_id, exam_id, marks, year, date)
                VALUES ('" . $std_index . "','" . $current_grade_id . "','" . $exam_id . "','" . $mark . "','" . $current_year . "','" . $date . "')";

        if (mysqli_query($conn, $sql)) {
            $msg = 1;
            // MSK-000143-3 The record has been successfully inserted into the database.
        } else {
            $msg = 2;
            // MSK-000143-4 Connection problem.
        }
    }

    $encoded_grade_ids = implode(',', array_map('urlencode', $grade_ids));

    header("Location: view/my_student_exam_marks.php?do=alert_from_insert&msg=$msg&exam=" . urlencode($exam_id) . "&current_year=$current_year&my_index=$my_index&grade=$encoded_grade_ids");
}
?>
