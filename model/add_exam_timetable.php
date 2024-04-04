<?php
include_once('controller/config.php');
if (isset($_POST["do"]) && ($_POST["do"] == "add_exam_timetable")) {

	$grade_id = $_POST["grade_id"];
	$exam_id = $_POST["exam_id"];
	$day = $_POST["day"];
	$start_time = $_POST["start_time"];
	$end_time = $_POST["end_time"];

	$msg = 0; // for alerts

	$sql1 = "SELECT * FROM exam_timetable WHERE day=? AND grade_id=? AND exam_id=? AND end_time > ? AND (? <= end_time OR start_time < ?)";
	$stmt1 = mysqli_prepare($conn, $sql1);
	mysqli_stmt_bind_param($stmt1, "siiiii", $day, $grade_id, $exam_id, $start_time, $start_time, $end_time);
	mysqli_stmt_execute($stmt1);
	$result1 = mysqli_stmt_get_result($stmt1);

	if ($result1 === false) {
		// Handle query error
		$msg += 3; // MSK-000143-4 Connection problem.
	} else {
		if (mysqli_num_rows($result1) > 0) {
			$msg += 1;
		} else {
			$sql = "INSERT INTO exam_timetable (grade_id, exam_id, day, start_time, end_time) VALUES ('$grade_id', '$exam_id', '$day', '$start_time', '$end_time')";

			if (mysqli_query($conn, $sql)) {
				$msg += 2;
				// MSK-000143-3 The record has been successfully inserted into the database.
			} else {
				$msg += 3;
				// MSK-000143-4 Connection problem.
			}
		}
	}

	if (isset($_POST["create_by"]) && ($_POST["create_by"] == "Teacher")) {
		header("Location: view/exam_timetable2.php?do=alert_from_insert&msg=$msg&grade=$grade_id&exam=$exam_id");
		exit;
		// MSK-000143-5
	}
}
