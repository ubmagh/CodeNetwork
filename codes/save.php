<?php
if( !isset($_POST['input']))
Header("location:../Profile/");

include "../includes/config.php";
session_start();
$username=$_SESSION['username'];


$filename=$_POST['name'];
$lang=$_POST['lang'];
$code=$_POST['code'];

switch($lang){
case "c":
    $lang="c";
    $ex=".c";
    break;
case "java":
    $lang="java";
    $ex=".java";
    break;
case "cpp":
    $lang="cpp";
    $ex=".cpp";
    break;
case "html":
    $lang="html";
    $ex=".txt";
    break;  
}
$savedFile=fopen("./".$username."/".$lang."/".$filename.$ex,"w+");
fwrite($savedFile,$code);
fclose($savedFile);

exec("./@uncrustify/uncrustify.exe -c ./cfg/defaults.cfg -f ".$filename.$ex." -o ".$filename.$ex."");// format the code file


$date=date("Y-m-d h:i:s");
$mysqli->query("INSERT into codes VALUES ('','$username','$lang','$filename','$date'");
$mysqli->close();
?>