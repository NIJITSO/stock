
<?php
require('set.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    $j = 1;
    $i = 1;
while (isset($_POST["idProduct$j"])) {
    $idProductKey = "idProduct$j";
    $qtyProductKey = "qtyProduct$j";
    $idPP=$_POST["idProduct$j"];
    $qtyPP=$_POST["qtyProduct$j"];
    if (isset($_POST[$qtyProductKey]) && !empty($_POST[$qtyProductKey])) {
        $sql = "UPDATE product SET qtyP = qtyP - $qtyPP WHERE `product`.`idP` = $idPP";
        // Execute the SQL query here
        echo $sql."<br>";
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
        // Execute the SQL query here
        echo $sql."<br>";
    }

    $i++;
}


    $conn->close();

}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Product Table</title>
    <style>
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
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>idP</th>
                <th>nameP</th>
                <th>Sizes</th>
                <th>PU</th>
                <th>QTY</th>
                <th>PU * QTY</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>DESKTOP</td>
                <td>-----</td>
                <td>200</td>
                <td>4</td>
                <td>800</td>
            </tr>
            <tr>
                <td>2</td>
                <td>RED BOUBIN</td>
                <td>30mm</td>
                <td>60</td>
                <td>23</td>
                <td>1380</td>
            </tr>
            <tr>
                <td>3</td>
                <td>GREEN BOUBIN</td>
                <td>10mm</td>
                <td>30</td>
                <td>12</td>
                <td>360</td>
            </tr>
            <tr>
                <td>3</td>
                <td>GREEN BOUBIN</td>
                <td>40mm</td>
                <td>30</td>
                <td>10</td>
                <td>300</td>
            </tr>
            <tr>
                <td>4</td>
                <td>LAPTOP</td>
                <td>-----</td>
                <td>100</td>
                <td>7</td>
                <td>700</td>
            </tr>
            <tr>
                <td colspan="5">TOTAL</td>
                <td>3740</td>
            </tr>
        </tbody>
    </table>
</body>