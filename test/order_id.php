<?php
require('../set.php');
session_start();
if(!isset($_SESSION['id'])  ||  $_SESSION['role']!=="admin"){
  header('Location: ../Authentification/');
}
if (isset($_GET['order_id'])) {
    $orderID=$_GET['order_id'];
    $order = "SELECT * FROM `orders` WHERE order_id = $orderID";
    $exec=mysqli_query($conn,$order);
    $orderData=mysqli_fetch_assoc($exec);
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
            justify-content: space-between;
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
                    <a href="devis.php" style="all:unset;"><div class="nav-option option2">
                        <img src="img/message.png"
                            class="nav-img"
                            alt="dashboard">
                        <h3> Ajouter Un devis</h3>
                    </div></a>
                    <a href="devis_manager.php" style="all:unset;"><div class="nav-option option1">
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
            <div>
                <div>
                    <h1>Order Nr:<?=$orderID?></h1>
                </div>
            </div>
            <h3>Sosiete</h3>
            <p>buyer_name: <?=$orderData['buyer_name']?></p>
            <p>mail_address: <?=$orderData['mail_address']?></p>
            <p>Fix: <?=$orderData['phoneNumber']?></p>
            <p>company_name: <?=$orderData['company_name']?></p>
            <p>address: <?=$orderData['address']?></p>
        </div>
        <div>
            <h3><a href="print.php?order_id=<?=$orderID?>">Imprimer</a></h3>
        </div>

    </div>
    <div class="container">
        <h3>Detait de Devis No: <?=$orderID?></h3>
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
        $total = 0; // Initialize the total variable
        $q = "SELECT
                    od.id_OPQ,
                    o.order_id orderId,
                    p.idP AS idProduct,
                    p.nameP AS ProductName,
                    s.sizeValue AS Size,
                    p.prixP AS PricePerUnit,
                    od.Qty AS Quantity
                FROM
                    order_detail od
                INNER JOIN
                    orders o ON od.order_id = o.order_id
                INNER JOIN
                    product p ON od.idP = p.idP
                LEFT JOIN
                    size s ON od.idSize = s.idSize
                WHERE
                    o.order_id = $orderID
                    AND s.idSize IS NULL";
        $res = mysqli_query($conn, $q);
                $q2 = "SELECT
                        od.id_OPQ,
                        o.order_id orderId,
                        p.idP AS idProduct,
                        p.nameP AS ProductName,
                        s.sizeValue AS Size,
                        p.prixP AS PricePerUnit,
                        od.Qty AS Quantity
                    FROM
                        order_detail od
                    INNER JOIN
                        orders o ON od.order_id = o.order_id
                    INNER JOIN
                        product p ON od.idP = p.idP
                    LEFT JOIN
                        size s ON od.idSize = s.idSize
                    WHERE
                        o.order_id = $orderID
                        AND s.idSize IS NOT NULL";
        $res2 = mysqli_query($conn, $q2);

        while ($d = mysqli_fetch_assoc($res)) {

                $subtotal = $d['PricePerUnit'] * $d['Quantity']; // Calculate the subtotal for this row
                $total += $subtotal; // Add to the total

                echo '<tr>';
                echo '<td>' . $d['idProduct'] . '</td>';
                echo '<td>' . $d['ProductName'] . '</td>';
                echo '<td>-----</td>';
                echo '<td>' . $d['PricePerUnit'] . ' DH</td>';
                echo '<td>' . $d['Quantity'] . ' DH</td>';
                echo '<td>' . $subtotal . '</td>';
                echo '</tr>';
            }
        

        while ($d2 = mysqli_fetch_assoc($res2)) {


                $subtotal = $d2['PricePerUnit'] * $d2['Quantity']; // Calculate the subtotal for this row
                $total += $subtotal; // Add to the total

                echo '<tr>';
                echo '<td>' . $d2['idProduct'] . '</td>';
                echo '<td>' . $d2['ProductName'] . '</td>';
                echo '<td>' . $d2['Size'] . '</td>';
                echo '<td>' . $d2['PricePerUnit'] . ' DH</td>';
                echo '<td>' . $d2['Quantity'] . ' DH</td>';
                echo '<td>' . $subtotal . '</td>';
                echo '</tr>';
            }

        
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
