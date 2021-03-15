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

$rowperpage = 10;
$start = ($pageno - 1) * $rowperpage;
$result = mysqli_query($connect, "SELECT COUNT(*) FROM ticket");
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
            function getTicket(id){
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function(){
                    if(this.readyState == 4 && this.status == 200){
                        document.getElementById("contentTicket").innerHTML = this.responseText;
                    }
                };
                document.getElementById("ticID").value = id;
                xmlhttp.open("GET", "../getTicket.php?id=" + id, true);
                xmlhttp.send();
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
                            <a class="nav-link active" aria-current="page" href="#">Ticket</a>
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
                <div class="col-md-8" style="margin-top: 20px; margin-bottom: 10px;">
                    <h1>Ticket</h1>
                </div>
                <div class="col-md-12 table-responsive-md">
                    <table class="table table-hover table-bordered justify-content-center">
                        <thead>
                            <tr>
                                <th style="width: 5%;" scope="col">Ticket ID</th>
                                <th style="width: 18%;" scope="col">Title</th>
                                <th style="width: 10%;" scope="col">User</th>
                                <th style="width: 10%;" scope="col">Created On</th>
                                <th style="width: 6%;" scope="col">Status</th>
                                <th style="width: 0.4%;" scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody class="align-middle">
                            <?php
                                $data = mysqli_query($connect, "SELECT * FROM ticket JOIN user WHERE ticket.user_id = user.user_ID ORDER BY ticket_date DESC LIMIT ".$start.", ".$rowperpage);
                                while($row = mysqli_fetch_array($data)){
                                    echo '<tr>';
                                    echo '<td><span>'.$row["ticket_id"].'</span></td>';
                                    echo '<td class="textoverflowlist"><span>'.$row["ticket_title"].'</span></td>';
                                    echo '<td class="textoverflowlist"><span>'.$row["user_username"].'</span></td>';
                                    echo '<td>'.$row["ticket_date"].'</td>';
                                    if($row["solve"] == 0){
                                        $status = "Unsolved";
                                    } else {
                                        $status = "Solved";
                                    }
                                    echo '<td>'.$status.'</td>';
                                    echo '<td><button onclick="getTicket('.$row["ticket_id"].');" class="gridbutton btn btn-primary" data-bs-toggle="modal" data-bs-target="#readProblem">Edit</button></td>';
                                    echo '</tr>';
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
                                    echo '<li class="page-item active"><a class="page-link" href="?page='.$i.'">'.$i.'</a></li>';
                                } else {
                                    echo '<li class="page-item"><a class="page-link" href="?page='.$i.'">'.$i.'</a></li>';
                                }
                            }
                        ?>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="readProblem" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="readProblemLabel" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="readProblemLabel">Problem</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" name="ticForm" action="ticket.php">
                            <div class="modal-body">
                                <div class="mb-0">
                                    <label class="col-form-label">Problem:</label>
                                    <p id="contentTicket">Are you sure to delete this note?</p>
                                </div>
                                <div class="mb-0">
                                    <div class="input-group">
                                        <label class="input-group-text" for="group1">Status</label>
                                        <input type="hidden" name="ticID" id="ticID"/>
                                        <select class="form-select" id="statusUp" name="statusUp">
                                            <option value="0">Unsolved</option>
                                            <option value="1">Solved</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" name="btn-Up">Update</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
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
if(isset($_POST["btn-Up"])){
    $ticketID = $_POST["ticID"];
    $ticStatus = $_POST["statusUp"];
    echo $ticketID." ".$ticStatus;
    if(mysqli_query($connect, "UPDATE ticket SET solve = '$ticStatus' WHERE ticket_id = '$ticketID'")){
        echo '<script>window.location.href = "ticket.php";</script>';
    } else {
        mysqli_error($connect);
        echo "Error Occurred!";
    }
}
?>