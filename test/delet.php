<?php
require('../set.php');
session_start();
if (isset($_SESSION['deletId'])) {
    $sql="DELETE FROM items_table WHERE `items_table`.`id` = '{$_SESSION['deletId']}'";
    mysqli_query($conn, $sql);
    header("Location: index.php");
}
else{
    echo "un error interrompu";
}



?>