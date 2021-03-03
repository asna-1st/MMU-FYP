<?php
include('./dbconnect.php');
$comID = isset($_POST['com_id']) ? $_POST['com_id'] : -1;
$noteID = isset($_POST['note_id']) ? $_POST['note_id'] : "";
$content = isset($_POST['comment']) ? $_POST['comment'] : "";
$userID = isset($_POST['user_id']) ? $_POST['user_id'] : "";

$sql = "INSERT INTO comments (note_id, parent_id, user_id, content, submit_date) VALUES ('$noteID', '$comID', '$userID', '$content', NOW())";

$result = mysqli_query($connect, $sql);

if(!$result){
    $result = mysqli_error($connect);
}

echo $result;
?>