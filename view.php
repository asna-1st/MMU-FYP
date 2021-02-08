<?php
    include("./dbconnect.php");
    session_start();

    if(isset($_SESSION["username"]) && isset($_SESSION["id"])){
        $username = $_SESSION["username"];
        $id = $_SESSION["id"];
    }


    if($_GET["id"] != ""){
        $noteID = $_GET["id"];
    }

    $noteTitle = null;
    $noteContent = null;
    $noteLastSaved = null;
    $noteUser = null;

    $result = mysqli_query($connect, "SELECT note_title, note_content, note_lastsave, user.user_username FROM note JOIN user ON note.user_ID = user.user_ID WHERE note.note_id = '$noteID'");
    while($row = mysqli_fetch_array($result)){
        $noteTitle = $row["note_title"];
        $noteContent = $row["note_content"];
        $noteLastSaved = $row["note_lastsave"];
        $noteUser = $row["user_username"];
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>View Note/title>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/js/all.min.js" integrity="sha512-UwcC/iaz5ziHX7V6LjSKaXgCuRRqbTp1QHpbOJ4l1nw2/boCfZ2KlFIqBUA/uRVF0onbREnY9do8rM/uT/ilqw==" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <link href="./notelib.css" rel="stylesheet">
        <script>
            function loadNoteContent() {
                var frameObj = document.getElementById("richTextArea");
                frameObj.contentWindow.document.body.innerHTML = '<?php echo $noteContent ?>';
                // document.getElementById("richTextArea").src = "data:text/html;charset=UTF-8," + '<?php echo $noteContent ?>';
            }

            function copyLink() {
                var copyText = document.getElementById("shareLink");
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                document.execCommand("copy");
            }
        </script>
    </head>
    <body onload="loadNoteContent();">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="home.php">Notepad</a>
                <?php
                    if($id != ""){
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
                        </ul>
                        <ul class="navbar-nav ms-auto mb-lg-0">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    '.$username.
                                '</a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="#">Settings</a></li>
                                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>';
                    }
                ?>
            </div>
        </nav>
        <div class="container"> 
            <div class="row">
                <div class="col-md-auto" style="margin-top: 20px; margin-bottom: 5px;">
                    <p>Title: <?php echo $noteTitle; ?></p>
                    <?php
                        if(!isset($id)) {
                            echo '<p>Created By: '.$noteUser.'</p>';
                        }
                    ?>
                    <p>Last Saved: <?php echo $noteLastSaved; ?></p>
                    <?php
                        if(isset($id)) {
                            echo '<div class="input-group">
                            <label class="input-group-text" for="shareLink">Share Link</label>
                            <input class="form-control" type="text" size="50" id="shareLink" value="http://localhost/fyp/view.php?id='.$noteID.'" readonly>
                            <button onclick="copyLink();" class="btn btn-primary" type="button" title="Copy Link"><i class="fas fa-copy"></i></button>
                            </div>';
                        }
                        mysqli_close($connect);
                    ?>
                </div>
                <div class="col-md-auto" style="padding-bottom: 10px; height: calc(100vh - 280px); width: 100%; overflow-inline: hidden;">
                    <iframe id="richTextArea" name="richTextArea"></iframe>
                </div>
            </div>
        </div>
        <footer class="footer mt-auto clearfix bg-light">
            <div class="container">
                <span class="text-muted">Temp footer for moment</span>
            </div>
        </footer>
    </body>
</html>