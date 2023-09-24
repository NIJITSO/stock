<?php
require('../set.php');
session_start();
if(!isset($_SESSION['id'])  ||  $_SESSION['role']!=="admin"){
  header('Location: ../Authentification/');
}
$_SESSION['deletIdM']=null;

if (isset($_GET['deletIdM'])) {
    $_SESSION['deletIdM']=$_GET['deletIdM'];
    header("Location: deletMess.php");
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="css/style.min.css">

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
     td,th{
        padding: 10px 30px;
     }   
    </style>
</head>
 
<body>
<?php
$inf="SELECT COUNT(id) AS `totalMessages` FROM `formulaire`";
$r=mysqli_query($conn, $inf);
$d=mysqli_fetch_assoc($r);






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
                    <a href="messages.php" style="all:unset;"><div class="nav-option option1">
                        <img src="img/message.png"
                            class="nav-img"
                            alt="dashboard">
                        <h3> Boite Reception</h3>
                    </div></a>
 
                    <a href="edit_profile_admin.php" style="all:unset;"><div class="nav-option option2">
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
 
            <div class="box-container">
                <div class="box box2">
                    <div class="text">
                        <h2 class="topic-heading"><?=$d['totalMessages']?></h2>
                        <h2 class="topic">Nombre des Messages</h2>
                    </div>
 
                    <img src=
"img/somme.png"
                         alt="likes">
                </div>
 
 
            <div class="report-container">
                <div class="report-body">
                    <table cellpadding="10" cellspacing="0">
                    <tr>
                        <th>Message</th>
                        <th>Nom </th>
                        <th>mail</th>
                        <th>Date d'ajout</th>
                        <th>Voir</th>
                        <th>Supprimer</th>
                    </tr>
                    <div class="items">
                    <?php
                    require('../set.php');
                    $sql = "SELECT * FROM `formulaire`";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <tr> 
                            <th>Message id: <b><?=$row['id']?></b></th>
                            <th><?=$row['name']?></th>
                            <th><?=$row['email']?></th>
                            <th><?=$row['created_at']?></th>
                            <th style="cursor: pointer;" onclick="showMessage('<?=$row['message']?>')">
  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
    <path d="M15 12c0 1.654-1.346 3-3 3s-3-1.346-3-3 1.346-3 3-3 3 1.346 3 3zm9-.449s-4.252 8.449-11.985 8.449c-7.18 0-12.015-8.449-12.015-8.449s4.446-7.551 12.015-7.551c7.694 0 11.985 7.551 11.985 7.551zm-7 .449c0-2.757-2.243-5-5-5s-5 2.243-5 5 2.243 5 5 5 5-2.243 5-5z"/>
  </svg>
</th>
                            <th><a href="messages.php?deletIdM=<?=$row['id']?>"><svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" width="122.881px" height="122.88px" viewBox="0 0 122.881 122.88" enable-background="new 0 0 122.881 122.88" xml:space="preserve"><g><path fill-rule="evenodd" clip-rule="evenodd" d="M61.44,0c33.933,0,61.441,27.507,61.441,61.439 c0,33.933-27.508,61.44-61.441,61.44C27.508,122.88,0,95.372,0,61.439C0,27.507,27.508,0,61.44,0L61.44,0z M81.719,36.226 c1.363-1.363,3.572-1.363,4.936,0c1.363,1.363,1.363,3.573,0,4.936L66.375,61.439l20.279,20.278c1.363,1.363,1.363,3.573,0,4.937 c-1.363,1.362-3.572,1.362-4.936,0L61.44,66.376L41.162,86.654c-1.362,1.362-3.573,1.362-4.936,0c-1.363-1.363-1.363-3.573,0-4.937 l20.278-20.278L36.226,41.162c-1.363-1.363-1.363-3.573,0-4.936c1.363-1.363,3.573-1.363,4.936,0L61.44,56.504L81.719,36.226 L81.719,36.226z"/></g></svg></a></th>
                        </tr>
                     <?php } } ?>
                    </div>
                </div>
                </table>
            </div>

 
                <div id="message" style="display: none;">
                    <div class="report-header" style="display: flex; align-content: space-between;">
                        <div>
                            <h1 class="recent-Articles">Message Detaille</h1>
                        </div>
                        <div id="close" onclick="closeMessage()">
                            <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" width="122.881px" height="122.88px" viewBox="0 0 122.881 122.88" enable-background="new 0 0 122.881 122.88" xml:space="preserve"><g><path fill-rule="evenodd" clip-rule="evenodd" d="M61.44,0c33.933,0,61.441,27.507,61.441,61.439 c0,33.933-27.508,61.44-61.441,61.44C27.508,122.88,0,95.372,0,61.439C0,27.507,27.508,0,61.44,0L61.44,0z M81.719,36.226 c1.363-1.363,3.572-1.363,4.936,0c1.363,1.363,1.363,3.573,0,4.936L66.375,61.439l20.279,20.278c1.363,1.363,1.363,3.573,0,4.937 c-1.363,1.362-3.572,1.362-4.936,0L61.44,66.376L41.162,86.654c-1.362,1.362-3.573,1.362-4.936,0c-1.363-1.363-1.363-3.573,0-4.937 l20.278-20.278L36.226,41.162c-1.363-1.363-1.363-3.573,0-4.936c1.363-1.363,3.573-1.363,4.936,0L61.44,56.504L81.719,36.226 L81.719,36.226z"/></g></svg>
                        </div>
                    </div>
                    <div class="report-body">
                        <div id="messageContainer">
                            
                        </div>
                    </div>
                </div>
       </div>





    </div>
<script>
    function showMessage(message) {
        var messageContainer = document.getElementById("messageContainer");
        messageContainer.innerText = message;
        messageContainer.style.display = "block"; // Display the div element
        var message = document.getElementById("message");
        message.style.display = "block";
    }
    function closeMessage() {
        var message = document.getElementById("message");
        message.style.display = "none";
    }
</script>
    <script src="js/script.js"></script>
</body>
</html>
