<?php

$appenv = getenv('APP_ENV');

if( !empty($appenv) && strcmp("prodution", $appenv) ){
    $host = getenv('DB_HOST');
    $port = getenv('DB_PORT');
    $dbuser = getenv('DB_USER');
    $dbpass = getenv('DB_PASSWORD');
    $db = getenv('DB_NAME');
}else{
    $dbuser="root";
    $dbpass="secret";
    $host="localhost";
    $db="network";
}
$mysqli =  new mysqli($host,$dbuser,$dbpass,$db);//new mysqli($host,$dbuser,$dbpass,$db);  or  mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
if ( $mysqli->connect_error ) { // $mysqli->connect_error or !$mysqli
    
    echo '
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Database connection Error !</title>
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.js"></script>
</head>
<body>
<div class="alert alert-danger">
<strong>Error !</strong>  Database not Connected !
<br>
'.$mysqli->connect_error.'
</div>
</body>
    ';
    print($mysqli->connect_error);
    exit();
} 

?>