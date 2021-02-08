<?php
session_start();
include("./dbconnect.php");

$username = $_SESSION["username"];
$id = $_SESSION["id"];

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
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

$rowperpage = 10;
$start = ($pageno - 1) * $rowperpage;
$result = mysqli_query($connect, "SELECT COUNT(*) FROM note WHERE user_ID = '$id'");
$total_row = mysqli_fetch_array($result)[0];
$total_page = ceil($total_row / $rowperpage);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Note List</title>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <link href="./design.css" rel="stylesheet">
        <script>
            function deleteAction(noteid) {
                document.getElementById("delVal").value = noteid.toString();
            }
        </script>
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Notepad</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="home.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="create.php">Create</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="list.php">Notes</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo $username; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">Settings</a></li>
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container justify-content-center">
            <div class="row">
                <div class="col-md-20" style="margin-top: 20px; margin-bottom: 10px;">
                    <h1>List of Notes</h1>
                </div>
                <div class="col-md-10">
                    <nav style="--bs-breadcrumb-divider: none;" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <label>Sort By: &nbsp;</label>
                            <?php
                                switch($orderby){
                                    case 1:
                                        $sql = "SELECT * FROM note WHERE user_ID = ".$id." ORDER BY CAST(note_title AS UNSIGNED), note_title ASC LIMIT ".$start.", ".$rowperpage;
                                        echo '<li class="breadcrumb-item active">A-Z</li>';
                                        echo '<li class="breadcrumb-item"><a href="?order=2">Newest</a></li>';
                                        echo '<li class="breadcrumb-item"><a href="?porder=3">Oldest</a></li>';
                                        break;
                                    case 2:
                                        $sql = "SELECT * FROM note WHERE user_ID = '$id' ORDER BY note_lastsave DESC LIMIT ".$start.", ".$rowperpage;
                                        echo '<li class="breadcrumb-item active"><a href="?order=1">A-Z</a></li>';
                                        echo '<li class="breadcrumb-item">Newest</li>';
                                        echo '<li class="breadcrumb-item"><a href="?order=3">Oldest</a></li>';
                                        break;
                                    case 3:
                                        $sql = "SELECT * FROM note WHERE user_ID = '$id' ORDER BY note_lastsave ASC LIMIT ".$start.", ".$rowperpage;;
                                        echo '<li class="breadcrumb-item active"><a href="?order=1">A-Z</a></li>';
                                        echo '<li class="breadcrumb-item"><a href="?order=2">Newest</a></li>';
                                        echo '<li class="breadcrumb-item">Oldest</li>';
                                        break;
                                }
                            ?>
                        </ol>
                    </nav>
                </div>
                </div>
                <div class="col-md-20 table-responsive-md">
                    <table class="table table-hover table-bordered justify-content-center">
                        <thead>
                            <tr>
                                <th style="width: 3%;" scope="col">No</th>
                                <th style="width: 30%;" scope="col">Title</th>
                                <th style="width: 8%;" scope="col">Last Saved</th>
                                <th style="width: 10.3%;" scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody class="align-middle">
                            <?php
                                $data = mysqli_query($connect, $sql);
                                $num = $start+1;
                                while($row = mysqli_fetch_array($data)){
                                    echo '<tr>';
                                    echo '<th scope="row">'.($num).'</th>';
                                    echo '<td class="textoverflowlist"><span>'.$row["note_title"].'</span></td>';
                                    echo '<td>'.$row["note_lastsave"].'</td>';
                                    echo '<td><a href="view.php?id='.$row["note_id"].'" class="gridbutton btn btn-success" role="button">View</a>
                                    <a href="edit.php?id='.$row["note_id"].'" role="button" class="gridbutton btn btn-primary">Edit</a>
                                    <button onclick="deleteAction('.$row["note_id"].')" class="gridbutton btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteError">Delete</button></td>';
                                    echo '</tr>';
                                    $num++;
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-10">
                <nav aria-label="Page Navigation">
                    <ul class="pagination justify-content-center" style="padding-bottom: 20px;">
                        <?php
                            for($i=1; $i<=$total_page; $i++){
                                if($pageno == $i){
                                    echo '<li class="page-item active"><a class="page-link" href="?page='.$i.'&order='.$orderby.'">'.$i.'</a></li>';
                                } else {
                                    echo '<li class="page-item"><a class="page-link" href="?page='.$i.'&order='.$orderby.'">'.$i.'</a></li>';
                                }
                            }
                        ?>
                    </ul>
                </nav>
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
                            <p>Are you sure to delete this note?</p>
                        </div>
                        <div class="modal-footer">
                            <form id="delForm" name="delForm" action="list.php" method="post">
                                <button type="submit" name="btnDel" class="btn btn-danger">Yes</button>
                                <input type="hidden" name="delVal" id="delVal" />
                            </form>
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer">
            <div class="container">
                <span class="text-muted">Temp footer for moment</span>
            </div>
        </footer>
    </body>
</html>

<?php
    if(isset($_POST["btnDel"])){
        $delID = $_POST["delVal"];
        $result = mysqli_query($connect, "DELETE FROM note WHERE note_id = '$delID'");
        if($result != TRUE) {
            echo '<script>alert("Having problem with deleting the note!");</script>';
        } else {
            echo '<script>window.location.href = "list.php";</script>';
        }
    }
    mysqli_close($connect);
?>