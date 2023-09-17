<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iofrm</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="css/iofrm-style.css">
    <link rel="stylesheet" type="text/css" href="css/iofrm-theme20.css">
</head>
<body>
    <div class="form-body without-side">
        <div class="row">

            <div class="img-holder">
                <div class="bg" style="opacity: 1;">
                    <div style="display: flex;justify-content: center;"><img style="" src="images/logo-light.png"></div></a>
                </div>
                <div class="info-holder">
                    <img src="images/graphic3.svg" alt="">
                </div>
            </div>
            <div class="form-holder">
                <div class="form-content" style="padding-bottom: 0px;">
                    <div class="form-items">
                        <h3>Login to account</h3>
                        <p>Access to the most powerfull tool in the entire design and web industry.</p>
                        <form method="post" action="login.php">
                            <input class="form-control" type="text" name="mail" placeholder="E-mail Address" required>
                            <input class="form-control" type="password" name="password" placeholder="Password" required>
                            <div class="form-button">
                                <button id="submit" type="submit" class="ibtn" name="ok">Login</button> <a href="forget.php">Forget password?</a>
                            </div>
                        </form>
                        <div class="other-links">
                            <div class="text">Or login with</div>
                            <a href="#"><i class="fab fa-facebook-f"></i>Facebook</a><a href="#"><i class="fab fa-google"></i>Google</a><a href="#">
                        </div>
                        <div class="page-links">
                            <a href="register.php">Register new account</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>
<?php
require("../set.php");
if (isset($_POST['ok'])) {
    $met = "SELECT * FROM `users` WHERE mail = '{$_POST['mail']}' AND pass = '{$_POST['password']}' ";
    echo "$met";
    $exec = mysqli_query($conn, $met);
    if (mysqli_num_rows($exec) > 0) {
        $client = mysqli_fetch_assoc($exec);
        session_start();
        $_SESSION['id'] = $client['idUser'];
        $_SESSION['pass'] = $client['pass'];
        $_SESSION['img'] = $client['imgUser'];

        if ($client['role'] == 'admin') {  // Add a check for admin role
            header("Location: ../test/index.php");  // Redirect to dashboardd.php for admin
        } 
    }
}

?>