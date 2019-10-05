<?php 
session_start();


unset($_SESSION['Uemail']);
unset($_SESSION['User']);
header("location:../");
?>