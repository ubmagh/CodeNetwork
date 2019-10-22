<?php 
if(!isset($_GET['pid'])){
    header("location:./");
}
session_start();
include "../includes/config.php";
$username=$_SESSION['username'];
$pid=$_GET['pid'];
$comment=$_GET['comment'];
$date=date("Y-m-d h:i:s");


if((!empty($comment))&& ($mysqli->query("INSERT INTO comments VALUES('','$username','$date','$pid','$comment');")) ){
    echo 'true';
}else 
echo 'false';

?>