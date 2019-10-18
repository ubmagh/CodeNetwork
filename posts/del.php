<?php
if(!isset($_POST['pid'])){
    header("location:./");
}
include "../includes/config.php";
session_start();
$username=$_SESSION['username'];
$pid=$_POST['pid'];

$GetPostOwner=$mysqli->query("SELECT username,img FROM posts where id='$pid' ;");
$GetPostOwner=$GetPostOwner->fetch_assoc();

if( $GetPostOwner['username'] == $username ){ // the owner who can delete his post :/
    
    //before deleting post we delete its image if exists

    if(!empty($GetPostOwner['img'])){
        unlink("../sharedPics/".$GetPostOwner['img']);
    }
    $mysqli->query("DELETE FROM posts WHERE id='$pid' ;");
    
    /// Deleting Comments on this post

    $mysqli->query("DELETE FROM comments WHERE PostID='$pid';");

    ///// and Likes also I FORGET ABOUT THEM :/

    $mysqli->query("DELETE FROM likes WHERE PostID='$pid';");


    echo 'true';
    
}else{
    echo 'false';
}

?>