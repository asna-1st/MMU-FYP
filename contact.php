<?php
if(!empty($_POST["send"])){
    $name = $_POST["inputName"];
    $email = $_POST["inputEmail"];
    $msg = $_POST["inputMsg"];
    $toEmail = "owner@example.com";
    $header = "From: ".$name."<".$email.">\r\n";
    $subject = "Contact From ".$name;
    if(mail($toEmail, $subject, $msg, $header)){
        echo "Succes";
    } else {
        echo "Error Occured";
    }

    echo '<script>window.location.href = "contact.php"</script>';
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Contact Us</title>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <link href="./design.css" rel="stylesheet">
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Notepad</a>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="public.php">Public Note</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="about.php">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="contact.php">Contact Us</a>
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

        <div class="container justify-content-center">
            <div class="row">
                <div class="col-md-8" style="margin-top: 20px; margin-bottom: 10px;">
                    <h1>Contact Us</h1>
                </div>
                <div class="col-md-12">
                    <form action="contact.php" method="post">
                        <div class="mb-3">
                            <label for="inputName" class="form-label">Name</label>
                            <input type="text" style="width: 50%;" class="form-control" id="inputName" name="inputName" required>
                        </div>
                        <div class="mb-3">
                            <label for="inputEmail" class="form-label">Email</label>
                            <input type="text" class="form-control" style="width: 50%;" id="inputEmail" name="inputEmail" aria-describedby="emailHelp" required>
                            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                        </div>
                        <div class="mb-3">
                            <label for="inputMsg" class="form-label">Message</label>
                            <textarea class="form-control" style="resize: none;" rows="6" id="inputMsg" name="inputMsg" required></textarea>
                        </div>
                        <div class="mb-3">
                            <button type="submit" name="send" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
        include("./footer.php")
        ?>
    </body>
</html>