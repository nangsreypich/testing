<?php
include_once('controller/config.php');

if(isset($_POST["do"]) && ($_POST["do"] == "add_course")) {
    $name = $_POST["name"];
    $admission_fee = $_POST["admission_fee"];
    $generation = $_POST["generation"];
    $msg = 0;

    $sql1 = "SELECT * FROM course WHERE name='$name' AND generation='$generation'";
    $result1 = mysqli_query($conn, $sql1);
    $num_rows = mysqli_num_rows($result1);

    if ($num_rows > 0) {
        $msg += 1;
        //MSK-000143-1 The course with the same name and generation already exists.
    } else {
        $sql = "INSERT INTO course (name, admission_fee, generation) VALUES ('$name', '$admission_fee', '$generation')";
        if (mysqli_query($conn, $sql)) {
            $msg += 2;
            //MSK-000143-3 The record has been successfully inserted into the database.
        } else {
            $msg += 3;
            //MSK-000143-4 Connection problem.
        }
    }

    header("Location: view/course.php?do=alert_from_insert&msg=$msg");
}
?>
