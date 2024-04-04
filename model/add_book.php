<?php
include_once('controller/config.php');

if(isset($_POST["do"]) && ($_POST["do"] == "add_book")) {
    $title = $_POST["title"];
    $author = $_POST["author"];
    $publish_date = $_POST["publish_date"];
    $price = $_POST["price"];
    $msg = 0; //for alerts

    $sql1 = "SELECT * FROM book WHERE title='$title'";
    $result1 = mysqli_query($conn, $sql1);
    $row1 = mysqli_fetch_assoc($result1);

    $title1 = $row1['title'];
    $author1 = $row1['author']; 
    $publish_date1 = $row1['publish_date'];
    $price1 = $row1['price'];

    if ($title == $title1) {

        $msg += 1;
        //MSK-000143-1 The book title is duplicated.

    } else {
        $sql = "INSERT INTO book (title, author, publish_date, price) VALUES ('$title', '$author', '$publish_date', '$price')";
        if (mysqli_query($conn, $sql)) {
            $msg += 2;
            //MSK-000143-3 The record has been successfully inserted into the database.
        } else {
            $msg += 3;
            //MSK-000143-4 Connection problem.
        }
    }    

    header("Location: view/book.php?do=alert_from_insert&msg=$msg");
}
?>
