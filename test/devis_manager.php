<?php
require('../set.php');
session_start();
if(!isset($_SESSION['id'])  ||  $_SESSION['role']!=="admin"){
  header('Location: ../Authentification/');
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
            padding: 4px;
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
                    <a href="devis.php" style="all:unset;"><div class="nav-option option12">
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
<table>
    <thead>
        <tr>
            <th>order_id (reference)</th>
            <th>buyer_name</th>
            <th>mail_address</th>
            <th>phoneNumber</th>
            <th>company_name</th>
            <th>address</th>
            <th>order_date</th>
            <th>order_etat</th>
            <th>prix_rest</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $q = "SELECT * FROM `orders`";
        $res = mysqli_query($conn, $q);
        while ($d = mysqli_fetch_assoc($res)) {
                
                echo '<tr>';
                echo '<td><a href="order_id.php?order_id=' . $d['order_id'] . '">' . $d['order_id'] . '</a></td>';
                echo '<td>' . $d['buyer_name'] . '</td>';
                echo '<td>' . $d['mail_address'] . '</td>';
                echo '<td>' . $d['phoneNumber'] . '</td>';
                echo '<td>' . $d['company_name'] . '</td>';
                echo '<td>' . $d['address'] . '</td>';
                echo '<td>' . $d['order_date'] . '</td>';
                echo '<td>' . $d['order_etat'] . '</td>';
                echo '<td>' . $d['prix_rest'] . '</td>';
                echo '</tr>';
            }
        ?>

    </tbody>
</table>
        </div>
    <script src="js/script.js"></script>
</body>
</html>
