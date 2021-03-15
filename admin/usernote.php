<?php
session_start();
include("../dbconnect.php");

$username = $_SESSION["admin_username"];
$id = $_SESSION["admin_id"];

if(!isset($_SESSION["admin_loggedin"]) || $_SESSION["admin_loggedin"] !== true){
    header("location: index.php");
    exit;
}

if(isset($_GET["page"])){
    $pageno = $_GET["page"];
} else {
    $pageno = 1;
}

if(isset($_GET["order"])){
    $orderby = $_GET["order"];
} else {
    $orderby = 1;
}

if(isset($_GET["id"])){
    $id = $_GET["id"];
} else {
    echo "Error Occurred!";
}



$rowperpage = 10;
$start = ($pageno - 1) * $rowperpage;
$result = mysqli_query($connect, "SELECT COUNT(*) FROM note WHERE user_ID = '$id'");
$total_row = mysqli_fetch_array($result)[0];
$total_page = ceil($total_row / $rowperpage);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Home Page</title>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <link href="../design.css" rel="stylesheet">
        <script>
            function deleteAction(noteid) {
                document.getElementById("delVal").value = noteid.toString();
            }
        </script>
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Admin Panel</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="users.php">Users</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="#">Notes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="ticket.php">Ticket</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo $username; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">Settings</a></li>
                                <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-md-8" style="margin-top: 20px;">
                    <h1>Users Note</h1>
                </div>
                <div class="col-md-8">
                    <nav style="--bs-breadcrumb-divider: none;" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <label>Sort By: &nbsp;</label>
                            <?php
                                switch($orderby){
                                    case 1:
                                        $sql = "SELECT * FROM note WHERE user_ID = '$id' ORDER BY CAST(note_title AS UNSIGNED), note_title ASC LIMIT ".$start.", ".$rowperpage;
                                        echo '<li class="breadcrumb-item active" aria-current="page">A-Z</li>';
                                        echo '<li class="breadcrumb-item"><a href="?order=2&id='.$id.'">Newest</a></li>';
                                        echo '<li class="breadcrumb-item"><a href="?order=3&id='.$id.'">Oldest</a></li>';
                                        break;
                                    case 2:
                                        $sql = "SELECT * FROM note WHERE user_ID = '$id' ORDER BY note_lastsave DESC LIMIT ".$start.", ".$rowperpage;
                                        echo '<li class="breadcrumb-item active" aria-current="page"><a href="?order=1&id='.$id.'">A-Z</a></li>';
                                        echo '<li class="breadcrumb-item">Newest</li>';
                                        echo '<li class="breadcrumb-item"><a href="?order=3&id='.$id.'">Oldest</a></li>';
                                        break;
                                    case 3:
                                        $sql = "SELECT * FROM note WHERE user_ID = '$id' ORDER BY note_lastsave ASC LIMIT ".$start.", ".$rowperpage;;
                                        echo '<li class="breadcrumb-item active" aria-current="page"><a href="?order=1&id='.$id.'">A-Z</a></li>';
                                        echo '<li class="breadcrumb-item"><a href="?order=2&id='.$id.'">Newest</a></li>';
                                        echo '<li class="breadcrumb-item">Oldest</li>';
                                        break;
                                }
                            ?>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-12 table-responsive-md">
                    <table class="table table-hover table-bordered justify-content-center">
                        <thead>
                            <tr>
                                <th style="width: 6%;" scope="col">No</th>
                                <th style="width: 60%;" scope="col">Title</th>
                                <th scope="col">Last Saved</th>
                                <th style="width: 15%;" scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody class="align-middle">
                            <?php
                                $data = mysqli_query($connect, $sql);
                                $num = $start + 1;
                                while($row = mysqli_fetch_array($data)){
                                    echo '<tr>';
                                    echo '<th scope="row">'.($num).'</th>';
                                    echo '<td class="textoverflowlist"><span>'.$row["note_title"].'</span></td>';
                                    echo '<td><span>'.date("j M Y G:i:s a" , strtotime($row["note_lastsave"])).'</span></td>';
                                    echo '<td><a href="../view.php?id='.$row["note_id"].'" target="_blank" class="btn btn-primary gridbutton" role="button">View</a>
                                    <button class="btn btn-danger gridbutton" data-bs-toggle="modal" data-bs-target="#deleteError" onclick="deleteAction('.$row["note_id"].');">Delete</a>
                                    </td>';
                                    echo '</tr>';
                                    $num++;
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-12">
                <nav aria-label="Page Navigation">
                    <ul class="pagination justify-content-center" style="padding-bottom: 20px;">
                        <?php
                            for($i=1; $i<=$total_page; $i++){
                                if($pageno == $i){
                                    echo '<li class="page-item active"><a class="page-link" href="?page='.$i.'&order='.$orderby.'&id='.$id.'">'.$i.'</a></li>';
                                } else {
                                    echo '<li class="page-item"><a class="page-link" href="?page='.$i.'&order='.$orderby.'&id='.$id.'">'.$i.'</a></li>';
                                }
                            }
                        ?>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="deleteError" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="deleteErrorLabel" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteErrorLabel">Warning</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure to delete this note from this user?</p>
                        </div>
                        <div class="modal-footer">
                            <form id="delForm" name="delForm" action="usernote.php" method="post">
                                <button type="submit" name="btnDel" class="btn btn-danger">Yes</button>
                                <input type="hidden" name="delVal" id="delVal" />
                            </form>
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        include("../footer.php")
        ?>
    </body>
</html>

<?php

if(isset($_POST["btnDel"])){
    $userID = $_POST["delVal"];

    if(mysqli_query($connect, "DELETE FROM user WHERE user_ID = '$userID'")){
        echo '<script>window.location.href = "usernote.php?id='.$id.'";</script>';
    } else {
        echo "Error Occurred!";
        mysqli_error($connect);
    }
}

?>