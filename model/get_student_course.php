<?php
include_once('../controller/config.php');
$index=$_GET["index"];

$sql = "SELECT * FROM student_course WHERE index_number=$index";
$result=mysqli_query($conn,$sql);
while($row = mysqli_fetch_assoc($result)){
     $json[] = $row['grade_id'];
}

echo json_encode($json);

?>	