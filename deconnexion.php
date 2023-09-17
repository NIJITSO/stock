<?php
session_start();
session_unset();
header("Location: Authentification/login.php");
?>