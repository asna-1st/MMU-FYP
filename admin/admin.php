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
$result = mysqli_query($connect, "SELECT COUNT(*) FROM admin WHERE admin_id NOT IN '$id'");
if($result){
    $total_row = mysqli_fetch_array($result)[0];
    $total_page = ceil($total_row / $rowperpage);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Admin</title>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <link href="../design.css" rel="stylesheet">
        <script>
            function checkPasswordAdd(){
                var pass = document.getElementById("passwordAdd").value;
                var repass = document.getElementById("repasswordAdd").value;
                if(pass != repass){
                    event.preventDefault();
                    $("#passwordAlertAdd").fadeTo(4000, 500).slideUp(500, function(){
                        $("#passwordAlertAdd").slideUp(500);
                    });
                    return false;
                }
            }

            function checkPasswordEdit(){
                var pass = document.getElementById("adminPassEdit").value;
                var repass = document.getElementById("adminRePassEdit").value;

                if(pass != repass){
                    event.preventDefault();
                    $("#passwordAlertEdit").fadeTo(4000, 500).slideUp(500, function(){
                        $("#passwordAlertEdit").slideUp(500);
                    });
                    return false;
                }
            }

            function editAdmin(id){
                document.getElementById("adminEditID").value = id;
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
                            <a class="nav-link" href="hom.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="users.php">Users</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="list.php">Notes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="admin.php">Admin</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="category.php">Category</a>
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
                <div class="col-md-8" style="margin-top: 20px;">
                    <h1>Admin Managment</h1>
                </div>
                <div class="col-md-2 ms-auto py-4">
                    <button class="btn-primary btn" data-bs-toggle="modal" data-bs-target="#addAdmin">Add Admin</button>
                </div>
                <div class="col-md-12 table-responsive-md">
                    <table class="table table-hover table-bordered justify-content-center">
                        <thead>
                            <tr>
                                <th style="width: 4%;" scope="col">No</th>
                                <th style="width: 20%;" scope="col">Username</th>
                                <th style="width: 20%" scope="col">Email</th>
                                <th style="width: 15%;" scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody class="align-middle">
                            <?php
                                $data = mysqli_query($connect, "SELECT * FROM admin WHERE admin_id NOT IN (1)");
                                $num = $start + 1;
                                if($data){
                                    while($row = mysqli_fetch_array($data)){
                                        echo '<tr>';
                                        echo '<th scope="row">'.($num).'</th>';
                                        echo '<td class="textoverflowlist"><span>'.$row["admin_username"].'</span></td>';
                                        echo '<td class="textoverflowlist"><span>'.$row["admin_email"].'</span></td>';
                                        echo '<td><button onclick="editAdmin('.$row["admin_id"].')" class="btn btn-primary gridbutton" data-bs-toggle="modal" data-bs-target="#editAdmin">Edit</a>
                                        <button class="btn btn-danger gridbutton" data-bs-toggle="modal" data-bs-target="#removeAdmin">Remove</a>
                                        </td>';
                                        echo '</tr>';
                                        $num++;
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="editAdmin" data-bs-toggle="modal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="editAdminLabel" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editAdminLabel">Edit User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="editAdminForm" name="editAdminForm" action="admin.php" method="post">
                            <input type="hidden" name="adminEditID" id="adminEditID"/>
                            <div class="modal-body">
                                <div id="passwordAlertEdit" class="alert alert-danger collapse animate fade" role="alert">
                                    Password not match!
                                </div>
                                <div id="emailAlert" class="alert alert-danger collapse animate fade" role="alert">
                                    Password not match!
                                </div>
                                <div class="mb-0">
                                    <label class="col-form-label">Email:</label>
                                    <input type="email" class="form-control" name="adminEmailEdit" id="adminEmailEdit"/>
                                </div>
                                <div class="mb-0">
                                    <label class="col-form-label">Password:</label>
                                    <input type="password" class="form-control" name="adminPassEdit" id="adminPassEdit" />
                                </div>
                                <div class="mb-0">
                                    <label class="col-form-label">Retype Passweord:</label>
                                    <input type="password" class="form-control" name="adminRePassEdit" id="adminRePassEdit" />
                                </div>
                                <input type="hidden" name="userIDEdit" id="userIDEdit" />
                            </div>
                            <div class="modal-footer">
                                <button type="submit" onclick="checkPasswordEdit();" name="btn-save-edit" class="btn btn-success">Yes</button>
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">No</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="addAdmin" data-bs-toggle="modal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="addAdminLabel" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addAdminLabel">Add User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="addAdminForm" name="addAdminForm" action="admin.php" method="post">
                            <div class="modal-body">
                                <div id="passwordAlertAdd" class="alert alert-danger collapse animate fade" role="alert">
                                    Password not match!
                                </div>
                                <div id="emailAlert" class="alert alert-danger collapse animate fade" role="alert">
                                    Password not match!
                                </div>
                                <div class="mb-0">
                                    <label class="col-form-label">Username:</label>
                                    <input type="text" class="form-control" name="usernameAdd" id="usernameAdd" required/>
                                </div>
                                <div class="mb-0">
                                    <label class="col-form-label">Email:</label>
                                    <input type="email" class="form-control" name="adminEmailAdd" id="adminEmailAdd" required/>
                                </div>
                                <div class="mb-0">
                                    <label class="col-form-label">Password:</label>
                                    <input type="password" class="form-control" name="passwordAdd" id="passwordAdd" required/>
                                </div>
                                <div class="mb-0">
                                    <label class="col-form-label">Retype Passweord:</label>
                                    <input type="password" class="form-control" name="repasswordAdd" id="repasswordAdd" required/>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" onclick="checkPasswordAdd();" name="btn-save-add" class="btn btn-success">Yes</button>
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
if(isset($_POST["btn-save-add"])){
    $username = $_POST["usernameAdd"];
    $email = $_POST["adminEmailAdd"];
    $pass = $_POST["passwordAdd"];
    $repass = $_POST["repasswordAdd"];

    if($repass == $pass){
        if(mysqli_query($connect, "INSERT INTO admin (admin_username, admin_password, admin_email) VALUES ('$username', '$pass', '$email')")){
            echo '<script>window.location.href = "admin.php"</script>';
        }
    }
}

if(isset($_POST["btn-save-edit"])){
    $adminID = $_POST["userIDEdit"];
    $email = $_POST["adminEmailEdit"];
    $pass = $_POST["adminPassEdit"];
    $repass = $_POST["adminRePassEdit"];

    if($pass == $repass){
        if(mysqli_query($connect, "UPDATE admin SET admin_password = '$pass', admin_email = '$email' WHERE admin_id = '$adminID'")){
            echo '<script>window.location.href = "admin.php"</script>';
        }
    }
}
?>