<?php
require('../set.php');
session_start();
if(!isset($_SESSION['id'])  ||  $_SESSION['role']!=="admin"){
  header('Location: ../Authentification/');
}

$_SESSION['deletIdCat']=null;

if (isset($_GET['deletIdCat'])) {
    $_SESSION['deletIdCat']=$_GET['deletIdCat'];
    header("Location: deletCat.php");
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
    <title>Hamza</title>
    <link rel="stylesheet"
          href="css/style.css">

    <style type="text/css">
     th,th{
        padding: 10px 30px;
     }
    #toggleButton {
        background-color: #007BFF;
        color: #fff;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        font-size: 16px;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    #toggleButton:hover {
        background-color: #0056b3;
    }
    </style>
    <script defer src="js/script.js"></script>
</head>
 
<body>
    <!-- for header part -->
    <header>
 
        <div class="logosec">
            <div class="logo">Meghrib</div>
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
                    <a href="size.php" style="all:unset;"><div class="nav-option option1">
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
            <button id="toggleButton">Show/Hide Size Report</button>

            <div class="report-container" id="sizeReport" style="display: block;">
                <div class="report-header">
                    <h1 class="recent-Articles">Sizes</h1>
                    <a href="addCat.php"><button class="view" style="width: 150px; margin-right: 40px;">Ajouter Size</button></a>
                </div>
 
                <div class="report-body">
                    <table>
                        <tr>
                            <th class="t-op">ID Size</th>
                            <th class="t-op">Titre du Size</th>
                            <th class="t-op">Supprimer</th>
                        </tr>

                    <?php
                    require('../set.php');
                    $sql = "SELECT * FROM `size` ORDER BY `size`.`idSize` ASC";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                      <tr>
                            <th class="t-op-nextlvl">categorie id: <b><?=$row['idSize']?></b></th>
                            <th class="t-op-nextlvl"><?=$row['sizeValue']?></th>
                            <th class="t-op-nextlvl"><a href="index.php?deletIdCat=<?=$row['idSize']?>"><svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" width="122.881px" height="122.88px" viewBox="0 0 122.881 122.88" enable-background="new 0 0 122.881 122.88" xml:space="preserve"><g><path fill-rule="evenodd" clip-rule="evenodd" d="M61.44,0c33.933,0,61.441,27.507,61.441,61.439 c0,33.933-27.508,61.44-61.441,61.44C27.508,122.88,0,95.372,0,61.439C0,27.507,27.508,0,61.44,0L61.44,0z M81.719,36.226 c1.363-1.363,3.572-1.363,4.936,0c1.363,1.363,1.363,3.573,0,4.936L66.375,61.439l20.279,20.278c1.363,1.363,1.363,3.573,0,4.937 c-1.363,1.362-3.572,1.362-4.936,0L61.44,66.376L41.162,86.654c-1.362,1.362-3.573,1.362-4.936,0c-1.363-1.363-1.363-3.573,0-4.937 l20.278-20.278L36.226,41.162c-1.363-1.363-1.363-3.573,0-4.936c1.363-1.363,3.573-1.363,4.936,0L61.44,56.504L81.719,36.226 L81.719,36.226z"/></g></svg></a></th>
                        </tr>
                     <?php }}?>
                    </table>
                </div>
            </div>
        </div>
    </div>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const sizeReport = document.getElementById("sizeReport");
    const toggleButton = document.getElementById("toggleButton");

    // Function to toggle visibility
    function toggleVisibility() {
        if (sizeReport.style.display === "none") {
            sizeReport.style.display = "block";
        } else {
            sizeReport.style.display = "none";
        }
    }

    // Toggle visibility on button click
    toggleButton.addEventListener("click", function () {
        toggleVisibility();
        // Save the visibility state to localStorage
        localStorage.setItem("sizeReportVisibility", sizeReport.style.display);
    });

    // Check localStorage for visibility state on page load
    const storedVisibility = localStorage.getItem("sizeReportVisibility");
    if (storedVisibility) {
        sizeReport.style.display = storedVisibility;
    }
});
</script>

</body>
</html>