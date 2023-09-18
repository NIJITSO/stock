<?php
require('../set.php');
if (isset($_GET['product_detail'])) {
    $prodID=$_GET['product_detail'];
    $qp="SELECT * FROM `product` WHERE idP=$prodID";
    $qt="SELECT
    SUM(pd.qty) AS total_quantity
    FROM
        product p
    LEFT JOIN
        product_detail pd ON p.idP = pd.idP
    WHERE p.idP=$prodID";
    $resultt = mysqli_query($conn, $qt);
    $resultp = mysqli_query($conn, $qp);
    $rowt = mysqli_fetch_assoc($resultt);
    $rowp = mysqli_fetch_assoc($resultp);
}


// $q="SELECT p.idP AS `idX` ,p.nameP AS `nameX` , s.sizeValue AS `sizeValueX`, pd.qty AS `qtyX`
//   FROM product_detail pd
//   JOIN product p ON pd.idP = p.idP
//   JOIN size s ON pd.idSize = s.idSize
//   WHERE p.idP=$prodID";
//   $result = mysqli_query($conn, $q);
//   if (mysqli_num_rows($result) > 0) {
//   $row = mysqli_fetch_assoc($result);
//   }
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
     th,th{
        padding: 10px 30px;
     }   
    </style>
    <script defer src="js/script.js"></script>
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
                    <a href="index.php" style="all:unset;"><div class="nav-option option1">
                        <img src="img/dashboard.jpg"
                            class="nav-img"
                            alt="dashboard">
                        <h3> Dashboard</h3>
                    </div></a>
                    <a href="messages.php" style="all:unset;"><div class="nav-option option2">
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
                        <h2 class="topic-heading"><?=$rowt['total_quantity']?></h2>
                        <h2 class="topic">Total quantiler pour Produit id <b><?=$prodID?></b></h2>
                    </div>
 
                    <img src=
"img/somme.png"
                         alt="likes">
                </div>
 
 
            <div class="report-container">
                <div class="report-header">
                    <h1 class="recent-Articles">Detail du Produit:  <?=$rowp['nameP']?></h1>
                </div>
 
                <div class="report-body">
                    <table cellpadding="10" cellspacing="0">
                        <tr>
                            <th class="t-op">Produit ID</th>
                            <th class="t-op">Titre du Produit</th>
                            <th class="t-op">Taill du produits(Size)</th>
                            <th class="t-op">Quantite</th>
                        </tr>
                        <?php
                        $q="SELECT p.idP AS `idX` ,p.nameP AS `nameX` , s.sizeValue AS `sizeValueX`, pd.qty AS `qtyX`
                            FROM product_detail pd
                            JOIN product p ON pd.idP = p.idP
                            JOIN size s ON pd.idSize = s.idSize
                            WHERE p.idP=$prodID";
                            $result = mysqli_query($conn, $q);
                            if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <th class="t-op-nextlvl"><?=$row['idX']?></th>
                            <th class="t-op-nextlvl"><?=$row['nameX']?></th>
                            <th class="t-op-nextlvl"><?=$row['sizeValueX']?></th>
                            <th class="t-op-nextlvl"><?=$row['qtyX']?></th>
                        </tr>
                    <?php }}?>
                    </table>
            </div>
        </div>
    </div>
</body>
</html>