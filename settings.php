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
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <link href="./design.css" rel="stylesheet">
        <script>
            function checkPass(){
                var pass = document.getElementById("nPass").value;
                var repass = document.getElementById("REnPass").value;

                if(repass != pass){
                    event.preventDefault();
                    $("#passToast").toast({delay: 3000});
                    $("#passToast").toast('show');
                    return false;
                }
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
                            <a class="nav-link" aria-current="page" href="home.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="create.php">Create</a>
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
                            <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo $username; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">Settings</a></li>
                                <li><a class="dropdown-item" href="ticket.php">Ticket</a></li>
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-md-12" style="margin-top: 20px;">
                    <h1>Settings</h1>
                </div>
                <div class="col-md-5" style="border: 1px solid #e5e5e5; margin-top: 30px; border-radius: 8px; margin-right:30px;">
                    <form method="POST" style="margin-top: 20px;" action="settings.php" enctype="multipart/form-data">
                        <p style="font-weight: bold; margin-bottom: 30px; font-size: 20px;">Update Profile Picture</p>
                        <input class="form-control" accept="image/*" type="file" id="formFile" name="formFile">
                        <button style="margin: 10px; margin-top: 80px;" class="btn btn-primary float-end" type="submit" id="btnUpdImg" name="btnUpdImg">Update</button>
                    </form>
                </div>
                <div class="col-md-5" style="border: 1px solid #e5e5e5; margin-top: 30px; border-radius: 8px;">
                    <form method="POST" style="margin-top: 20px;" action="settings.php">
                        <p style="font-weight: bold; margin-bottom: 30px; font-size: 20px;">Reset Password</p>
                        <div class="row mb-2">
                            <label class="col-form-label col-sm-4">New Password:</label>
                            <div class="col-sm-8">
                                <input class="form-control mb-2" type="password" name="nPass" id="nPass" required>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-form-label col-sm-4">Retype Password:</label>
                            <div class="col-sm-8">
                                <input class="form-control mb-2" type="password" name="REnPass" id="REnPass" required>
                            </div>
                        </div>
                        <button style="margin: 10px" onclick="checkPass();" class="btn btn-primary float-end" type="submit" name="btnResetPass">Reset</button>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5" style="border: 1px solid #e5e5e5; margin-top: 30px; border-radius: 8px;">
                    <form method="POST" style="margin-top: 20px;" action="settings.php">
                        <p style="font-weight: bold; margin-bottom: 30px; font-size: 20px;">Reset Email</p>
                        <div class="row mb-2">
                            <label class="col-form-label col-sm-4">New Email:</label>
                            <div class="col-sm-8">
                                <input class="form-control mb-2" type="email" name="nEmail" required>
                            </div>
                        </div>
                        <button style="margin: 10px;" class="btn btn-primary float-end" type="submit" name="btnResetEmail">Reset</button>
                    </form>
                </div>
            </div>
            <button class="btn btn-danger" style="margin:10px; margin-left: 0;" type="button" data-bs-toggle="modal" data-bs-target="#deleteError">Delete Account</button>
        </div>
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 5">
            <div id="passToast" class="toast">
                <div class="toast-header">
                    <strong class="me-auto">Warning</strong>
                </div>
                <div class="toast-body">
                    Passwword not same!
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="deleteError" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="deleteErrorLabel" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteErrorLabel">Warning</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure to delete your account?</p>
                        </div>
                        <div class="modal-footer">
                            <form id="delForm" name="delForm" action="settings.php" method="post">
                                <button type="submit" name="btnDel" class="btn btn-danger">Yes</button>
                            </form>
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">No</button>
                        </div>
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
if(isset($_POST["btnResetPass"])){
    $pass = $_POST["nPass"];
    $repass = $_POST["REnPass"];

    if($pass == $repass){
        if(mysqli_query($connect, "UPDATE user SET user_password = '$pass' WHERE user_ID = '$id'")){
            echo '<script>window.location.href = "settings.php";</script>';
        } else {
            mysqli_error($connect);
            echo "Error Occurred!";
        }
    }
}

if(isset($_POST["btnResetEmail"])){
    $email = $_POST["nEmail"];

    if(mysqli_query($connect, "UPDATE user SET user_email = '$email' WHERE user_ID = '$id'")){
        echo '<script>window.location.href = "settings.php";</script>';
    } else {
        mysqli_error($connect);
        echo "Error Occurred!";
    }
}

if(isset($_POST["btnDel"])){
    if(mysqli_query($connect, "DELETE FROM user WHERE user_ID = '$id'")){
        $_SESSION = array();
        session_destroy();
        echo '<script>window.location.href = "index.php";</script>';
        exit;
    } else {
        mysqli_error($connect);
        echo "Error Occurred!";
    }
}

if(isset($_POST["btnUpdImg"])){
    if(isset($_FILES["formFile"]["tmp_name"])){
        $filename = $_FILES["formFile"]["tmp_name"];
        $file_ext = pathinfo($filename, PATHINFO_EXTENSION);
        $file_ext = strtolower($file_ext);

        $imgData = base64_encode(file_get_contents($filename));
        $src = 'data: '.mime_content_type($filename).';base64,'.$imgData;

        if(mysqli_query($connect, "UPDATE user SET image = '$src' WHERE user_ID = '$id'")){
            echo '<script>window.location.href = "settings.php";</script>';
            exit;
        } else {
            mysqli_error($connect);
            echo "Error Occurred!";
        }
    }
}
?>