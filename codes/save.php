<?php
if (!isset($_POST['input']))
    Header("location:../Profile/");

include "../includes/config.php";
session_start();
$username = $_SESSION['username'];


$filename = $_POST['name'];
$filename = preg_replace('/[^A-Za-z0-9 ]/', '', $filename);
$lang = $_POST['lang'];
$code = $_POST['code'];

switch ($lang) {
    case "c":
        $lang = "c";
        $ex = ".c";
        break;
    case "java":
        $lang = "java";
        $ex = ".java";
        break;
    case "cpp":
        $lang = "cpp";
        $ex = ".cpp";
        break;
    case "html":
        $lang = "html";
        $ex = ".html";
        break;
}
$savedFile = fopen("./" . $username . "/" . $lang . "/" . $filename . $ex, "w+");
fwrite($savedFile, $code);
fclose($savedFile);

if ($ex != ".html")
    exec("./@uncrustify/uncrustify.exe -c ./cfg/defaults.cfg -f " . $filename . $ex . " -o " . $filename . $ex . ""); // format the code file

//if the user has saved a code twice in the same language with the same name Filecode will be erased but in database 
//it will be saved twice So we should Delete the old one 

$mysqli->query("DELETE FROM codes WHERE username='$username' and langType='$lang' and name='$filename' ");

$date = date("Y-m-d h:i:s");
$mysqli->query("INSERT into codes VALUES ('','$username','$lang','$filename','$date') ");
$mysqli->close();
