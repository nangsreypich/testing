<?php
include_once('controller/config.php');

if (isset($_POST["do"]) && ($_POST["do"] == "add_timetable")) {
    $grade_id = $_POST["grade_id"];
    $day = $_POST["day"];
    $teacher_id = $_POST["teacher_id"];
    $start_time = $_POST["start_time"];
    $end_time = $_POST["end_time"];

    $msg = 0; // for alerts

    $sql1 = "SELECT * FROM timetable WHERE day='$day' and end_time > $start_time and (start_time <= $start_time or start_time<$end_time)";

    $result1 = mysqli_query($conn, $sql1);

    if ($result1 === false) {
        // Handle query execution error
        $msg += 3; // Connection problem
    } else {
        if (mysqli_num_rows($result1) > 0) {
            $msg += 1;
        } else {
            $sql = "INSERT INTO timetable (grade_id, day, teacher_id,start_time,end_time) 
                VALUES ('".$grade_id."','".$day."','".$teacher_id."','".$start_time."','".$end_time."')";

            if (mysqli_query($conn, $sql)) {
                $msg += 2;
            } else {
                $msg += 3; // Connection problem
            }
        }
    }

       header("Location: view/timetable.php?do=alert_from_insert&msg=$msg&grade=$grade_id");
}
?>
