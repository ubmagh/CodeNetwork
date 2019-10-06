<?php 
session_start();


unset($_SESSION['email']);
unset($_SESSION['username']);
header("location:../");
?>