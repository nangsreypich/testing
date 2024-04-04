<?php
include_once('controller/config.php');

if(isset($_POST["do"]) && ($_POST["do"] == "add_teacher_permission")){
    // Sanitize user inputs to prevent SQL injection
    $index_number = mysqli_real_escape_string($conn, $_POST['index_number']);
    $position = mysqli_real_escape_string($conn, $_POST['position']);
    $reason = mysqli_real_escape_string($conn, $_POST['reason']);
    $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
    $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);

    // Insertion into the database
    $sql = "INSERT INTO teacher_permission(index_number, position, reason, start_date, end_date, _status, approved_by) 
            VALUES ('$index_number', '$position', '$reason', '$start_date', '$end_date', 'pending', '')";
    
    if(mysqli_query($conn, $sql)){
        // Redirect after successful insertion
        header("Location: view/add_permission2.php?do=alert_from_insert&msg=2"); // Success message
        exit();
    } else {
        // Redirect with error message
        header("Location: view/add_permission2.php?do=alert_from_insert&msg=3"); // Connection problem
        exit();
    }
}

?>
