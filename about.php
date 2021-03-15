<!DOCTYPE html>
<html>
    <head>
        <title>About Us</title>
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
                            <a class="nav-link" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="public.php">Public Note</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="about.php">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.php">Contact Us</a>
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
                    <h1>About Us</h1>
                </div>
                <div class="col-md-12">
                    <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Pharetra et ultrices neque ornare. Eu sem integer vitae justo eget magna fermentum. Ipsum faucibus vitae aliquet nec ullamcorper sit amet. Dui vivamus arcu felis bibendum ut tristique et. Nulla facilisi morbi tempus iaculis urna id volutpat lacus. Integer vitae justo eget magna fermentum iaculis. Ac odio tempor orci dapibus ultrices. Neque ornare aenean euismod elementum nisi. Amet consectetur adipiscing elit pellentesque. Vitae turpis massa sed elementum tempus egestas sed. Viverra justo nec ultrices dui. Ac ut consequat semper viverra nam libero. Enim blandit volutpat maecenas volutpat blandit aliquam etiam. Scelerisque purus semper eget duis at tellus.
                    </p>
                    <p>
                    Lacus luctus accumsan tortor posuere ac ut. Sem fringilla ut morbi tincidunt augue. Gravida rutrum quisque non tellus orci ac auctor augue. Enim facilisis gravida neque convallis a cras semper auctor. Tellus at urna condimentum mattis pellentesque. Risus at ultrices mi tempus imperdiet nulla malesuada pellentesque elit. Egestas diam in arcu cursus. Lectus urna duis convallis convallis tellus id interdum velit laoreet. Pharetra magna ac placerat vestibulum lectus mauris ultrices eros. Vitae tortor condimentum lacinia quis vel eros donec ac odio. Ipsum nunc aliquet bibendum enim facilisis. Non diam phasellus vestibulum lorem sed.
                    </p>
                    <p>
                    Nunc sed velit dignissim sodales ut eu sem. Iaculis urna id volutpat lacus. Aenean et tortor at risus. Integer enim neque volutpat ac tincidunt vitae. Ullamcorper dignissim cras tincidunt lobortis feugiat vivamus at. Turpis egestas maecenas pharetra convallis. Consectetur lorem donec massa sapien faucibus et molestie ac. Hac habitasse platea dictumst vestibulum rhoncus est pellentesque elit. Quam id leo in vitae turpis massa sed elementum. In nulla posuere sollicitudin aliquam ultrices. Pellentesque adipiscing commodo elit at imperdiet. Tempus imperdiet nulla malesuada pellentesque. Pretium nibh ipsum consequat nisl vel. Sit amet venenatis urna cursus eget nunc scelerisque. Consectetur lorem donec massa sapien.
                    </p>
                </div>
            </div>
        </div>

        <?php
        include("./footer.php")
        ?>
    </body>
</html>