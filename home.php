<?php
session_start();
include("./dbconnect.php");

$username = $_SESSION["username"];
$id = $_SESSION["id"];

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Home Page</title>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <style>
        html {
            position: relative;
            min-height: 100%;
        }
        body {
            margin-bottom: 60px;
        }

        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 60px;
            line-height: 60px;
            color: black;
            background-color: #f5f5f5;
        }

        .textoverflow {
            display: block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        </style>
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Notepad</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="create.php">Create</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="list.php">Notes</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo $username; ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">Settings</a></li>
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
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
            </div>
            <div class="row" style="margin-top: 50px;">
                <div class="col-sm-10" style="margin-bottom: 20px;">
                    <h3>Last Saved Note</h3>
                </div>
<!--                 <div class="col-sm-6 py-2">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">dummy1</h5>
                            <p class="card-text textoverflow">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                            <button type="button" class="btn btn-primary" style="float: right;">View</button>
                        </div>
                    </div>
                </div> -->
                <?php
                    $result = mysqli_query($connect, "SELECT * FROM note WHERE user_ID = '$id' ORDER BY note_lastsave DESC LIMIT 4");
                    if(mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result)){
                            echo '<div class="col-sm-6">';
                            echo '<div class="card mb-4">';
                            echo '<div class="card-body">';
                            echo '<h5 class="card-title textoverflow">'.$row["note_title"].'</h5>';
                            echo '<p class="card-text"><label>Last Saved: '.$row["note_lastsave"].'</label></p>';
                            echo '<a href="view.php?id='.$row["note_id"].'" type="button" class="btn btn-primary" style="float: right;">View</a>';
                            echo '<a href="edit.php?id='.$row["note_id"].'" type="button" class="btn btn-primary" style="float: right; margin-right: 10px;">Edit</a>';
                            echo '</div></div></div>';
                        }
                    } else {
                        echo '<div class="col-sm-6">';
                        echo '<div class="card mb-4">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title textoverflow">No available note currently</h5>';
                        echo '<p class="card-text"><label></label></p>';
                        echo '</div></div></div>';
                    }
                ?>
            </div>
        </div>

        <footer class="footer">
            <div class="container">
                <span class="text-muted">Temp footer for moment</span>
            </div>
        </footer>
    </body>
</html>