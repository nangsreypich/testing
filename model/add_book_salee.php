<?php
$msg = 0; // Initialize message variable

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['do']) && $_POST['do'] == 'add_book_salee') {
    // Include database connection
    include_once('controller/config.php');

    // Escape user inputs for security
    $cus_name = mysqli_real_escape_string($conn, $_POST['cus_name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $book_id = mysqli_real_escape_string($conn, $_POST['book_id']);
    $qty = mysqli_real_escape_string($conn, $_POST['qty']);
    $unit_price = mysqli_real_escape_string($conn, $_POST['unit_price']);
    $teacher_price = mysqli_real_escape_string($conn, $_POST['teacher_price']);
    $efk_price = mysqli_real_escape_string($conn, $_POST['efk_price']); // Ensure efk_price is included
    $company = mysqli_real_escape_string($conn, $_POST['company']);
    $paid_date = mysqli_real_escape_string($conn, $_POST['paid_date']);

    // Attempt to insert the data into the database
    $sql = "INSERT INTO book_sale (cus_name, phone, address, book_id, qty, unit_price, teacher_price, efk_price, company, paid_date) 
            VALUES ('$cus_name', '$phone', '$address', '$book_id', '$qty', '$unit_price', '$teacher_price', '$efk_price', '$company', '$paid_date')";

    if (mysqli_query($conn, $sql)) {
        // Success message
        $msg = 2;
    } else {
        // Error message
        $msg = 4;
    }

    // Close database connection
    mysqli_close($conn);

    // Redirect after processing form submission
    header("Location: view/book_salee.php");
} else {
    // Redirect if the form is not submitted
    header("Location: view/book_salee.php");
}
?>
