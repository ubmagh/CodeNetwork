<?php 
if(!isset($_GET['commentID'])){
    header("location:./");
}
session_start();
include "../includes/config.php";
$username=$_SESSION['username'];
$cid=$_GET['commentID'];

$getCommentOWner=$mysqli->query("SELECT username from comments where id='$cid';");
$getCommentOWner=$getCommentOWner->fetch_assoc();

if($username==$getCommentOWner['username']){
    $mysqli->query("DELETE FROM comments where id='$cid';");
    echo 'true';
}else{
    echo 'false';
}

?>