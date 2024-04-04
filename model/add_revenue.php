<?php
include_once('controller/config.php');

if(isset($_POST["do"]) && ($_POST["do"] == "add_revenue")){

    // Revenue Details
    $description_revenue = $_POST["description_revenue"];
    $sub_total_revenue = $_POST["sub_total_revenue"];
    $total_revenue = $_POST["total_revenue"];
    $transaction_revenue = $_POST["transaction_revenue"];

    // Additional transaction details (common for both revenue and expense)
    $reg_date = date("Y-m-d");

    // Insert Revenue
    $sql_revenue = "INSERT INTO revenue (description, sub_total, total, transaction_type,reg_date)
                    VALUES ('$description_revenue', '$sub_total_revenue', '$total_revenue', '$transaction_revenue','$reg_date')";

    if(mysqli_query($conn, $sql_revenue)){
        $msg += 1;  // Successful insertion for revenue
    } else {
        $msg += 2;  // Connection problem for revenue
    }                                                                                                   

    header("Location: view/transaction1.php?do=alert_from_insert&msg=$msg");
}
?>
