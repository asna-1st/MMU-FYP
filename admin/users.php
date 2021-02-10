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
$result = mysqli_query($connect, "SELECT COUNT(*) FROM note WHERE user_ID = '$id'");
$total_row = mysqli_fetch_array($result)[0];
$total_page = ceil($total_row / $rowperpage);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset = "UTF-8" />
        <title>Home Page</title>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
        <link href="../design.css" rel="stylesheet">
        <script>
            function getUserInfo(userID, username, userEmail){
                document.getElementById("userID").value = userID.toString();
                document.getElementById("username").value = username;
                document.getElementById("userEmail").value = "";
                document.getElementById("password").value = "";
                document.getElementById("repassword").value = "";
            }

            function checkPassword(){
                var pass = document.getElementById("password").value;
                var repass = document.getElementById("repassword").value;
                if(pass != repass){
                    event.preventDefault();
                    $("#passwordAlert").fadeTo(4000, 500).slideUp(500, function(){
                        $("#passwordAlert").slideUp(500);
                    });
                    return false;
                }
            }

            function checkEmail(){
                var pass = document.getElementById("password").value;
                var repass = document.getElementById("repassword").value;
                if(pass != repass){
                    event.preventDefault();
                    $("#passwordAlert").fadeTo(2000, 500).slideUp(500, function(){
                        $("#passwordAlert").slideUp(500);
                    });
                    return false;
                }
            }

            function removeUser(userID) {
                document.getElementById("remUser").value = userID.toString();
            }
        </script>
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="home.php">Admin Panel</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="home.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Users</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="#">Notes</a>
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
        <div class="container justify-content-center">
            <div class="row">
                <div class="col-md-8" style="margin-top: 20px;">
                    <h1>Users List</h1>
                </div>
                <div class="col-md-12 table-responsive-md py-3">
                    <table class="table table-hover table-bordered justify-content-center">
                        <thead>
                            <tr>
                                <th style="width: 6%;" scope="col">No</th>
                                <th style="width: 30%;" scope="col">Username</th>
                                <th scope="col">Email</th>
                                <th style="width: 21.75%;" scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody class="align-middle">
                            <?php
                                $data = mysqli_query($connect, "SELECT * FROM user ORDER BY CAST(user_username AS UNSIGNED), user_username  ASC LIMIT ".$start.", ".$rowperpage);
                                $num = $start + 1;
                                while($row = mysqli_fetch_array($data)){
                                    echo '<tr>';
                                    echo '<th scope="row">'.($num).'</th>';
                                    echo '<td class="textoverflowlist"><span>'.$row["user_username"].'</span></td>';
                                    echo '<td class="textoverflowlist"><span>'.$row["user_email"].'</span></td>';
                                    echo '<td><a href="#" class="btn btn-primary gridbutton" role="button">Notes</a>
                                    <button class="btn btn-success gridbutton" data-bs-toggle="modal" data-bs-target="#editUser" onclick="getUserInfo('.$row["user_ID"].', `'.$row["user_username"].'`, `'.$row["user_email"].'`);" type="button">Edit</button>
                                    <button class="btn btn-danger gridbutton" data-bs-toggle="modal" data-bs-target="#removeUser" onclick="removeUser('.$row["user_ID"].');">Remove</a>
                                    </td>';
                                    echo '</tr>';
                                    $num++;
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
         <!-- Modal -->
         <div class="modal fade" id="editUser" data-bs-toggle="modal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="editUserLabel" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editUserLabel">Edit User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="editUserForm" name="editUserForm" action="users.php" method="post">
                            <div class="modal-body">
                                <div id="passwordAlert" class="alert alert-danger collapse animate fade" role="alert">
                                    Password not match!
                                </div>
                                <div id="emailAlert" class="alert alert-danger collapse animate fade" role="alert">
                                    Password not match!
                                </div>
                                <div class="mb-0">
                                    <label class="col-form-label">Username:</label>
                                    <input type="text" class="form-control" name="username:" id="username" readonly/>
                                </div>
                                <div class="mb-0">
                                    <label class="col-form-label">Email:</label>
                                    <input type="email" class="form-control" name="userEmail" id="userEmail"/>
                                </div>
                                <div class="mb-0">
                                    <label class="col-form-label">Password:</label>
                                    <input type="password" class="form-control" name="password" id="password" />
                                </div>
                                <div class="mb-0">
                                    <label class="col-form-label">Retype Passweord:</label>
                                    <input type="password" class="form-control" name="repassword" id="repassword" />
                                </div>
                                <input type="hidden" name="userID" id="userID" />
                            </div>
                            <div class="modal-footer">
                                <button type="submit" onclick="checkPassword();" name="btn-save" class="btn btn-success">Yes</button>
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">No</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="removeUser" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="removeUserLabel" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="removeUserLabel">Warning</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure to remove this user?</p>
                        </div>
                        <div class="modal-footer">
                            <form id="removeUserForm" name="removeUserForm" action="users.php" method="post">
                                <button type="submit" name="btnRem" class="btn btn-danger">Yes</button>
                                <input type="hidden" name="remUser" id="remUser" />
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

if(isset($_POST["btn-save"])){
    $email = $_POST["userEmail"];
    $password = $_POST["password"];
    $repassword = $_POST["repassword"];
    $userID = $_POST["userID"];

    if($email != ""){
        if(mysqli_query($connect, "UPDATE user SET user_email = '$email' WHERE user_ID = '$userID'")){
            echo '<script>window.location.href = "users.php"</script>';
        } else {
            echo "Error Occurred!<br>";
            mysqli_error($connect);
        }
    }

    if($password != "" && $repassword != "" && $password == $repassword){
        if(mysqli_query($connect, "UPDATE user SET user_password = '$password' WHERE user_ID = '$userID'")){
            echo '<script>window.location.href = "users.php"</script>';
        } else {
            echo "Error Occurred!<br>";
            mysqli_error($connect);
        }
    }
}

if(isset($_POST["btnRem"])){
    if(mysqli_query($connect, "DELETE FROM user WHERE user_ID = '$userID'")){
        echo '<script>window.location.href = "users.php"</script>';
    } else {
        echo "Error Occurred!<br>";
        mysqli_error($connect);
    }
}

?>