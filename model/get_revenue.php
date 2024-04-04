<?php
include_once('controller/config.php');
$SearchTerm = '';

if (isset($_POST['submitin'])) {
   // Get Report Revenue History
$GetRevenueHistory = "SELECT * FROM revenue
    WHERE UserId = $UserId
    ORDER BY reg_date DESC";
$RevenueHistory = mysqli_query($mysqli, $GetRevenueHistory);

// Separate revenue into Primary and Other categories
$primaryRevenueSubtotal = 0;
$otherRevenueSubtotal = 0;

while ($row = mysqli_fetch_assoc($RevenueHistory)) {
    if (stripos($row['description'], 'Tuition Fee') !== false || stripos($row['description'], 'Books') !== false) {
        // Primary Revenue
        $primaryRevenueSubtotal += $row['total'];
    } else {
        // Other Revenue
        $otherRevenueSubtotal += $row['total'];
    }
}

// Get cash on the previous day
$GetCashPreviousDay = "SELECT total FROM revenue WHERE UserId = $UserId AND reg_date < CURRENT_DATE() ORDER BY reg_date DESC LIMIT 1";
$GetCashPreviousDayResult = mysqli_query($mysqli, $GetCashPreviousDay);
$cashPreviousDay = mysqli_fetch_assoc($GetCashPreviousDayResult)['total'];

// Get total revenue
$totalRevenue = $primaryRevenueSubtotal + $otherRevenueSubtotal;

// Get all by month Revenue
$GetAllRevenueDate = "SELECT SUM(total) AS Amount FROM revenue WHERE UserId = $UserId AND MONTH(reg_date) = MONTH(CURRENT_DATE())";
$GetARevenueDate = mysqli_query($mysqli, $GetAllRevenueDate);
$RevenueColDate = mysqli_fetch_assoc($GetARevenueDate);

// Get all by today Revenue
$GetAllRevenueDateToday = "SELECT SUM(total) AS Amount FROM revenue WHERE UserId = $UserId AND reg_date = CURRENT_DATE()";
$GetARevenueDateToday = mysqli_query($mysqli, $GetAllRevenueDateToday);
$RevenueColDateToday = mysqli_fetch_assoc($GetARevenueDateToday);

// Search Revenue
if (isset($_POST['searchbtn'])) {
    $SearchTerm = $_POST['search'];
    $GetRevenueHistory = "SELECT * FROM revenue
        WHERE (description LIKE '%$SearchTerm%')
        AND UserId = $UserId
        ORDER BY reg_date DESC";
    $RevenueHistory = mysqli_query($mysqli, $GetRevenueHistory);
}
}

?>
