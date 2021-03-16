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
    $orderby = 2;
}


$rowperpage = 10;
$start = ($pageno - 1) * $rowperpage;
$result = mysqli_query($connect, "SELECT COUNT(*) FROM category");
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

            function editAction(noteid) {
                document.getElementById("editVal").value = noteid.toString();
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
                            <a class="nav-link" href="home.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="users.php">Users</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="list.php">Notes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admin.php">Admin</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="category.php">Category</a>
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
                                <li><a class="dropdown-item" href="settings.php">Settings</a></li>
                                <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-md-8" style="margin-top: 20px; margin-bottom: 20px;">
                    <h1>Category</h1>
                </div>
                <div class="col-md-2 ms-auto py-4">
                    <button class="btn-primary btn" data-bs-toggle="modal" data-bs-target="#addC">Add Category</button>
                </div>
                <div class="col-md-12 table-responsive-md">
                    <table class="table table-hover table-bordered justify-content-center">
                        <thead>
                            <tr>
                                <th style="width: 6%;" scope="col">No</th>
                                <th style="width: 40%;" scope="col">Name</th>
                                <th style="width: 15%;" scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody class="align-middle">
                            <?php
                                $data = mysqli_query($connect, "SELECT * FROM category");
                                $num = $start + 1;
                                while($row = mysqli_fetch_array($data)){
                                    echo '<tr>';
                                    echo '<th scope="row">'.($num).'</th>';
                                    echo '<td class="textoverflowlist"><span>'.$row["name"].'</span></td>';
                                    echo '<td><button class="btn btn-primary gridbutton" data-bs-toggle="modal" data-bs-target="#editC" onclick="editAction('.$row["id"].');">Edit</a>
                                    <button class="btn btn-danger gridbutton" data-bs-toggle="modal" data-bs-target="#deleteError" onclick="deleteAction('.$row["id"].');">Delete</a></td>';
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
                            <p>Are you sure to delete this category?</p>
                        </div>
                        <div class="modal-footer">
                            <form id="delForm" name="delForm" action="category.php" method="post">
                                <button type="submit" name="btnDel" class="btn btn-danger">Yes</button>
                                <input type="hidden" name="delVal" id="delVal" />
                            </form>
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="addC" data-bs-toggle="modal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="addCLabel" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addCLabel">Add Category</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="addCForm" name="addCForm" action="category.php" method="post">
                            <div class="modal-body">
                                <div class="mb-0">
                                    <label class="col-form-label">Name:</label>
                                    <input type="text" class="form-control" name="nameC" id="nameC" required/>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="btn-addC" class="btn btn-success">Yes</button>
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">No</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="editC" data-bs-toggle="modal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="editCLabel" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editCLabel">Edit Category</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="editCForm" name="editCForm" action="category.php" method="post">
                            <div class="modal-body">
                                <div class="mb-0">
                                    <label class="col-form-label">Name:</label>
                                    <input type="text" class="form-control" name="enameC" id="enameC" required/>
                                    <input type="hidden" name="editVal" id="editVal" />
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="btn-editC" class="btn btn-success">Yes</button>
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">No</button>
                            </div>
                        </form>
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
if(isset($_POST["btn-addC"])){
    $nameCategory = $_POST["nameC"];
    $result = mysqli_query($connect, "INSERT INTO category (name) VALUES ('$nameCategory')");
    if(!$result){
        echo '<script>alert("Error Occurred")</script>';
    } else {
        echo '<script>window.location.href = "category.php";</script>';
    }

}

if(isset($_POST["btnDel"])){
    $catID = $_POST["delVal"];
    $result = mysqli_query($connect, "DELETE FROM category WHERE id = '$catID'");
    if(!$result){
        echo '<script>alert("Error Occurred")</script>';
    } else {
        echo '<script>window.location.href = "category.php";</script>';
    }
}

if(isset($_POST["btn-editC"])){
    $editCategory = $_POST["enameC"];
    $editID = $_POST["editVal"];
    $result = mysqli_query($connect, "UPDATE category SET name = '$editCategory' WHERE id = '$editID'");
    if(!$result){
        echo '<script>alert("Error Occurred")</script>';
    } else {
        echo '<script>window.location.href = "category.php";</script>';
    }

}
?>