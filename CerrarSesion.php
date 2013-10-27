<?php

session_start();
if (!isset($_POST['usuario'])) {
    header('location:index.php');
}
session_destroy();
header("Location:index.php?e=2");
?>
