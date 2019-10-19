<?php

if (empty($_GET['pid'])) {
    header("location:./");
}
session_start();
include "../includes/config.php";

$username = $_SESSION['username'];
$pid = $_GET['pid'];

$Query = $mysqli->query("SELECT * FROM posts WHERE id='$pid' ;");
$Post = $Query->fetch_assoc();

if (empty($Post['id'])) { //// if post not found
    echo '
    <div class="alert alert-danger p-2 col-12" role="alert">
        <strong>Post Not Found ! </strong> possibly deleted by user !
    </div>
    ';
    return;
}

if (empty($Post['postRef'])) {
    //getting back original post

    $Posterusername = $Post['username'];
} else {

    //// Getting original post ://
    $pid = $Post['postRef'];
    $Query = $mysqli->query("SELECT * FROM posts WHERE id='$pid' ;");
    $Post = $Query->fetch_assoc();
    $Posterusername = $Post['username'];
}


$Query = $mysqli->query("SELECT Fname,Lname,avatarEXT FROM users WHERE Email in(SELECT Email FROM profiles WHERE username='$Posterusername') ;");
$Owner = $Query->fetch_assoc();


echo '
            <a class="tweetEntry-account-group" href="./?username=' . $Posterusername . '">
            <img class="tweetEntry-avatar" src="../Profile/Avatars/' . $Posterusername . '.' . $Owner['avatarEXT'] . '">

            <strong class="tweetEntry-fullname">
            ' . $Owner['Fname'] . ' ' . $Owner['Lname'] . '
            </strong>

            <span class="tweetEntry-username">
            @<b>' . $Posterusername . '</b>
            </span>
            </a>
            <a class="tweetEntry-account-group" href="../posts/?post=' . $Post['id'] . '">
            <span class="tweetEntry-timestamp ml-1"> ' . $Post['postingDate'] . '</span>
            </a>

            <div class="tweetEntry-text-container mt-2">
                  ' . $Post['Post'] . '  
            </div>';

if (!empty($Post['codeID'])) {
    $CODEID = $Post['codeID'];
    $getCodeInfos = $mysqli->query("SELECT * From codes WHERE id='$CODEID';");
    $getCodeInfos = $getCodeInfos->fetch_assoc();
    $codeURL = "../Playground/" . $getCodeInfos['langType'] . "/index.php?id=" . $CODEID;

    if (!empty($getCodeInfos['id']))
        echo '
                              <div class="text-center"> 
                              <p><i class="fa fa-code d-inline-block text-success pt-2" aria-hidden="true"></i> <a href="' . $codeURL . '" target="_blank"> <span>' . $getCodeInfos['name'] . '</span></a> <i class="fa fa-code d-inline-block text-success pt-2" aria-hidden="true"></i></p>
                              </div>
                              ';
}
//if there is an image included
$imgid = explode('.', $Post['img']);
if (!empty($Post['img'])) {
    echo '
            <div class="optionalMedia text-center mr-5">
              <img id="img' . $imgid[0] . '" onclick="imgTrigger(' . "'img" . $imgid[0] . "'" . ')" class="optionalMedia-img myImg col-12" src="../sharedPics/' . $Post['img'] . '">
            </div>';
}
echo '
</div></div>
</div>
';
