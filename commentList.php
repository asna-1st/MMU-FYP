<?php
include('./dbconnect.php');
$noteID = $_GET['id'];
$sql = "SELECT * FROM comments JOIN user ON comments.user_id = user.user_ID WHERE note_id = '$noteID' ORDER BY parent_id asc, id asc";

$result = mysqli_query($connect, $sql);
$record_set = array();
while ($row = mysqli_fetch_assoc($result)) {
    array_push($record_set, $row);
}
mysqli_free_result($result);

mysqli_close($connect);
echo json_encode($record_set);
?>