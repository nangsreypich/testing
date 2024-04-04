<?php
include_once('../controller/config.php');

if (isset($_GET["do"]) && ($_GET["do"] == "update_book")) {

    $id = $_GET['id'];
    $title = $_GET['title'];
    $author = $_GET['author'];
    $publish_date = $_GET['publish_date'];
    $price = $_GET['price'];

    $sql = "SELECT * FROM book WHERE id='$id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $title1 = $row['title'];
        $author1 = $row['author'];
        $publish_date1 = $row['publish_date'];
        $price1 = $row['price'];

        $msg = 0; //for alerts

        if ($title == $title1 && $author == $author1 && $publish_date == $publish_date1 && $price == $price1) {
            $msg = 6; // No changes were made
        } else {
            $update_fields = array();
            if ($title != $title1) $update_fields[] = "title='$title'";
            if ($author != $author1) $update_fields[] = "author='$author'";
            if ($publish_date != $publish_date1) $update_fields[] = "publish_date='$publish_date'";
            if ($price != $price1) $update_fields[] = "price='$price'";

            $set_clause = implode(", ", $update_fields);

            $sql1 = "UPDATE book SET $set_clause WHERE id='$id'";

            if (mysqli_query($conn, $sql1)) {
                $msg = 1; // Record successfully updated
            } else {
                $msg = 5; // Connection problem
            }
        }

        // Fetch the updated record
        $sql2 = "SELECT * FROM book WHERE id='$id'";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result2);

        if ($row2) {
            $res = array($row2['id'], $row2['title'], $row2['author'], $row2['publish_date'], $row2['price'], $msg);
        } else {
            $res = array(null, null, null, null, null, $msg);
        }

        echo json_encode($res);
    } else {
        // Record not found
        echo json_encode(array(null, null, null, null, null, 7));
    }
}
?>
