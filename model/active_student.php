<?php
include_once('../controller/config.php');

if (isset($_GET["do"]) && ($_GET["do"] == "active_student")) {

    $id = $_GET["id"];
    $page = $_GET["page"];
    $msg = 0; // for alerts

    $sql = "UPDATE student SET _status='' WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        $msg += 1;
    } else {
        $msg += 2;
    }

    $res = array($msg, $page);
    echo json_encode($res);
}
?>
