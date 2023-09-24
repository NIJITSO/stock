<?php
require('../set.php');
session_start();
if(!isset($_SESSION['id'])  ||  $_SESSION['role']!=="admin"){
  header('Location: ../Authentification/');
}
if (isset($_SESSION['deletId'])) {
    $sql1="DELETE FROM `product_detail` WHERE `product_detail`.`idP` = '{$_SESSION['deletId']}'";
    $required=mysqli_query($conn, $sql1);
    if ($required) {
        $sql2="DELETE FROM product WHERE `product`.`idP` = '{$_SESSION['deletId']}'";
        $required=mysqli_query($conn, $sql2);
    }
    header("Location: index.php");
}
else{
    echo "un error interrompu";
}



?>