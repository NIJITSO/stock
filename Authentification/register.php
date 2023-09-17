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
                    <div style="display: flex;justify-content: center;"><img style="" src="images/logo-light.png"></div>
                </div>
                <div class="info-holder">
                    <img src="images/graphic3.svg" alt="">
                </div>
            </div>
            <div class="form-holder">
                <div class="form-content" style="padding-bottom: 0px;">
                    <div class="form-items">
                        <h3>Register new account</h3>
                        <p>Access to the most powerfull tool in the entire design and web industry.</p>
                        <form method="post" action="register.php">
                            <input class="form-control" type="text" name="fullname" placeholder="Full Name" required>
                            <input class="form-control" type="text" name="mail" placeholder="E-mail Address" required>
                            <input class="form-control" type="password" name="password" placeholder="Password" required>
                            <div class="form-button">
                                <button id="submit" type="submit" class="ibtn" name="ok">Register</button>
                            </div>
                        </form>
                        <div class="other-links">
                            <div class="text">Or register with</div>
                            <a href="#"><i class="fab fa-facebook-f"></i>Facebook</a><a href="#"><i class="fab fa-google"></i>Google</a>
                        </div>
                        <div class="page-links">
                            <a href="login.php">Login to account</a>
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
        if (true) {
            $met="INSERT INTO `users` (`idUser`, `fullname`, `mail`, `pass`) VALUES (NULL, '{$_POST['fullname']}', '{$_POST['mail']}', '{$_POST['password']}')";
            $exec=mysqli_query($conn,$met);
        }
        if ($exec) {
            echo "registered successfully";
        }

    }
?>