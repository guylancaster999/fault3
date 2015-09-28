<?php
session_start();
$_SESSION["adminUser"] ="#";
$_SESSION["systemName"]="#";
header("location:index.php");
?>