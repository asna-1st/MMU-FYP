<?php
session_start();
include("./dbconnect.php");

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
$result = mysqli_query($connect, "SELECT COUNT(*) FROM note");
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
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="create.php">Public Note</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto mb-lg-0">
                    <li class="nav-item">
                            <a class="nav-link" href="signin.php">Sign In</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">Register</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container justify-content-center">
            <div class="row">
                <div class="col-md-8" style="margin-top: 20px; margin-bottom: 10px;">
                    <h1>Public Notes</h1>
                </div>
                <div class="col-md-12">
                    <nav style="--bs-breadcrumb-divider: none;" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <label>Sort By: &nbsp;</label>
                            <?php
                                switch($orderby){
                                    case 1:
                                        $sql = "SELECT * FROM note JOIN category JOIN user WHERE note.user_ID = user.user_ID AND note.category_ID = category.id ORDER BY CAST(note_title AS UNSIGNED), note_title ASC LIMIT ".$start.", ".$rowperpage;
                                        echo '<li class="breadcrumb-item active" aria-current="page">A-Z</li>';
                                        echo '<li class="breadcrumb-item"><a href="?order=2">Newest</a></li>';
                                        echo '<li class="breadcrumb-item"><a href="?porder=3">Oldest</a></li>';
                                        break;
                                    case 2:
                                        $sql = "SELECT * FROM note JOIN category JOIN user WHERE note.user_ID = user.user_ID AND note.category_ID = category.id ORDER BY note_lastsave DESC LIMIT ".$start.", ".$rowperpage;
                                        echo '<li class="breadcrumb-item active" aria-current="page"><a href="?order=1">A-Z</a></li>';
                                        echo '<li class="breadcrumb-item">Newest</li>';
                                        echo '<li class="breadcrumb-item"><a href="?order=3">Oldest</a></li>';
                                        break;
                                    case 3:
                                        $sql = "SELECT * FROM note JOIN category JOIN user WHERE note.user_ID = user.user_ID AND note.category_ID = category.id ORDER BY note_lastsave ASC LIMIT ".$start.", ".$rowperpage;;
                                        echo '<li class="breadcrumb-item active" aria-current="page"><a href="?order=1">A-Z</a></li>';
                                        echo '<li class="breadcrumb-item"><a href="?order=2">Newest</a></li>';
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
                                <th style="width: 3%;" scope="col">No</th>
                                <th style="width: 20%;" scope="col">Title</th>
                                <th style="width: 10%;" scope="col">Category</th>
                                <th style="width: 8%;" scope="col">User</th>
                                <th style="width: 8%;" scope="col">Last Saved</th>
                                <th style="width: 0.1%;" scope="col">Action</th>
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
                                    echo '<td class="textoverflowlist"><span>'.$row["name"].'</span></td>';
                                    echo '<td class="textoverflowlist"><span>'.$row["user_username"].'</span></td>';
                                    echo '<td>'.$row["note_lastsave"].'</td>';
                                    echo '<td><a href="view.php?id='.$row["note_id"].'" class="gridbutton btn btn-success" role="button">View</a></td>';
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