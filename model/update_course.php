<?php
include_once('../controller/config.php');

if (isset($_GET["do"]) && ($_GET["do"] == "update_course")) {

    $id = $_GET['id'];
    $name = $_GET['name'];
    $admission_fee = $_GET['admission_fee'];
    $generation = $_GET['generation']; // Added generation field

    $sql = "SELECT * FROM course WHERE name='$name'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    $id1 = $row['id'];
    $name1 = $row['name'];
    $admission_fee1 = $row['admission_fee'];
    $generation1 = $row['generation'];

    $msg = 0; 
    $id2 = "";
    $name2 = "";
    $admission_fee2 = "";
    $generation2 = "";

    if ($generation == $generation1) {
        if ($id == $id1) {
            if ($admission_fee == $admission_fee1) {
                $msg += 5;
                //MSK-000143-U-1 You didn't make any changes.:D
            } else {
                $sql1 = "UPDATE course SET admission_fee='" . $admission_fee . "', generation='" . $generation . "' WHERE id='$id'";

                if (mysqli_query($conn, $sql1)) {
                    $msg += 1;
                    //MSK-000143-U-4 The record has been successfully updated in the database.

                    $sql2 = "SELECT * FROM course WHERE id='$id'";
                    $result2 = mysqli_query($conn, $sql2);
                    $row2 = mysqli_fetch_assoc($result2);

                    $id2 = $row2['id'];
                    $name2 = $row2['name'];
                    $admission_fee2 = $row2['admission_fee'];
                    $generation2 = $row2['generation'];

                } else {
                    $msg += 1;
                    //MSK-000143-U-6 Connection problem
                }

            }
        } else {
            $msg += 4;
            //MSK-000143-U-2 The course is duplicated
        }

    } else {

        $sql1 = "UPDATE course SET name='" . $name . "', admission_fee='" . $admission_fee . "', generation='" . $generation . "' WHERE id='$id'";

        if (mysqli_query($conn, $sql1)) {

            $msg += 1;
            //MSK-000143-U-4 The record has been successfully updated in the database.

            $sql2 = "SELECT * FROM course WHERE id='$id'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);

            $id2 = $row2['id'];
            $name2 = $row2['name'];
            $admission_fee2 = $row2['admission_fee'];
            $generation2 = $row2['generation'];

        } else {
            $msg += 2;
            //MSK-000143-U-6 Connection problem
        }

    }

    $res = array($id2, $name2, $admission_fee2, $generation2, $msg);
    echo json_encode($res);

}
?>
