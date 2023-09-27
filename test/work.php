<?php
require('../set.php');
session_start();
if(!isset($_SESSION['id'])  ||  $_SESSION['role']!=="admin"){
  header('Location: ../Authentification/');
}




// Fetch products from the database
$sql = "SELECT * FROM `product`"; // Use the correct table name for products
$result = mysqli_query($conn, $sql);

$products = array(); // An array to store product data

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$buyer_name=$_POST['buyer_name'];
$mail_address=$_POST['mail_address'];
$phoneNumber=$_POST['phoneNumber'];
$company_name=$_POST['company_name'];
$address=$_POST['address'];


    $sosiete="INSERT INTO orders (order_id, buyer_name, mail_address, phoneNumber, company_name, address, order_etat, prix_rest) VALUES (NULL, '$buyer_name', '$mail_address', '$phoneNumber', '$company_name', 'address', 'encoure', 0.00)";
    $saveOrder=mysqli_query($conn, $sosiete);
    $lastInsertedId = mysqli_insert_id($conn);


    
    $j = 1;
    $i = 1;
    $k = 1;
    $l = 1;
while (isset($_POST["idProduct$j"])) {
    $idProductKey = "idProduct$j";
    $qtyProductKey = "qtyProduct$j";
    $idPP=$_POST["idProduct$j"];
    $qtyPP=$_POST["qtyProduct$j"];
    if (isset($_POST[$qtyProductKey]) && !empty($_POST[$qtyProductKey])) {
        $sql = "UPDATE product SET qtyP = qtyP - $qtyPP WHERE `product`.`idP` = $idPP";
        $sql2 = "INSERT INTO order_detail (order_id, idP, idSize, Qty) VALUES ($lastInsertedId, $idPP, NULL, $qtyPP)";
        $exec=mysqli_query($conn, $sql);
        $exec2=mysqli_query($conn, $sql2);
    }

    $j++;
}



while (isset($_POST['idP' . $i])) {
    $idP = $_POST['idP' . $i];
    $idSize = $_POST['idSize' . $i];
    $qty = $_POST['qty' . $i];

    if (isset($qty) && !empty($qty)) {
        //echo "id Du Produits : " . $idP . " id Du Size : " . $idSize . " La quantite du size : " . $qty . "<br>";
        $sql = "UPDATE product_detail SET qty = qty - {$qty} WHERE idP = {$idP} AND idSize = {$idSize}";
        $sql2 = "INSERT INTO order_detail (order_id, idP, idSize, Qty) VALUES ($lastInsertedId, $idP, $idSize, $qty)";
        $exec=mysqli_query($conn, $sql);
        $exec2=mysqli_query($conn, $sql2);
    }

    $i++;
}

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
        <style>

        h1, h3 {
            text-align: justify; /* Justify the text in headers */
        }
        body {
            font-family: Arial, sans-serif; /* Choose a readable font */
        }
        h1 {
            font-size: 24px; /* Adjust the font size for the h1 header */
        }
        h3 {
            font-size: 18px; /* Adjust the font size for the h3 headers */
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }
        .container{
            display: flex;
            width: 100%;
            flex-direction: column;
            align-items: flex-start;
        }

        /* CSS to hide the divs by default */
        #Product div {
            display: none;
        }
        #societe {
            display: block;
        }
    </style>
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
                    <a href="devis.php" style="all:unset;"><div class="nav-option option1">
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
    <div class="container">
        <div>
            <h1>Sosiete</h1>
            <p>buyer_name: <?=$_POST['buyer_name']?></p>
            <p>mail_address: <?=$_POST['mail_address']?></p>
            <p>Fix: <?=$_POST['phoneNumber']?></p>
            <p>company_name: <?=$_POST['company_name']?></p>
            <p>address: <?=$_POST['address']?></p>
        </div>
        <div>
            <h1>Order Nr:<?=$lastInsertedId?></h1>
        </div>
    </div>
    <div class="container">
        <h1>Devis</h1>
    </div>
<table>
    <thead>
        <tr>
            <th>idP</th>
            <th>nameP</th>
            <th>Sizes</th>
            <th>PU (DH)</th>
            <th>QTY</th>
            <th>PU * QTY</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $j = 1;
        $i = 1;
        $total = 0; // Initialize the total variable

        while (isset($_POST["idProduct$j"])) {
            $idProductKey = "idProduct$j";
            $qtyProductKey = "qtyProduct$j";
            $idPP = $_POST["idProduct$j"];
            $qtyPP = $_POST["qtyProduct$j"];
            if (isset($_POST[$qtyProductKey]) && !empty($_POST[$qtyProductKey])) {

                $q = "SELECT * FROM `product` WHERE `product`.`idP` = $idPP";
                $res = mysqli_query($conn, $q);
                $d = mysqli_fetch_assoc($res);

                $subtotal = $d['prixP'] * $qtyPP; // Calculate the subtotal for this row
                $total += $subtotal; // Add to the total

                echo '<tr>';
                echo "<td>$idPP</td>";
                echo '<td>' . $d['nameP'] . '</td>';
                echo '<td>-----</td>';
                echo '<td>' . $d['prixP'] . ' DH</td>';
                echo "<td>$qtyPP</td>";
                echo '<td>' . $subtotal . '</td>';
                echo '</tr>';
            }

            $j++;
        }

        while (isset($_POST['idP' . $i])) {
            $idP = $_POST['idP' . $i];
            $idSize = $_POST['idSize' . $i];
            $qty = $_POST['qty' . $i];

            if (isset($qty) && !empty($qty)) {
                $sql = "UPDATE product_detail SET qty = qty - {$qty} WHERE idP = {$idP} AND idSize = {$idSize}";
                $q = "SELECT p.idP ,p.prixP ,p.nameP , s.sizeValue, pd.qty
                    FROM product_detail pd
                    JOIN product p ON pd.idP = p.idP
                    JOIN size s ON pd.idSize = s.idSize
                    WHERE p.idP={$idP} AND s.idSize = {$idSize}
                    ";
                $res = mysqli_query($conn, $q);
                $d = mysqli_fetch_assoc($res);

                $subtotal = $d['prixP'] * $qty; // Calculate the subtotal for this row
                $total += $subtotal; // Add to the total

                echo '<tr>';
                echo '<td>' . $d['idP'] . '</td>';
                echo '<td>' . $d['nameP'] . '</td>';
                echo '<td>' . $d['sizeValue'] . '</td>';
                echo '<td>' . $d['prixP'] . ' DH</td>';
                echo "<td>$qty</td>";
                echo '<td>' . $subtotal . '</td>';
                echo '</tr>';
            }

            $i++;
        }
        $update="UPDATE `orders` SET `prix_rest` = $total WHERE `orders`.`order_id` = $lastInsertedId";
        echo $update;
        $updateOrder=mysqli_query($conn,$update);
        ?>

        <tr>
            <td colspan="5">TOTAL</td>
            <td><?php echo $total; ?> DH</td> <!-- Display the calculated total -->
        </tr>
    </tbody>
</table>

</div>
    <script src="js/script.js"></script>
</body>
</html>
