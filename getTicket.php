<?php
include("./dbconnect.php");
$ticketID = $_REQUEST["id"];

if($ticketID != ""){
    $result = mysqli_query($connect, "SELECT ticket_content FROM ticket WHERE ticket_id = '$ticketID'");
    if($result){
        while($row = mysqli_fetch_array($result)){
            $content = $row["ticket_content"];
        }
    } else {
        $content = "none";
    }
} else {
    $content = "none";
}

echo $content;
?>