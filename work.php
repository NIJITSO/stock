
<?php
require('set.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    














    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
$j = 1;
while (isset($_POST["idProduct$j"])) {
    $idProductKey = "idProduct$j";
    $qtyProductKey = "qtyProduct$j";

    if (isset($_POST[$qtyProductKey])) {
        echo $_POST[$qtyProductKey] . "<br>";
    }

    $j++;
}


$i = 1;
while (isset($_POST['idP' . $i])) {
    $idP = $_POST['idP' . $i];
    $idSize = $_POST['idSize' . $i];
    $qty = $_POST['qty' . $i];

    if (isset($qty) && !empty($qty)) {
        //echo "id Du Produits : " . $idP . " id Du Size : " . $idSize . " La quantite du size : " . $qty . "<br>";
        $sql = "UPDATE product_detail SET qty = {$qty} WHERE idP = {$idP} AND idSize = {$idSize}";
        // Execute the SQL query here
        echo $sql."<br>";
    }

    $i++;
}

    // Loop through each product update
    for ($i = 1; $i <= 3; $i++) {
        $idP = $_POST["idP$i"];
        $idSize = $_POST["idSize$i"];
        $qty = $_POST["qty$i"];

        // Update the product_detail table
        //$sql = "UPDATE product_detail SET qty = '$qty' WHERE idP = '$idP' AND idSize = '$idSize'";
        // $result = mysqli_query($conn, $sql);
        // echo $sql."<br>";
    }

    // Close the database connection
    $conn->close();

}
?>