<?php
if(!isset($_POST['F'])){
    Header("location:./");
}

$filename=$_POST['F'];

exec("del $filename");



?>