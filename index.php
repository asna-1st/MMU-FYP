<html>

<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
<style>
input[type="email"]{
    border-bottom-left-radius: 0px;
    border-bottom-right-radius: 0px;
}

input[type="password"]{
    border-top-left-radius: 0px;
    border-top-right-radius: 0px;
    border-top: 0px;
}
</style>
</head>

<body>
    <div style="max-width:300px;margin:auto;" class="login-form text-center row h-100 justify-content-center align-items-center">
    <form>
    <label class="h3 mb-3 font-weight-normal">Please Sign In</label>
        <input class="form-control" type="email" id="email" placeholder="Email" required autofocus>
        <input class="form-control" type="password" id="pass" placeholder="Password" required>
        <div class="mt-3">
            <button type="submit" class="btn btn-lg btn-primary btn-block">Sign In</button>
        </div>
    </form>
</body>

</html>