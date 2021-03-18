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

$rowperpage = 10;
$start = ($pageno - 1) * $rowperpage;
$result = mysqli_query($connect, "SELECT COUNT(*) FROM ticket WHERE user_ID = '$id'");
$total_row = mysqli_fetch_array($result)[0];
$total_page = ceil($total_row / $rowperpage);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Ticket</title>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <link href="./design.css" rel="stylesheet">
        <script>
            function getTicket(id){
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function(){
                    if(this.readyState == 4 && this.status == 200){
                        document.getElementById("contentTicket").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "getTicket.php?id=" + id, true);
                xmlhttp.send();
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
                            <a class="nav-link" href="home.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="create.php">Create</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="list.php">Notes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="public.php">Public Note</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo $username; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="settings.php">Settings</a></li>
                                <li><a class="dropdown-item" href="#">Ticket</a></li>
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container justify-content-center">
            <div class="row">
                <div class="col-md-8" style="margin-top: 20px; margin-bottom: 10px;">
                    <h1>Ticket</h1>
                </div>
                <div class="col-md-2 ms-auto py-4">
                    <button class="btn-danger btn" data-bs-toggle="modal" data-bs-target="#subTicket">Submit Ticket</button>
                </div>
                <div class="col-md-12 table-responsive-md">
                    <table class="table table-hover table-bordered justify-content-center">
                        <thead>
                            <tr>
                                <th style="width: 5%;" scope="col">Ticket ID</th>
                                <th style="width: 20%;" scope="col">Title</th>
                                <th style="width: 10%;" scope="col">Created On</th>
                                <th style="width: 6%;" scope="col">Status</th>
                                <th style="width: 0.4%;" scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody class="align-middle">
                            <?php
                                $data = mysqli_query($connect, "SELECT * FROM ticket WHERE user_id = '$id' ORDER BY ticket_date");
                                while($row = mysqli_fetch_array($data)){
                                    echo '<tr>';
                                    echo '<td><span>'.$row["ticket_id"].'</span></td>';
                                    echo '<td class="textoverflowlist"><span>'.$row["ticket_title"].'</span></td>';
                                    echo '<td>'.$row["ticket_date"].'</td>';
                                    if($row["solve"] == 0){
                                        $status = "Unsolved";
                                    } else {
                                        $status = "Solved";
                                    }
                                    echo '<td>'.$status.'</td>';
                                    echo '<td><button onclick="getTicket('.$row["ticket_id"].');" class="gridbutton btn btn-primary" data-bs-toggle="modal" data-bs-target="#readProblem">Problem</button></td>';
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
            <!-- Modal -->
            <div class="modal fade" id="readProblem" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="readProblemLabel" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="readProblemLabel">Problem</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p id="contentTicket"></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="subTicket" data-bs-toggle="modal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="subTicketLabel" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="subTicketLabel">Submit Ticket</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="subTicketForm" name="subTicketForm" action="ticket.php" method="post">
                            <div class="modal-body">
                                <div class="mb-0">
                                    <label class="col-form-label">Title:</label>
                                    <input type="text" class="form-control" name="ticTitle" id="ticTitle" required/>
                                </div>
                                <div class="mb-0">
                                    <label class="col-form-label">Problem:</label>
                                    <textarea class="form-control" name="ticProb" id="ticProb" rows="5" required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit"  name="btn-ticket-add" class="btn btn-success">Submit</button>
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        include("./footer.php")
        ?>
    </body>
</html>

<?php
if(isset($_POST["btn-ticket-add"])){
    $title = $_POST["ticTitle"];
    $procContent = $_POST["ticProb"];
    if(mysqli_query($connect, "INSERT INTO ticket (ticket_title, ticket_content, ticket_date, user_id) VALUES ('$title', '$procContent', CURRENT_TIMESTAMP, '$id')")){
        echo '<script>window.location.href = "ticket.php"</script>';
    }
}
?>