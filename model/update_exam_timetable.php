<?php
include_once('controller/config.php');

if (isset($_POST["do"]) && ($_POST["do"] == "update_exam_timetable")) {
    $id = $_POST["id"];
    $grade_id = $_POST["grade_id"];
    $exam = $_POST["exam"];
    $day = $_POST["day"];
    $start_time = $_POST["start_time"];
    $end_time = $_POST["end_time"];

    $msg = 0; // for alerts

    $sql1 = "SELECT * FROM exam_timetable WHERE day='$day' and start_time=$start_time and end_time=$end_time";
    $result1 = mysqli_query($conn, $sql1);

    if (!$result1) {
        die("Query failed: " . mysqli_error($conn));
    }

    $row1 = mysqli_fetch_assoc($result1);
    $id1 = $row1['id'] ?? '';
    $grade_id1 = $row1['grade_id'] ?? '';
    $end_time1 = $row1['end_time'] ?? '';

    if ($id == $id1) {
        if ($end_time == $end_time1) {
            if ($grade_id != $grade_id1) {
                $sql = "UPDATE exam_timetable SET grade_id='$grade_id' WHERE id='$id'";

                if (mysqli_query($conn, $sql)) {
                    $msg += 1;
                } else {
                    $msg += 2;
                }
            } else {
                $msg += 3;
            }
        } else {
            $sql2 = "SELECT * FROM exam_timetable WHERE day='$day' and end_time > $start_time and (start_time <= $start_time or start_time<'$end_time') and id!= '$id'";
            $result2 = mysqli_query($conn, $sql2);

            if (!$result2) {
                die("Query failed: " . mysqli_error($conn));
            }

            if (mysqli_num_rows($result2) > 0) {
                $msg += 4;
            } else {
                $sql = "UPDATE exam_timetable SET grade_id='$grade_id', end_time='$end_time' WHERE id='$id'";

                if (mysqli_query($conn, $sql)) {
                    $msg += 1;
                } else {
                    $msg += 2;
                }
            }
        }
    } else {
        $sql2 = "SELECT * FROM exam_timetable WHERE day='$day'  and end_time > $start_time and (start_time <= $start_time or start_time<$end_time) and id!=$id";
        $result2 = mysqli_query($conn, $sql2);

        if (!$result2) {
            die("Query failed: " . mysqli_error($conn));
        }

        if (mysqli_num_rows($result2) > 0) {
            $msg += 4;
        } else {
            $sql = "UPDATE exam_timetable SET day='$day', grade_id='$grade_id', start_time='$start_time', end_time='$end_time' WHERE id='$id'";

            if (mysqli_query($conn, $sql)) {
                $msg += 1;
            } else {
                $msg += 2;
            }
        }
    }

    if (isset($_POST["create_by"]) && ($_POST["create_by"] == "Admin")) {
        header("Location: view/exam_timetable.php?do=alert_from_update&msg=$msg&grade=$grade&exam=$exam");
    }

    if (isset($_POST["create_by"]) && ($_POST["create_by"] == "Teacher")) {
        header("Location: view/exam_timetable2.php?do=alert_from_update&msg=$msg&grade=$grade&exam=$exam");
    }
}
?>
