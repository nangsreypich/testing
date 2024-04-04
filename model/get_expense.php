<?php
include_once('controller/config.php');
$SearchTerm = '';

if (isset($_POST['submitin'])) {
   // Get Report Expense History
$GetExpenseHistory = "SELECT * FROM expense
    WHERE UserId = $UserId
    ORDER BY reg_date DESC";
$ExpenseHistory = mysqli_query($mysqli, $GetExpenseHistory);

// Separate expense into Primary and Other categories
$primaryExpenseSubtotal = 0;
$otherExpenseSubtotal = 0;

while ($row = mysqli_fetch_assoc($ExpenseHistory)) {
    if (stripos($row['description'], 'Tuition Fee') !== false || stripos($row['description'], 'Books') !== false) {
        // Primary Expense
        $primaryExpenseSubtotal += $row['total'];
    } else {
        // Other Expense
        $otherExpenseSubtotal += $row['total'];
    }
}

// Get cash on the previous day
$GetCashPreviousDay = "SELECT total FROM expense WHERE UserId = $UserId AND reg_date < CURRENT_DATE() ORDER BY reg_date DESC LIMIT 1";
$GetCashPreviousDayResult = mysqli_query($mysqli, $GetCashPreviousDay);
$cashPreviousDay = mysqli_fetch_assoc($GetCashPreviousDayResult)['total'];

// Get total expense
$totalExpense = $primaryExpenseSubtotal + $otherExpenseSubtotal;

// Get all by month Expense
$GetAllExpenseDate = "SELECT SUM(total) AS Amount FROM expense WHERE UserId = $UserId AND MONTH(reg_date) = MONTH(CURRENT_DATE())";
$GetAExpenseDate = mysqli_query($mysqli, $GetAllExpenseDate);
$ExpenseColDate = mysqli_fetch_assoc($GetAExpenseDate);

// Get all by today Expense
$GetAllExpenseDateToday = "SELECT SUM(total) AS Amount FROM expense WHERE UserId = $UserId AND reg_date = CURRENT_DATE()";
$GetAExpenseDateToday = mysqli_query($mysqli, $GetAllExpenseDateToday);
$ExpenseColDateToday = mysqli_fetch_assoc($GetAExpenseDateToday);

// Search Expense
if (isset($_POST['searchbtn'])) {
    $SearchTerm = $_POST['search'];
    $GetExpenseHistory = "SELECT * FROM expense
        WHERE (description LIKE '%$SearchTerm%')
        AND UserId = $UserId
        ORDER BY reg_date DESC";
    $ExpenseHistory = mysqli_query($mysqli, $GetExpenseHistory);
}
}

?>
