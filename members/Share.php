<?php

if (empty($_GET['pid'])) {
    header("location:./");
}

include "../includes/config.php";
session_start();

$username = $_SESSION['username'];
$pid = $_GET['pid'];
$Post = $_GET['POST'];
$date = date("Y-m-d h:i:s");
/// dans ce cas on va remplir seulement dans table posts : id, postRef,Post
//// check if not already a shared post

$Query = $mysqli->query("SELECT * FROM posts WHERE id='$pid' ;");
$sharedPost = $Query->fetch_assoc();

if (empty($sharedPost['postRef'])) { ///means user is sharing the post directly (##not from a shared post of it##)
    if ($mysqli->query("INSERT INTO posts VALUES ('','$pid','$username','','','$date','$Post') ;"))
        echo 'true';
    else
        echo 'false';
    ////
} else {
    //if the post is already shared but it is requested to be shared again means postRef not empty

}
