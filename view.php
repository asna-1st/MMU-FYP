<?php
    include("./dbconnect.php");
    session_start();

    if(isset($_SESSION["username"]) && isset($_SESSION["id"])){
        $username = $_SESSION["username"];
        $id = $_SESSION["id"];
    }


    if($_GET["id"] != ""){
        $noteID = $_GET["id"];
    } else if(!isset($_GET["id"])) {
        header("location: home.php");
    }
    
    if($_GET["id"] == "0") {
        header("location: home.php");
    }

    $noteTitle = null;
    $noteContent = null;
    $noteLastSaved = null;
    $noteUser = null;
    $noteUserID = null;

    $result = mysqli_query($connect, "SELECT note_title, note_content, note_lastsave, user.user_username, note.user_ID FROM note JOIN user ON note.user_ID = user.user_ID WHERE note.note_id = '$noteID'");
    while($row = mysqli_fetch_array($result)){
        $noteTitle = $row["note_title"];
        $noteContent = $row["note_content"];
        $noteLastSaved = $row["note_lastsave"];
        $noteUser = $row["user_username"];
        $noteUserID = $row["user_ID"];
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>View Note</title>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/js/all.min.js" integrity="sha512-UwcC/iaz5ziHX7V6LjSKaXgCuRRqbTp1QHpbOJ4l1nw2/boCfZ2KlFIqBUA/uRVF0onbREnY9do8rM/uT/ilqw==" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <link href="./notelib.css" rel="stylesheet">
        <link href="./design.css" rel="stylesheet">
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
        <style>
            .comment-form-container {
	background: #ffffff;
	border: #e0dfdf 1px solid;
	padding: 20px;
	border-radius: 2px;
}

.input-row {
	margin-bottom: 10px;
}

.input-field {
	width: 100%;
	border-radius: 2px;
	padding: 10px;
	border: #e0dfdf 1px solid;
}

.btn-submit {
	padding: 10px 20px;
	background: #333;
	border: #1d1d1d 1px solid;
	color: #f0f0f0;
	font-size: 0.9em;
	width: 100px;
	border-radius: 2px;
    cursor:pointer;
}

ul {
	list-style-type: none;
}

.comment-row {
	border-bottom: #e0dfdf 1px solid;
	margin-bottom: 15px;
	padding: 5px;
}

.outer-comment {
	background: #ffffff;
	padding: 10px;
	border: #dedddd 1px solid;
}

span.commet-row-label {
	font-style: italic;
}

span.posted-by {
	color: #09F;
}

.comment-info {
	font-size: 0.8em;
}
.comment-text {
    margin: 5px 0px;
}
.btn-reply {
    font-size: 0.8em;
    text-decoration: underline;
    color: #888787;
    cursor:pointer;
}
#comment-message {
    margin-left: 10px;
    color: #189a18;
    display: none;
}
        </style>
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
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    '.$username.
                                '</a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="settings.php">Settings</a></li>
                                    <li><a class="dropdown-item" href="ticket.php">Ticket</a></li>
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
                        if(!isset($id) || ($id != $noteUserID)) {
                            echo '<p><span>Created By: </span><a style="text-align: right;" href="user.php?id='.$noteUserID.'">'.$noteUser.'</a></p>';
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
                <br>
                <?php
                if(isset($_SESSION["id"])){
                    echo '<div id="hideC" class="comment-form-container">
                    <form id="frm-comment">
                        <div class="input-row">
                            <input type="hidden" name="note_id" value="'.$noteID.'" id="note_id"/>
                            <input type="hidden" name="com_id" id="com_id" />
                            <input type="hidden" name="user_id" value="'.$id.'" id="user_id" />
                        </div>
                        <div class="input-row">
                            <textarea class="input-field" type="text" name="comment" id="comment" placeholder="Add a Comment">  </textarea>
                        </div>
                        <div>
                            <input type="button" class="btn-submit" id="submitButton" value="Comment" />
                            <div id="comment-message">Comments Added Successfully!</div>
                        </div>
                    </form>
                </div>';
                }
                ?>
                <div id="output"></div>
                <script>
                    function postReply(commentId) {
                        $('#com_id').val(commentId);
                        $('#comment').focus();
                    }

            $("#submitButton").click(function () {
                $('#comment-message').css('display', 'none');
                var str = $('#frm-comment').serialize();

                $.ajax({
                    url: "commentAdd.php",
                    data: str,
                    type: 'post',
                    success: function(response) {
                        var result = eval('(' + response + ')');
                        if (response)
                        {
                        	$("#comment-message").css('display', 'inline-block');
                            $("#comment").val("");
                            $("#com_id").val("");
                     	   listComment();
                        } else {
                            alert("Failed to add comments !");
                            return false;
                        }
                    }
                });
            });

            $(document).ready(function () {
            	listComment();
            });

            const noteID = <?php echo $_GET["id"]; ?>;
            var userID = <?php isset($_SESSION["id"]) ? print $_SESSION["id"] : print "0"; ?>;
            function listComment() {
                $.post("commentList.php?id=" + noteID,
                    function (data) {
                    var data = JSON.parse(data);
                            
                    var comments = "";
                    var replies = "";
                    var item = "";
                    var parent = -1;
                    var results = new Array();

                    var list = $("<ul class='outer-comment'>");
                    var item = $("<li>").html(comments);

                    for(var i = 0; (i < data.length); i++){
                        var commentId = data[i]['id'];
                        parent = data[i]['parent_id'];

                        if (parent == "0"){
                            comments = "<div class='comment-row'>"+
                            "<div class='comment-info'><span class='commet-row-label'>from</span> <span class='posted-by'>" + data[i]['user_username'] + " </span> <span class='commet-row-label'>at</span> <span class='posted-at'>" + data[i]['submit_date'] + "</span></div>" + 
                            "<div class='comment-text'>" + data[i]['content'] + "</div>";
                            if(userID != "0"){
                                comments = comments +  "<div><a class='btn-reply' onClick='postReply(" + commentId + ")'>Reply</a></div>"+
                                "</div>";
                            }

                            var item = $("<li>").html(comments);
                            list.append(item);
                            var reply_list = $('<ul>');
                            item.append(reply_list);
                            listReplies(commentId, data, reply_list);
                        }
                    }
                    $("#output").html(list);
                });
            }

            function listReplies(commentId, data, list) {
                for (var i = 0; (i < data.length); i++)
                {
                    if (commentId == data[i].parent_id)
                    {
                        var comments = "<div class='comment-row'>"+
                        " <div class='comment-info'><span class='commet-row-label'>from</span> <span class='posted-by'>" + data[i]['user_username'] + " </span> <span class='commet-row-label'>at</span> <span class='posted-at'>" + data[i]['submit_date'] + "</span></div>" + 
                        "<div class='comment-text'>" + data[i]['content'] + "</div>";
                        if(userID != "0"){
                            comments = comments +  "<div><a class='btn-reply' onClick='postReply(" + data[i]['id'] + ")'>Reply</a></div>"+
                        "</div>";
                        }
                        var item = $("<li>").html(comments);
                        var reply_list = $('<ul>');
                        list.append(item);
                        item.append(reply_list);
                        listReplies(data[i].id, data, reply_list);
                    }
                }
            }
                </script>
            </div>
        </div>
        <?php
        include("./footer.php")
        ?>
    </body>
</html>