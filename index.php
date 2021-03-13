<!DOCTYPE html>
<html>
    <head>
        <title>Welcome to Your Personal Notepad</title>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <link href="./design.css" rel="stylesheet">
    </head>
	
	<!--	HEADER/NAVBAR				-->
    <body class="text-center">
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
		
		<!--	MAIN CENTRE PAGE	-->
		<div class="container">
			<div class="row justify-content-md-center">
				<div class="col col-lg-5">
					<main role="main" class="inner cover">
						<h1 class="cover-heading">Welcome To Your Notepad</h1>
						<p class="lead">Create, edit, and share all of your notes in this easy-to-use application. </p>
						<p class="lead">
							<a href="#" class="btn btn-lg btn-secondary">Learn more</a>
						</p>
					</main>
				</div>
			</div>
		</div>
		
		<!--	FOOTER				-->
        <footer class="footer">
            <div class="container">
                <span class="text-muted">Temp footer for moment</span>
            </div>
        </footer>
    </body>
</html>