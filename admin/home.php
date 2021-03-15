<?php
session_start();
include("../dbconnect.php");

$username = $_SESSION["admin_username"];
$id = $_SESSION["admin_id"];

if(!isset($_SESSION["admin_loggedin"]) || $_SESSION["admin_loggedin"] !== true){
    header("location: index.php");
    exit;
}

$userCount = null;
$noteCount = null;

if($result = mysqli_query($connect, "SELECT * FROM user")){
    $userCount = mysqli_num_rows($result);
    mysqli_free_result($result);
} else {
    echo "Error Occurred!<br>";
    mysqli_error($connect);
}

if($result = mysqli_query($connect, "SELECT * FROM note")){
    $noteCount = mysqli_num_rows($result);
    mysqli_free_result($result);
} else {
    echo "Error Occurred!<br>";
    mysqli_error($connect);
}

mysqli_close($connect);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Home Page</title>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <link href="../design.css" rel="stylesheet">
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
                            <a class="nav-link active" aria-current="page" href="hom.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="users.php">Users</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="list.php">Notes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="admin.php">Admin</a>
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
                <div class="col-md-8" style="margin-top: 30px;">
                    <h1>Welcome <?php echo $username ?>!</h1>
                </div>
                <div class="col-sm-10" style="margin-top: 50px;">
                    <h3>Current Statistics</h3>
                </div>
                <div class="col-sm-6 py-2">
                    <div class="card">
                        <div class="card-body">
                            <p class="card-title" style="font-size: 40px; font-weight:bold;">Users</p>
                            <p class="card-text" style="font-size: 60px;"><?php echo $userCount; ?></p>
                            <a href="users.php" role="button" class="btn btn-primary btn-lg float-end">View</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 py-2">
                    <div class="card">
                        <div class="card-body">
                            <p class="card-title" style="font-size: 40px; font-weight:bold;">Notes</p>
                            <p class="card-text" style="font-size: 60px;"><?php echo $noteCount; ?></p>
                            <a href="notes.php" role="button" class="btn btn-primary btn-lg float-end">View</a>
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