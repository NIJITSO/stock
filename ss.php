<?php
require('set.php');
session_start();

// Function to generate the table row dynamically
function generateTableRow($idP, $nameP, $Sizes, $PU, $QTY, $PU_QTY) {
    return "<tr>
                <td>$idP</td>
                <td>$nameP</td>
                <td>$Sizes</td>
                <td>$PU</td>
                <td>$QTY</td>
                <td>$PU_QTY</td>
            </tr>";
}

// Initialize variables
$tableRows = '';
$totalPU_QTY = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $j = 1;
    $i = 1;

    while (isset($_POST["idProduct$j"])) {
        $idProductKey = "idProduct$j";
        $qtyProductKey = "qtyProduct$j";
        $idPP = $_POST["idProduct$j"];
        $qtyPP = $_POST["qtyProduct$j"];

        if (isset($_POST[$qtyProductKey]) && !empty($_POST[$qtyProductKey])) {
            $sql = "UPDATE product SET qtyP = qtyP - $qtyPP WHERE `product`.`idP` = $idPP";
            // Execute the SQL query here
            echo $sql . "<br>";
        }

        $j++;
    }

    while (isset($_POST['idP' . $i])) {
        $idP = $_POST['idP' . $i];
        $idSize = $_POST['idSize' . $i];
        $qty = $_POST['qty' . $i];

        if (isset($qty) && !empty($qty)) {
            $sql = "UPDATE product_detail SET qty = qty - {$qty} WHERE idP = {$idP} AND idSize = {$idSize}";
            // Execute the SQL query here
            echo $sql . "<br>";
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
            <?php
            // Example data - you can replace this with your actual data
            $data = array(
                array(1, 'DESKTOP', '-----', 200, 4),
                array(2, 'RED BOUBIN', '30mm', 60, 23),
                array(3, 'GREEN BOUBIN', '10mm', 30, 12),
                array(3, 'GREEN BOUBIN', '40mm', 30, 10),
                array(4, 'LAPTOP', '-----', 100, 7)
            );

            foreach ($data as $row) {
                $idP = $row[0];
                $nameP = $row[1];
                $Sizes = $row[2];
                $PU = $row[3];
                $QTY = $row[4];
                $PU_QTY = $PU * $QTY;

                // Update total
                $totalPU_QTY += $PU_QTY;

                // Generate the table row dynamically
                $tableRows .= generateTableRow($idP, $nameP, $Sizes, $PU, $QTY, $PU_QTY);
            }

            // Print the table rows
            echo $tableRows;

            // Print the total row
            echo "<tr><td colspan='5'>TOTAL</td><td>$totalPU_QTY</td></tr>";
            ?>
        </tbody>
    </table>
</body>
</html>
