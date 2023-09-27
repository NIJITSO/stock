<?php
require('../set.php');
session_start();
if(!isset($_SESSION['id'])  ||  $_SESSION['role']!=="admin"){
  header('Location: ../Authentification/');
}
$_SESSION['deletId']=null;
$_SESSION['updateId']=null;
$_SESSION['deletIdCat']=null;
if (isset($_GET['deletId'])) {
    $_SESSION['deletId']=$_GET['deletId'];
    header("Location: delet.php");
}
if (isset($_GET['updateId'])) {
    $_SESSION['updateId']=$_GET['updateId'];
    header("Location: update.php");
}
if (isset($_GET['updateIdVariable'])) {
    $_SESSION['updateVariable']=$_GET['updateIdVariable'];
    header("Location: updateVariable.php");
}
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
                    <a href="index.php" style="all:unset;"><div class="nav-option option1">
                        <img src="img/dashboard.jpg"
                            class="nav-img"
                            alt="dashboard">
                        <h3> Dashboard</h3>
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
 
            <div class="box-container">
 
                <div class="box box1">
                    <div class="text">
                        <h2 class="topic-heading">90000</h2>
                        <h2 class="topic">Totale des Costs</h2>
                    </div>
 
                    <img src=
"img/stack.png"
                        alt="Views">
                </div>
                
                <div class="box box2">
                    <div class="text">
                        <h2 class="topic-heading">500</h2>
                        <h2 class="topic">Nombre des Produits</h2>
                    </div>
 
                    <img src=
"img/somme.png"
                         alt="likes">
                </div>
 
 
            <div class="report-container">
                <div class="report-header">
                    <h1 class="recent-Articles">Produits</h1>
                    <a href="add.php"><button class="view" style="width: 150px;">Ajouter Produits</button></a>
                </div>
 
                <div class="report-body">
                    <table cellpadding="10" cellspacing="0">
                    <tr>
                        <th>Produits</th>
                        <th>Titre</th>
                        <th>Quantity</th>
                        <th>Prix</th>
                        <th>Modifier</th>
                        <th>Supprimer</th>
                    </tr>
                    <div class="items">
                    <?php
                    require('../set.php');
                    $sql = "SELECT * FROM `product`";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <tr> 
                            <th>Produitce id: <b><?=$row['idP']?></b></th>
                            <th><?=$row['nameP']?></th>
                            <th><?php
                            if ($row['hasVariables']==0) {
                                echo $row['qtyP'];
                            }else{
                                echo '<a href="product_detail.php?product_detail=' . $row['idP'] . '">Voir Tous</a>';
                            }?></th>
                            <th><?=$row['prixP']?></th>
                            <th>
                            <?php
                            if ($row['hasVariables']==0) {
                                 echo '<a href="index.php?updateId=' . $row['idP'] . '">';
                            }else{
                                echo '<a href="index.php?updateIdVariable=' . $row['idP'] . '">';
                            }?>
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" version="1.1" id="Capa_1" width="20px" height="20px" viewBox="0 0 420.827 420.827" xml:space="preserve">
<g>
    <g>
        <path d="M210.29,0C156,0,104.43,20.693,65.077,58.269C25.859,95.715,2.794,146.022,0.134,199.921    c-0.135,2.734,0.857,5.404,2.744,7.388c1.889,1.983,4.507,3.105,7.244,3.105h45.211c5.275,0,9.644-4.098,9.979-9.362    c4.871-76.214,68.553-135.914,144.979-135.914c80.105,0,145.275,65.171,145.275,145.276c0,80.105-65.17,145.276-145.275,145.276    c-18.109,0-35.772-3.287-52.501-9.771l17.366-15.425c2.686-2.354,3.912-5.964,3.217-9.468c-0.696-3.506-3.209-6.371-6.592-7.521    l-113-32.552c-3.387-1.149-7.122-0.407-9.81,1.948c-2.686,2.354-3.913,5.963-3.218,9.467L69.71,403.157    c0.696,3.505,3.209,6.372,6.591,7.521c3.383,1.147,7.122,0.408,9.81-1.946l18.599-16.298    c31.946,18.574,68.456,28.394,105.581,28.394c116.021,0,210.414-94.392,210.414-210.414C420.705,94.391,326.312,0,210.29,0z"/>
        <path d="M195.112,237.9h118.5c2.757,0,5-2.242,5-5v-30c0-2.757-2.243-5-5-5h-83.5v-91c0-2.757-2.243-5-5-5h-30    c-2.757,0-5,2.243-5,5v126C190.112,235.658,192.355,237.9,195.112,237.9z"/>
    </g>
</g>
</svg></a></th>
                            <th><a href="index.php?deletId=<?=$row['idP']?>"><svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" width="122.881px" height="122.88px" viewBox="0 0 122.881 122.88" enable-background="new 0 0 122.881 122.88" xml:space="preserve"><g><path fill-rule="evenodd" clip-rule="evenodd" d="M61.44,0c33.933,0,61.441,27.507,61.441,61.439 c0,33.933-27.508,61.44-61.441,61.44C27.508,122.88,0,95.372,0,61.439C0,27.507,27.508,0,61.44,0L61.44,0z M81.719,36.226 c1.363-1.363,3.572-1.363,4.936,0c1.363,1.363,1.363,3.573,0,4.936L66.375,61.439l20.279,20.278c1.363,1.363,1.363,3.573,0,4.937 c-1.363,1.362-3.572,1.362-4.936,0L61.44,66.376L41.162,86.654c-1.362,1.362-3.573,1.362-4.936,0c-1.363-1.363-1.363-3.573,0-4.937 l20.278-20.278L36.226,41.162c-1.363-1.363-1.363-3.573,0-4.936c1.363-1.363,3.573-1.363,4.936,0L61.44,56.504L81.719,36.226 L81.719,36.226z"/></g></svg></a></th>
                        </tr>
                     <?php }}?>
                    </div>
                </div>
                </table>
            </div>


            <div class="report-container">
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

</body>
</html>