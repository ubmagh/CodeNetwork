<?php 
include "../includes/config.php";
session_start();
$PID=$_POST['pid'];
$username=$_POST['username'];

if($_SESSION['username']!=$username)
echo 'false';
else{

              $liked=$mysqli->query("SELECT username FROM likes WHERE PostID='$PID';");
              $liked=$liked->fetch_assoc();
              $liked=$liked['username'];
            //check if the post has a like already from the user 
              if($liked==$username){
                    $delete=$mysqli->query("DELETE FROM likes WHERE username='$username' AND PostID='$PID';");
              }else{    
                    $add=$mysqli->query("INSERT INTO likes VALUES ('','$username','$PID');");
              }

$mysqli->close();
echo 'true';
}
?>