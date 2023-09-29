<?php
require('../set.php');
session_start();
echo $_SESSION['delet_order'];
if(!isset($_SESSION['id'])  ||  $_SESSION['role']!=="admin"){
  header('Location: ../Authentification/');
}
if (isset($_SESSION['delet_order'])) {
    $sql0="SELECT * FROM `order_detail` WHERE order_id = '{$_SESSION['delet_order']}'";
    $res=mysqli_query($conn, $sql0);
    while ($data=mysqli_fetch_assoc($res)) {
        if (!isset($data['idSize'])) {
            $sqlUpdate1 = "UPDATE product SET qtyP = qtyP + {$data['Qty']} WHERE `product`.`idP` = {$data['idP']}";
            mysqli_query($conn, $sqlUpdate1);

        }else{
           $sqlUpdate2 = "UPDATE `product_detail` SET `qty` = `qty` + {$data['Qty']} WHERE `product_detail`.`idP` = {$data['idP']} AND `product_detail`.`idSize` = {$data['idSize']}";
            mysqli_query($conn, $sqlUpdate2);
        }
    }
    $sql1="DELETE FROM order_detail WHERE order_id = '{$_SESSION['delet_order']}'";
    $required=mysqli_query($conn, $sql1);
    if ($required) {
        $sql2="DELETE FROM orders WHERE `orders`.`order_id` = '{$_SESSION['delet_order']}'";
        $required2=mysqli_query($conn, $sql2);
    }
    header("Location: devis_manager.php");
}
else{
    echo "un error interrompu";
}
?>