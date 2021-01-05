<!DOCTYPE html>
<html>

<head>
<title>Register</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
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
</head>

<body>
    <div style="max-width:300px;margin:auto;" class="login-form text-center row h-100 justify-content-center align-items-center">
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

    if($pass == $repass){
        print "Same";
        $result = mysqli_query($connect, "SELECT * FROM user WHERE email = '{$email}'");
        if (!$result || !$row = mysqli_fetch_assoc($result)){
            echo 'yes';
            mysqli_query($connect, "INSERT INTO user (user_username, user_password, user_email) VALUES ('$username', '$pass', '$email')");
        } else {
            echo 'no';
        }
    } else {
        print "Not Same";
    }
}
?>