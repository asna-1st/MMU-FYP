<!DOCTYPE html>
<html>

<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<style>
input[type="text"]{
    border-bottom-left-radius: 0px;
    border-bottom-right-radius: 0px;
}

input[type="password"]{
    border-top-left-radius: 0px;
    border-top-right-radius: 0px;
    border-top: 0px;
}

body {
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
    top: 0px;
    right: 0px;
    left: 0px;
    bottom: 0px;
    position: absolute;
}
</style>
<script>
    $(document).ready(function() {
        $('#username').keydown(function(e) {
            if (e.which == 32){
                return false;
            }
        });
    });
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
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
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
            </div>
        </div>
    </nav>
    <div style="max-width:300px;margin:auto;" class="login-form text-center row h-100 justify-content-center align-items-center">
    <form name="signin-page" method="post" action="signin.php">
    <label class="h3 mb-3 font-weight-normal">Please Sign In</label>
    <?php
        include("../dbconnect.php");
        session_start();

        if(isset($_SESSION["admin_loggedin"]) && $_SESSION["admin_loggedin"] === true){
            header("location: home.php");
            exit;
        }

        $cPass = true;
        $cUser = true;
        if(isset($_POST["btn-sign-in"])){
            $username = $_POST["username"];
            $pass = $_POST["pass"];
            $row = null;

            $result = mysqli_query($connect, "SELECT * FROM admin WHERE admin_username = '$username'");
            if(!$result || $row = mysqli_fetch_assoc($result)){
                if($pass == $row["admin_password"]){
                    $cPass = true;
                    session_start();

                    $_SESSION["admin_loggedin"] = true;
                    $_SESSION["admin_id"] = $row["admin_ID"];
                    $_SESSION["admin_username"] = $row["admin_username"];
                    header("location: home.php");
                } else {
                    $cPass = false;
                    echo '<script type="text/javascript">
                            $(document).ready(function () {    
                                $("#pass").tooltip({"trigger":"hover focus", "title": "Wrong password entered", "placement": "right"});
	                        });
                            </script>';
                }
            } else {
                $cUser = false;
                echo '<script type="text/javascript">
                            $(document).ready(function () {    
                                $("#username").tooltip({"trigger":"hover focus", "title": "Username not exist", "placement": "right"});
	                        });
                            </script>';
            }
        }

        mysqli_close($connect);
    ?>
        <div class="form-floating">
            <input class="form-control <?php if($cUser == false){echo 'is-invalid';} ?>" type="text" id="username" name="username" placeholder="Username" onkeyup="noSpace(this)" value="<?php if(isset($_POST["username"])) {echo $username;} ?>" required autofocus>
            <label for="username">Username</label>
        </div>
        <div class="form-floating">
            <input class="form-control <?php if($cPass == false){echo 'is-invalid';} ?>" type="password" id="pass" name="pass" placeholder="Password" required>
            <label for="pass">Password</label>
        </div>
        <div class="mt-3">
            <button name="btn-sign-in" type="submit" class="btn btn-lg btn-primary btn-block">Sign In</button>
        </div>
    </form>
</body>

</html>