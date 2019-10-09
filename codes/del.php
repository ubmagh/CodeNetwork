<?php 
if(!isset($_POST['id'])){
    header("location:./");
}
session_start();
include "../includes/config.php";
$id=$_POST['id'];
$lang=$_POST['lang'];
$username=$_SESSION['username'];


// check code owner
$getCodeUsername=$mysqli->query("SELECT username,name FROM codes WHERE id='$id'");
$getCodeUsername=$getCodeUsername->fetch_assoc();

switch($lang){
    case 'c':
            $ex=".c";
            break;
    case 'cpp':
            $ex=".cpp";
            break;
    case 'java':
            $ex=".java";
            break;
    case 'html':
            $ex=".html";
            break;
}
$filename=$getCodeUsername['name'];

//delete file from folder before database
$filePath="./".$username."/".$lang."/".$filename.$ex;
unlink($filePath);


if( $username == $getCodeUsername['username'] ){
$mysqli->query("DELETE FROM codes WHERE id='$id';");
}

?>