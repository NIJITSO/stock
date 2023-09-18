<?php
require('../set.php');
session_start();
if (isset($_SESSION['deletIdCat'])) {
    $sql="DELETE FROM size WHERE `size`.`idSize` = '{$_SESSION['deletIdCat']}'";
    mysqli_query($conn, $sql);
    header("Location: index.php");
}
else{
    echo "un error interrompu";
}



?>