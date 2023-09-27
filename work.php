<?php
require('set.php');
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sosiete="INSERT INTO orders (order_id, buyer_name, mail_address, phoneNumber, company_name, address, order_date, order_etat, prix_rest) VALUES (NULL, 'badr', 'badr@qwe', '070723241', 'MDWHITE', '123, Casa', '2023-09-24', 'encoure', 3000.00)";
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
<html>
<head>
    <title>Product Table</title>
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Sosiete</h1>
        <p>Nom: <?=$_POST['nameSosiete']?></p>
        <p>Fix: <?=$_POST['telSosiete']?></p>
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
        ?>

        <tr>
            <td colspan="5">TOTAL</td>
            <td><?php echo $total; ?> DH</td> <!-- Display the calculated total -->
        </tr>
    </tbody>
</table>
