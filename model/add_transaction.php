<?php
include_once('controller/config.php');

if(isset($_POST["do"]) && ($_POST["do"] == "add_transaction")){

    $description = $_POST["description"];
    $sub_total = $_POST["sub_total"];
    $total = $_POST["total"];
    $transaction_type = $_POST["transaction_type"];  // 'Bank' or 'Cash'
    $type = $_POST["type"];  // 'Revenue' or 'Expense'
    $reg_date = $_POST["reg_date"];
   
    $msg = 0; //for alerts
    
    // Insert transaction record into the appropriate table based on transaction type
    if ($type == 'Revenue') {
        $sql = "INSERT INTO revenue (description, sub_total, total, reg_date, transaction_type)
                VALUES ('".$description."','".$sub_total."','".$total."','".$reg_date."','".$transaction_type."')";
    } elseif ($type == 'Expense') {
        $sql = "INSERT INTO expense (description, sub_total, total, reg_date, transaction_type)
                VALUES ('".$description."','".$sub_total."','".$total."','".$reg_date."','".$transaction_type."')";
    } else {
        // Handle invalid transaction type
        $msg = 3;  // Invalid transaction type
        header("Location: view/transaction.php?do=alert_from_insert&msg=$msg");
        exit();
    }
    
    if(mysqli_query($conn, $sql)){
        $msg = 2;  // The record has been successfully inserted into the database.
    } else {
        $msg = 3;  // Connection problem or other error.
    }

    header("Location: view/transaction.php?do=alert_from_insert&msg=$msg");
}
?>
