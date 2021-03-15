<?php
session_start();
include("./dbconnect.php");

$username = null;
$id = null;

if(isset($_SESSION["username"]) && isset($_SESSION["id"])){
    $username = $_SESSION["username"];
    $id = $_SESSION["id"];
}

if(isset($_GET["id"])){
    $userID = $_GET["id"];
    $result = mysqli_query($connect, "SELECT * FROM user WHERE user_ID = '$userID'");

    while($row = mysqli_fetch_array($result)){
        $userN = $row["user_username"];
        $userI = $row["image"];
    }
} else {
    header("location: index.php");
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>User</title>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <link href="./design.css" rel="stylesheet">
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Notepad</a>
                <?php
                    if($id != null){
                        echo '<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="home.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#">Create</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="list.php">Notes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="public.php">Public Note</a>
                            </li>
                        </ul>
                        <ul class="navbar-nav ms-auto mb-lg-0">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    '.$username.
                                '</a>
                                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="settings.php">Settings</a></li>
                                    <li><a class="dropdown-item" href="ticket.php">Ticket</a></li>
                                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>';
                    } else {
                        echo '<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link" href="index.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="public.php">Public Note</a>
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
                    </div>';
                    }
                ?>
            </div>
        </nav>
        <div class="container">
            <div class="row h-100" style="margin-top: 50px;">
                <div class="col-sm-10" style="margin-bottom: 15px;">
                    <div class="d-flex align-items-center">
                        <img src="<?php echo $userI; ?>" style="margin-right:15px;" height="100" class="rounded-circle float-start mr-2">
                        <h2><?php echo $userN; ?> Profile</h2>
                    </div>
                    <div class="col-auto" style="margin-top: 30px;">
                        <h3>Latest Note</h3>
                    </div>
                </div>
                <?php
                    $result = mysqli_query($connect, "SELECT * FROM note WHERE user_ID = '$userID' ORDER BY note_lastsave DESC LIMIT 4");
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
                    mysqli_close($connect);
                ?>
            </div>
        </div>

        <?php
        include("./footer.php")
        ?>
    </body>
</html>