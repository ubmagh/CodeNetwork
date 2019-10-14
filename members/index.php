<?php 
session_start();
if($_GET['username']==$_SESSION['username']){
    header("location:../profile/");
}
?>