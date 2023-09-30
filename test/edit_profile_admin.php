<?php
require('../set.php');
session_start();
if(!isset($_SESSION['id'])  ||  $_SESSION['role']!=="admin"){
  header('Location: ../Authentification/');
}    if (true) {
      $idT=$_SESSION['id'];
        $met="SELECT * FROM `users` WHERE idUser = '$idT'";
        $res=mysqli_query($conn,$met);
        if (mysqli_num_rows($res)>0) {
            $client=mysqli_fetch_assoc($res);
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible"
          content="IE=edge">
    <meta name="viewport"
          content="width=device-width,
                   initial-scale=1.0">
    <title>netserv</title>
    <link rel="stylesheet"
          href="css/style.css">
    <style type="text/css">
        .img-account-profile {
    height: 10rem;
}
.rounded-circle {
    border-radius: 50% !important;
}
.card {
    box-shadow: 0 0.15rem 1.75rem 0 rgb(33 40 50 / 15%);
}
.card .card-header {
    font-weight: 500;
    font-weight: bold;
}
.card-header:first-child {
    border-radius: 0.35rem 0.35rem 0 0;
    margin: 2em 0 0em 0;
}
.card-header {
    padding: 1rem 1.35rem;
    margin-bottom: 0;
    background-color: rgba(33, 40, 50, 0.03);
    border-bottom: 1px solid rgba(33, 40, 50, 0.125);
}
.form-control, .dataTable-input {
    display: block;
    width: 100%;
    padding: 0 1.125rem;
    font-size: 0.875rem;
    font-weight: 400;
    line-height: 1;
    color: #69707a;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #c5ccd6;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border-radius: 0.35rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.nav-borders .nav-link.active {
    color: #0061f2;
    border-bottom-color: #0061f2;
}
.nav-borders .nav-link {
    color: #69707a;
    border-bottom-width: 0.125rem;
    border-bottom-style: solid;
    border-bottom-color: transparent;
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
    padding-left: 0;
    padding-right: 0;
    margin-left: 1rem;
    margin-right: 1rem;
}
.no-padding {
  padding-top: 0;
  padding-bottom: 0;
}
css
Copy code
.btn {
  display: inline-block;
  font-weight: 400;
  text-align: center;
  white-space: nowrap;
  vertical-align: middle;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  border: 1px solid transparent;
  padding: 0;
  font-size: 1rem;
  line-height: 1.5;
  border-radius: 0.25rem;
  transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}
    </style>
</head>
 
<body>
<?php
// $inf="SELECT SUM(price) AS `totalCost`, COUNT(id) AS `totalCourses` FROM `items_table`";
// $r=mysqli_query($conn, $inf);
// $d=mysqli_fetch_assoc($r);


?>
    <!-- for header part -->
    <header>
 
        <div class="logosec">
            <div class="logo">NETSERV</div>
            <img src=
"https://media.geeksforgeeks.org/wp-content/uploads/20221210182541/Untitled-design-(30).png"
                class="icn menuicn"
                id="menuicn"
                alt="menu-icon">
        </div>
 
        <div class="message">
            <div class="dp">
              <img src="../../imgUser/<?=$_SESSION['img']?>"
                    class="dpicn"
                    alt="dp">
              </div>
        </div>
 
    </header>
 
    <div class="main-container">
        <div class="navcontainer">
            <nav class="nav">
                <div class="nav-upper-options">
                    <a href="index.php" style="all:unset;"><div class="nav-option option2">
                        <img src="img/dashboard.jpg"
                            class="nav-img"
                            alt="dashboard">
                        <h3> Dashboard</h3>
                    </div></a>
                    <a href="size.php" style="all:unset;"><div class="nav-option option2">
                        <img src="img/dashboard.jpg"
                            class="nav-img"
                            alt="dashboard">
                        <h3> Sisez</h3>
                    </div></a>
                    <a href="devis.php" style="all:unset;"><div class="nav-option option2">
                        <img src="img/message.png"
                            class="nav-img"
                            alt="dashboard">
                        <h3> Ajouter Un devis</h3>
                    </div></a>
                    <a href="devis_manager.php" style="all:unset;"><div class="nav-option option2">
                        <img src="img/message.png"
                            class="nav-img"
                            alt="dashboard">
                        <h3> Devis manager</h3>
                    </div></a>
 
                    <a href="edit_profile_admin.php" style="all:unset;"><div class="nav-option option1">
                        <img src="img/edit.jpg" class="nav-img" alt="settings">
                        <h3> Settings</h3>
                    </div></a>

                    <a href="../deconnexion.php" style="all:unset;">
                        <div class="nav-option logout">
                        <img src="img/logout.jpg" class="nav-img" alt="logout">
                        <h3>Logout</h3>
                    </div></a>
 
                </div>
            </nav>
        </div>
        <div class="main">
 
            <div class="searchbar2">
                <input type="text"
                       name=""
                       id=""
                       placeholder="Search">
                <div class="searchbtn">
                  <img src=
"https://media.geeksforgeeks.org/wp-content/uploads/20221210180758/Untitled-design-(28).png"
                        class="icn srchicn"
                        alt="search-button">
                  </div>
            </div>
 
            
 
            <div class="report-container">

<section class="probootstrap-section" style="padding-top: 1em; padding: 0 2em;">
  <div class="container">
    <div class="container-xl px-4 mt-4">
      <div class="row">

        <div class="col-xl-8">
        <div class="card mb-4">
        <div class="card-header">Account Setting</div>
        <div class="card-body">
          <form style="margin: 2em;" method="post" action="traitement.php" enctype="multipart/form-data">
          <div class="card-body text-center">
            <img id="profile-image" class="img-account-profile rounded-circle mb-2" src="../../imgUser/<?=$client['imgUser']?>" alt="">
            <div class="small font-italic text-muted mb-4"></div>
            <label for="fileInput" class="btn btn-primary" style="margin-bottom: 1em; cursor: pointer;">
              Choose File
              <input type="file" id="fileInput" name="fileInput" style="display: none;">
            </label>
          </div>


              
                <div class="row gx-3 mb-3">
                  <div class="col-md-6">
                    <label class="small mb-1" for="inputFullName">Full name</label>
                    <input class="form-control" id="inputFullName" type="text" placeholder="Enter your full name" name="fullname" value="<?=$client['fullname']?>">
                  </div>
                </div>
                <div class="row gx-3 mb-3">
                  <div class="col-md-6" style="margin-bottom: 1em;">
                    <label class="small mb-1" for="inputBirthday">Birthday</label>
                    <input class="form-control" id="inputBirthday" type="date" name="birthday" placeholder="Enter your birthday" name="birthday" value="<?=$client['birthday']?>">
                  </div>
                </div>

                <button class="btn btn-primary" name="ok" type="submit" style="margin-bottom: 1em">Update</button>
              </form>
            </div>
          </div>
        </div>



        <div class="col-xl-8">
          <div class="card mb-4">
            <div class="card-header">Account Security</div>
            <div class="card-body">
              <form style="margin: 2em;" method="POST" action="traitement.php">
                <div class="row gx-3 mb-3">
                  <label class="small mb-1" for="inputEmailAddress">Email address</label>
                  <input disabled class="form-control" id="inputEmailAddress" type="email" placeholder="Enter your email address" value="<?=$client['mail']?>">
                </div>
                <div class="row gx-3 mb-3">
                  <div class="col-md-6">
                    <label class="small mb-1" for="inputFullName">Ancien mot de passe</label>
                    <input class="form-control" id="inputFullName" type="password" placeholder="Enter your old mot de passe" name="oldpass" value="" required>
                  </div>
                </div>

                <div class="row gx-3 mb-3">
                  <div class="col-md-6">
                    <label class="small mb-1" for="inputFullName">Nouveau mot de passe</label>
                    <input class="form-control" id="inputFullName" type="password" placeholder="Enter your nouveau mot de passe" name="newpass" value="" required>
                  </div>
                </div>

                <div class="row gx-3 mb-3" style="margin-bottom: 1em;">
                  <div class="col-md-6">
                    <label class="small mb-1" for="inputFullName">Nouveau mot de passe</label>
                    <input class="form-control" id="inputFullName" type="password" placeholder="Retaper le nouveau mot de passe" name="newpasscheck" value="" required>
                  </div>
                </div>
                <button class="btn btn-primary" type="submit" name="passUpdate" style="margin-bottom: 1em">Update</button>
              </form>
            </div>
          </div>
        </div>








      </div>
    </div>
  </div>
</section>
<script src="js/script.js"></script>
<script>
  // Get references to the image and file input elements
  const profileImage = document.getElementById('profile-image');
  const fileInput = document.getElementById('fileInput');
  console.log(fileInput+profileImage);
  console.log(JSON.stringify(fileInput, null, 2));
  // Add event listener to the file input element
  fileInput.addEventListener('change', function() {
    const file = fileInput.files[0]; // Get the selected file

    if (file) {
      const reader = new FileReader(); // Create a file reader

      // When the file reader loads the image, update the profile image source
      reader.onload = function() {
        profileImage.src = reader.result;
      }

      // Read the file as a data URL
      reader.readAsDataURL(file);
    }
  });
</script>
</body>
</html>