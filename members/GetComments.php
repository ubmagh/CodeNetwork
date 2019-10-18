<?php

if (!isset($_POST['pid'])) {
  header("location:./");
}

include "../includes/config.php";
session_start();
$pid = $_POST['pid'];
$username = $_POST['poster'];

//////////////////////////////////////////
//////////////////////////////////////////
/// In this Case we ignored Shared Post //
//////////////////////////////////////////
//////////////////////////////////////////


$Query = $mysqli->query("SELECT * FROM posts WHERE id='$pid' ; ");
$getPost = $Query->fetch_assoc();

$Query = $mysqli->query("SELECT Fname,Lname,avatarEXT FROM users where Email=(SELECT Email FROM profiles WHERE username='$username');");
$getPostOwner = $Query->fetch_assoc();

$TO_echo = '
<div class="tweetEntry-tweetHolder bg-light text-dark border border-secondary mb-3 pt-2 pb-4" style="width:100%;">
              <div class="tweetEntry pb-2 border-0">
  
                <div class="tweetEntry-content">
    
                  <a class="tweetEntry-account-group" href="./index.php?username=' . $getPost['username'] . '">
                      <img class="tweetEntry-avatar" src="../Profile/Avatars/' . $getPost['username'] . '.' . $getPostOwner['avatarEXT'] . '">
                      
                      <strong class="tweetEntry-fullname">
                      ' . $getPostOwner['Fname'] . ' ' . $getPostOwner['Lname'] . '
                      </strong>
                      
                      <span class="tweetEntry-username">
                        @<b>' . $username . '</b>
                      </span>
                  </a>
                  <a class="tweetEntry-account-group" href="../posts/index.php?post=' . $getPost['id'] . '">
                  <span class="tweetEntry-timestamp ml-1"> ' . $getPost['postingDate'] . '</span>
                  </a>
                  <div class="tweetEntry-text-container mt-1" style="left:30px;">
                  ' . $getPost['Post'] . '  
                  </div>

';

if (!empty($getPost['codeID'])) {
  $CODEID = $getPost['codeID'];
  $getCodeInfos = $mysqli->query("SELECT * From codes WHERE id='$CODEID';");
  $getCodeInfos = $getCodeInfos->fetch_assoc();
  $codeURL = "../Playground/" . $getCodeInfos['langType'] . "/index.php?id=" . $CODEID;

  if (!empty($getCodeInfos['id']))
    $TO_echo = $TO_echo . '
    <div class="text-center"> 
    <p><i class="fa fa-code d-inline-block text-success pt-2" aria-hidden="true"></i> <a href="' . $codeURL . '" target="_blank"> <span>' . $getCodeInfos['name'] . '</span></a> <i class="fa fa-code d-inline-block text-success pt-2" aria-hidden="true"></i></p>
    </div>
    ';
}
$TO_echo = $TO_echo . '</div>';

//if there is an image included
$imgid = explode('.', $getPost['img']);
if (!empty($getPost['img'])) {
  $TO_echo = $TO_echo . '
<div class="optionalMedia text-center mr-5">
  <img id="img' . $imgid[0] . '"  class="optionalMedia-img myImg" src="../sharedPics/' . $getPost['img'] . '">
</div>';
}

$TO_echo = $TO_echo . '</div></div>';

$Query = $mysqli->query("SELECT * FROM comments where PostID='$pid';");
while ($GetComment = $Query->fetch_assoc()) {
  $CommentorUSERname = $GetComment['username'];
  $CommentOWnerInfos = $mysqli->query("SELECT Lname,Fname,avatarEXT FROM users where Email=(SELECT Email FROM profiles WHERE username='$CommentorUSERname');");
  $CommentOWnerInfos = $CommentOWnerInfos->fetch_assoc();
  $TO_echo = $TO_echo . '
    <div class="tweetEntry-tweetHolder bg-light text-dark border border-secondary mb-1 py-0 d-block"  style="width:90%;">
        <div class="tweetEntry py-1 border-0">
            <div class="tweetEntry-content">
                 <a class="tweetEntry-account-group" href="./index.php?username=' . $CommentorUSERname . '">
                      <img class="tweetEntry-avatar" src="../Profile/Avatars/' . $CommentorUSERname . '.' . $CommentOWnerInfos['avatarEXT'] . '">
                      
                      <strong class="tweetEntry-fullname">
                      ' . $CommentOWnerInfos['Fname'] . ' ' . $CommentOWnerInfos['Lname'] . '
                      </strong>
                      
                      <span class="tweetEntry-username">
                        @<b>' . $CommentorUSERname . '</b>
                      </span>
                        <span class="tweetEntry-timestamp ml-1">' . $GetComment['date'] . '</span>
                  </a>
                    
                  <div class="row">
                        <div class="tweetEntry-text-container mt-2 ml-3 pb-1">
                            ' . $GetComment['comment'] . '';

  if ($CommentorUSERname == $_SESSION['username']) //test pour l'affichage nonpour la supprission
    $TO_echo = $TO_echo . '<span style="cursor:pointer; position:absolute; left:85%;"  onclick="DelCom(' . "'" . $GetComment['id'] . "'" . ',' . "'" . $pid . "'" . ')"><i class="fas fa-trash-alt ml-4 text-danger"></i></span>';
  $TO_echo = $TO_echo . '</div>
                  </div>
            </div>
        </div>
    </div>
        ';
}

//place to submit a comment !

$TO_echo = $TO_echo . '

<div class="col-12 d-block mb-2 mt-0 ml-1">
    <div class="form-row ml-1">
        <input type="text" class="col-8 ml-3 form-control btn-outline-dark bg-light text-dark" id="TheComment" aria-describedby="helpId" placeholder="">
        <button type="button" class="btn btn-light btn-outline-dark col-3 ml-2" onclick="SubmitComment(' . "'" . $pid . "'" . ')">Comment</button>
    </div>
</div>
';

echo $TO_echo;
