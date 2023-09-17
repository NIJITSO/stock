<?php
require('../set.php');
session_start();
if (isset($_SESSION['deletIdM'])) {
    $sql="DELETE FROM formulaire WHERE `formulaire`.`id` = '{$_SESSION['deletIdM']}'";
    echo $sql;
    mysqli_query($conn, $sql);
    header("Location: messages.php");
}
else{
    echo "un error interrompu";
}


?>