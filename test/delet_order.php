<?php
require('../set.php');
session_start();
echo $_SESSION['delet_order'];
if(!isset($_SESSION['id'])  ||  $_SESSION['role']!=="admin"){
  header('Location: ../Authentification/');
}
if (isset($_SESSION['delet_order'])) {
    $sql1="DELETE FROM order_detail WHERE order_id = '{$_SESSION['delet_order']}'";
    echo $sql1;

    $required=mysqli_query($conn, $sql1);
    if ($required) {
        $sql2="DELETE FROM orders WHERE `orders`.`order_id` = '{$_SESSION['delet_order']}'";
        $required=mysqli_query($conn, $sql2);
            echo "<br>".$sql2;
    }
    header("Location: devis_manager.php");
}
else{
    echo "un error interrompu";
}



?>