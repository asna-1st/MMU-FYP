<?php
    include('./dbconnect.php');
    session_start();

    $username = $_SESSION["username"];
    $id = $_SESSION["id"];
    
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: index.php");
        exit;
    }

    if (!isset($_GET["id"]) || $_GET["id"] == "0" && !isset($_POST["btn-save"])) {
        echo '<script>window.location.href = "home.php"</script>';
    }

    if($_GET["id"] != "" || $_GET["id"] > 0){
        $noteID = $_GET["id"];
    } 

    $noteTitle = null;
    $noteContent = null;
    $noteUserID = null;

    $result = mysqli_query($connect, "SELECT note.note_title, note.note_content, user.user_ID FROM note JOIN user ON note.user_ID = user.user_ID WHERE note.note_id = '$noteID'");
    while($row = mysqli_fetch_array($result)) {
        $noteTitle = $row["note_title"];
        $noteContent = $row["note_content"];
        $noteUserID = $row["user_ID"];
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Home Page</title>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/js/all.min.js" integrity="sha512-UwcC/iaz5ziHX7V6LjSKaXgCuRRqbTp1QHpbOJ4l1nw2/boCfZ2KlFIqBUA/uRVF0onbREnY9do8rM/uT/ilqw==" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="./notelib.js"></script>
        <link href="./notelib.css" rel="stylesheet">
        <script>
            function loadNoteContent() {
                var frameObj = document.getElementById("richTextArea");
                frameObj.contentWindow.document.body.innerHTML = '<?php echo $noteContent ?>';
                editContent = '<?php echo $noteContent ?>';
                checkEditedContent = true;
                // document.getElementById("richTextArea").src = "data:text/html;charset=UTF-8," + '<?php echo $noteContent ?>';
            }
        </script>
    </head>

    <body onload="enableEdit(); loadNoteContent();">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="home.php">Notepad</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="home.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="#">Create</a>
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

        <div class="container" style="padding-top: 20px;">
            <form name="content-form" method="POST" action="edit.php">
                <div class="row">
                    <div class="col-md-auto">
                        <div class="input-group" style="margin-bottom: 10px;">
                            <input type="text" value="<?php echo $noteTitle; ?>" size="100" name="titleText" id="titleText" placeholder="Title" class="form-control"/>
                            <button onclick="getContent(); emptyTitle(event);" style="font-size: 0.8em;" type="submit" name="btn-save" id="titleText" class="btn btn-success">Save</button>
                        </div>
                    </div>
                    <div class="tool col-md-auto">
                        <div class="btn-toolbar" role="toolbar">
                            <div class="btn-group me-2" role="group">
                                <button type="button" class="btn btn-light" onclick="execCmd('justifyLeft');"><i class="fas fa-align-left"></i></button>
                                <button type="button" class="btn btn-light" onclick="execCmd('justifyCenter');"><i class="fas fa-align-center"></i></button>
                                <button type="button" class="btn btn-light" onclick="execCmd('justifyRight');"><i class="fas fa-align-right"></i></button>
                                <button type="button" class="btn btn-light" onclick="execCmd('justifyCenter');"><i class="fas fa-align-justify"></i></button>
                            </div>
                            <div class="btn-group me-2" role="group">
                                <button type="button" class="btn btn-light" onclick="execCmd('bold');"><i class="fas fa-bold"></i></button>
                                <button type="button" class="btn btn-light" onclick="execCmd('italic');"><i class="fas fa-italic"></i></button>
                                <button type="button" class="btn btn-light" onclick="execCmd('underline');"><i class="fas fa-underline"></i></button>
                                <button type="button" class="btn btn-light" onclick="execCmd('strikeThrough');"><i class="fas fa-strikethrough"></i></button>
                            </div>
                            <div class="btn-group me-2" role="group">
                                <button type="button" class="btn btn-light" onclick="execCmd('cut');"><i class="fas fa-cut"></i></button>
                                <button type="button" class="btn btn-light" onclick="execCmd('copy');"><i class="fas fa-copy"></i></button>
                            </div>
                            <div class="btn-group me-2" role="group">
                                <button type="button" class="btn btn-light" onclick="execCmd('indent');"><i class="fas fa-indent"></i></button>
                                <button type="button" class="btn btn-light" onclick="execCmd('outdent');"><i class="fa fa-outdent"></i></button>
                            </div>
                            <div class="btn-group me-2" role="group">
                                <button type="button" class="btn btn-light" onclick="execCmd('subscript');"><i class="fas fa-subscript"></i></button>
                                <button type="button" class="btn btn-light" onclick="execCmd('superscript');"><i class="fas fa-superscript"></i></button>
                            </div>
                            <div class="btn-group me-2" role="group">
                                <button type="button" class="btn btn-light" onclick="execCmd('undo');"><i class="fas fa-undo"></i></button>
                                <button type="button" class="btn btn-light" onclick="execCmd('redo');"><i class="fas fa-redo"></i></button>
                            </div>
                            <div class="btn-group me-2" role="group">
                                <button type="button" class="btn btn-light" onclick="execCmd('insertUnorderedList');"><i class="fas fa-list-ul"></i></button>
                                <button type="button" class="btn btn-light" onclick="execCmd('insertOrderedList');"><i class="fas fa-list-ol"></i></button>
                                <button type="button" class="btn btn-light" onclick="execCmd('insertParagraph');"><i class="fas fa-paragraph"></i></button>
                                <button type="button" class="btn btn-light" onclick="execCmd('insertHorizontalRule');"><i class="fas fa-arrows-alt-h"></i></button>
                            </div>
                            <div class="btn-group me-2" role="group">   
                                <button type="button" class="btn btn-light" onclick="insertLink(prompt('Enter URL'));"><i class="fas fa-link"></i></button>
                                <button type="button" class="btn btn-light" onclick="execCmd('unlink');"><i class="fas fa-unlink"></i></button>
                                <button type="button" class="btn btn-light" onclick="execCommandArg('insertImage', prompt('Enter image URL'));"><i class="fas fa-file-image"></i></button>
                            </div>
                            <div class="input-group me-2">
                                <label class="input-group-text" for="fontSizeSelect">Heading Size</label>
                                <select class="form-select" id="fontSizeSelect" onchange="execCommandArg('formatBlock', this.value);">
                                    <option value="p" selected>None</option>
                                    <option value="h1">H1</option>
                                    <option value="h2">H2</option>
                                    <option value="h3">H3</option>
                                    <option value="h4">H4</option>
                                    <option value="h5">H5</option>
                                    <option value="h6">H6</option>
                                </select>
                            </div>
                            <div class="input-group me-2">
                                <label class="input-group-text" for="fontTypeSelect">Font</label>
                                <select class="form-select" id="fontTypeSelect" onchange="execCommandArg('fontName', this.value);">
                                    <option value="Arial">Arial</option>
                                    <option value="Comic Sans MS">Comic Sans MS</option>
                                    <option value="Courier">Courier</option>
                                    <option value="Georgia">Georgia</option>
                                    <option value="Tahoma">Tahoma</option>
                                    <option value="Times New Roman" selected>Times New Roman</option>
                                    <option value="Verdana">Verdana</option>
                                </select>
                            </div>
                            <div class="input-group me-2">
                                <label class="input-group-text" for="fontSizeSelect">Size</label>
                                <select class="form-select" id="fontSizeSelect" onchange="execCommandArg('fontSize', this.value);">
                                    <option value="1">1</option>
                                    <option value="2" selected>2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                </select>
                            </div>
                            <div class="input-group me-2">
                                <label class="input-group-text" for="fontColorSelect">Font Color</label>
                                <input style="width: 100px;" type="color" class="form-control form-control-color" id="fontColorSelect" oninput="execCommandArg('foreColor', this.value);"/>
                            </div>
                            <div class="input-group me-2">
                                <label class="input-group-text" for="highlightColorSelect">Highlight Color</label>
                                <input style="width: 100px;" type="color" id="highlightColorSelect" class="form-control form-control-color" id="fontColorSelect" oninput="execCommandArg('hiliteColor', this.value);"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-auto" style="padding-bottom: 10px; height: calc(100vh - 280px); width: 100%; overflow-inline: hidden;">
                    <iframe id="richTextArea" name="richTextArea"></iframe>
                    <input type="hidden" id="noteContent" name="noteContent"/>
                    <input type="hidden" id="enoteID" name="enoteID" value="<?php echo $noteID ?>"/>
                </div>
            </form>
            <!-- Modal -->
            <div class="modal fade" id="titleError" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="titleErrorLabel" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="stitleErrorLabel">Warning</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Please put your title</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
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

<?php

if(isset($_POST["btn-save"])){
    $title = $_POST["titleText"];
    $content = $_POST["noteContent"];
    $enoteID = $_POST["enoteID"];
    
    if($title != ""){
        echo $enoteID."<br>";
        echo $title."<br>";
        echo $content."<br>";
        mysqli_query($connect, "UPDATE note SET note_title = '$title', note_content = '$content', note_lastsave = CURRENT_TIMESTAMP WHERE note_id = '$enoteID'");
        echo '<script>window.location.href = "home.php"</script>';
    }
}
?>