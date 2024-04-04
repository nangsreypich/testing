<?php
include_once('controller/config.php');

if(isset($_POST["do"]) && ($_POST["do"] == "add_teacher_financial")){

    $description = $_POST["description"];
    $qty = $_POST["qty"];
    $sub_total = $_POST["sub_total"];
    $total = $_POST["total"];
    $type = $_POST["type"];  // 'Revenue' or 'Expense'
    $reg_date = $_POST["reg_date"];
   
    $msg = 0; //for alerts
    
    // Insert transaction record into the appropriate table based on transaction type
    if ($type == 'Revenue') {
        $sql = "INSERT INTO teacher_revenue (description, qty, sub_total, total, reg_date)
                VALUES ('".$description."', '".$qty."', '".$sub_total."','".$total."','".$reg_date."')";
    }elseif ($type == 'Expense') {
        $sql = "INSERT INTO teacher_expense (description, sub_total, total, reg_date)
                VALUES ('".$description."','".$sub_total."','".$total."','".$reg_date."')";
    } else {
        // Handle invalid transaction type
        $msg = 3;  // Invalid transaction type
        header("Location: view/daily_teacher_financial.php?do=alert_from_insert&msg=$msg");
        exit();
    }
    
    if(mysqli_query($conn, $sql)){
        $msg = 2;  // The record has been successfully inserted into the database.
    } else {
        $msg = 3;  // Connection problem or other error.
    }

    header("Location: view/daily_teacher_financial.php?do=alert_from_insert&msg=$msg");
}
?>
