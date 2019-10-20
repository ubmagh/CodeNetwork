<?php
session_start();
include "../includes/config.php";

$username = $_SESSION['username'];
$email = $_SESSION['email'];

$Query = $mysqli->query("SELECT count(*) as num FROM userlog WHERE userEmail='$email';");
$NumLogs = $Query->fetch_assoc();

if ($NumLogs['num'] > 1) {
    $NumLogs = $NumLogs['num'] - 1;
    $Query = $mysqli->query("SELECT id FROM userlog WHERE userEmail='$email' order by date ;");
    while ($NumLogs > 0) {
        $Del = $Query->fetch_assoc();
        $id = $Del['id'];
        $mysqli->query("DELETE FROM userlog WHERE id='$id' ;");
        $NumLogs--;
    }
}


unset($_SESSION['email']);
unset($_SESSION['username']);
header("location:../");
