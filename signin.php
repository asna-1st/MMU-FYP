<!DOCTYPE html>
<html>

<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
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
    background-image: url('https://media.discordapp.net/attachments/694709501282222100/796033413400232016/among_drip.jpg?width=561&height=702');
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
<?php
    include("./dbconnect.php");

    if(isset($_POST["btn-sign-in"])){
        $username = $_POST["username"];
        $pass = $_POST["pass"];
        $row = null;

        $result = mysqli_query($connect, "SELECT * FROM user WHERE user_username = '$username'");
        if(!$result || $row = mysqli_fetch_assoc($result)){
            if($pass == $row["user_password"]){
                echo 'Logged In';
            } else {
                echo 'Wrong entered password';
            }
        } else {
            echo 'Username not exist!';
        }
    }

    mysqli_close($connect);
?>
<body>
    <div style="max-width:300px;margin:auto;" class="login-form text-center row h-100 justify-content-center align-items-center">
    <form name="signin-page" method="post" action="signin.php">
    <label class="h3 mb-3 font-weight-normal">Please Sign In</label>
        <input class="form-control" type="text" id="username" name="username" placeholder="Username" required autofocus>
        <input class="form-control" type="password" id="pass" name="pass" placeholder="Password" required>
        <div class="mt-3">
            <button name="btn-sign-in" type="submit" class="btn btn-lg btn-primary btn-block">Sign In</button>
        </div>
    </form>
</body>

</html>