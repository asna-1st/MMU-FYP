<!DOCTYPE html>
<html>

<head>
<title>Register</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
<link href="./design.css" rel="stylesheet">
<style>
#email{
    border-bottom-left-radius: 0px;
    border-bottom-right-radius: 0px;
}

#pass{
    border-top-left-radius: 0px;
    border-top-right-radius: 0px;
    border-bottom-left-radius: 0px;
    border-bottom-right-radius: 0px;
    border-top: 0px;
}

#username{
    border-bottom-left-radius: 0px;
    border-bottom-right-radius: 0px;
    border-top-left-radius: 0px;
    border-top-right-radius: 0px;
    border-top: 0px;
}

#repass{
    border-top-left-radius: 0px;
    border-top-right-radius: 0px;
    border-top: 0px;
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
                        <a class="nav-link active" aria-current="page" href="#">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div style="max-width:300px;margin:auto;margin-top:10%;" class="login-form text-center row h-100 justify-content-center align-items-center">
    <form name="register-page" method="post" action="">
    <label class="h3 mb-3 font-weight-normal">Registration</label>
        <input class="form-control" type="email" id="email" name="email" placeholder="Email" required autofocus>
        <input class="form-control" type="text" id="username" name="username" placeholder="Username" required>
        <input class="form-control" type="password" id="pass" name="pass" placeholder="Password" required>
        <input class="form-control" type="password" id="repass" name="repass" placeholder="Re-Enter Password" required>
        <div class="mt-3">
            <button name="btn-register" id="btn-register" type="submit" class="btn btn-lg btn-primary btn-block">Register</button>
        </div>
    </form>
    </div>
    <?php
        include("./footer.php")
    ?>
</body>

</html>

<?php
include("./dbconnect.php");

if(isset($_POST["btn-register"])){
    $email = $_POST["email"];
    $username = $_POST["username"];
    $pass = $_POST["pass"];
    $repass = $_POST["repass"];
    $salt = "123me";
    $row = null;
    $cPass = false;
    $cUsername = false;
    $cEmail = false;

    /* if($pass == $repass){
        print "Same";
        $result = mysqli_query($connect, "SELECT * FROM user WHERE user_email = '{$email}'");
        if (!$result || !$row = mysqli_fetch_assoc($result)){

            $result = mysqli_query($connect, "SELECT * FROM user WHERE user_username = '{$username}'");
            if (!$result || !$row = mysqli_fetch_assoc($result)){
                echo 'yes';
            } else {
                echo 'no';
            }
        } else {
            echo 'no';
        }
    } else {
        print "Not Same";
    } */

    if($pass == $repass){
        $cPass = true;
    } else {
        echo 'Password enterd not same!';
    }

    $result = mysqli_query($connect, "SELECT * FROM user WHERE user_email = '{$email}'");
    if(!$result || !$row = mysqli_fetch_assoc($result)){
        $cEmail = true;
    } else {
        echo '\nEmail already exist!';
    }

    $result = mysqli_query($connect, "SELECT * FROM user WHERE user_username = '{$username}'");
    if(!$result || !$row = mysqli_fetch_assoc($result)){
        $cUsername = true;
    } else {
        echo '\nUsername already exist!';
    }

    if($cPass == true && $cUsername == true && $cEmail == true){
        mysqli_query($connect, "INSERT INTO user (user_username, user_password, user_email) VALUES ('$username', '$pass', '$email')");
    }

    mysqli_close($connect);
}
?>