<?php

if (empty($_GET['post']))
  header("location:../dashboard/");

session_start();
include "../includes/config.php";
$username = $_SESSION['username'];

if (!empty($_GET['post'])) {

  $pid = $_GET['post'];

  $Query = $mysqli->query("SELECT * FROM posts WHERE id='$pid' ; ");
  $getPost = $Query->fetch_assoc();

  if (empty($getPost['id'])) {
    echo '
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Post Not Found </title>
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/solid.min.css">
    <link rel="stylesheet" href="../css/regular.min.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../Profile/includes/css/profile.css">
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.js"></script>
</head>
<body style="height:100%;overflow-y: hidden;overflow-x: hidden;" class="bg-white">
<div class="row">

        <div class="display-3 col-2 mt-5 pl-5 ml-5 mr-0">
            <i id="back_btn" style="cursor:pointer;" class="fa fa-arrow-left" aria-hidden="true"></i>
        </div>
        <div class="col-8 ">
        <div class="alert alert-danger p-5 mt-5 text-center" role="alert">
          <strong>Error!</strong> Requested Post not Found ! possibly deleted or does not exist
          <br>
          Use this Button to Go Back 
        </div>
        </div>

</div>
<script> $("#back_btn").click(function (){
  window.history.back();
}); </script>
</body>
    ';
    return;
  }

  $PostOwner = $getPost['username'];

  $owned = false;
  if ($PostOwner == $username) //this post is owned now
    $owned = true;

  $Query = $mysqli->query("SELECT Fname,Lname,avatarEXT FROM users where Email=(SELECT Email FROM profiles WHERE username='$PostOwner');");
  $getPostOwner = $Query->fetch_assoc();

  echo '
    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>' . $PostOwner . ' Post </title>
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/solid.min.css">
    <link rel="stylesheet" href="../css/regular.min.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../Profile/includes/css/profile.css">
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.js"></script>
</head>
<body style="height:100%;overflow-y: hidden;overflow-x: hidden;" class="bg-white">
    

    <div class="container">

    <div class="row">

        <div class="display-3 col-2 mt-5 pl-5 ml-5 mr-0">
            <i id="back_btn" style="cursor:pointer;" class="fa fa-arrow-left" aria-hidden="true"></i>
        </div>

        <div class="tweetEntry-tweetHolder bg-light text-dark border border-secondary mb-3 pt-3 pb-4 col-md-8 mt-5 mr-5 ml-2" style="width:100%;">
                <div class="tweetEntry pb-4 border-0">
    
                    <div class="tweetEntry-content">
        
                    <a class="tweetEntry-account-group" href="../members/?username=' . $PostOwner . '">
                        <img class="tweetEntry-avatar" src="../Profile/Avatars/' . $PostOwner . '.' . $getPostOwner['avatarEXT'] . '">
                        
                        <strong class="tweetEntry-fullname">
                        ' . $getPostOwner['Fname'] . ' ' . $getPostOwner['Lname'] . '
                        </strong>
                        
                        <span class="tweetEntry-username">
                            @<b>' . $PostOwner . '</b>
                        </span>
                    </a>

                    <a class="tweetEntry-account-group" href="./?post=' . $pid . '">
                    <span class="tweetEntry-timestamp ml-1"> ' . $getPost['postingDate'] . '</span>
                    </a>';

  if ($owned == true) echo '
  <div class="d-inline text-right mr-0 float-right">
  <span style="cursor:pointer;" onclick="del(' . "'" . $pid . "'" . ')" class="text-danger"> <i class="fas fa-trash-alt ml-4 text-danger"></i> Delete</span>
  <span style="cursor:pointer;"> <a href="./PostEdit.php?post=' . $pid . '"> <i class="fas fa-pen ml-4 text-info"></i> Edit</a></span>
  </div>
                        ';

  echo '
                    <div class="tweetEntry-text-container mt-1" style="left:30px;">
                    ' . $getPost['Post'] . '  
                    </div></div>';
  if (empty($getPost['postRef'])) {



    if (!empty($getPost['codeID'])) {
      $CODEID = $getPost['codeID'];
      $getCodeInfos = $mysqli->query("SELECT * From codes WHERE id='$CODEID';");
      $getCodeInfos = $getCodeInfos->fetch_assoc();
      $codeURL = "../Playground/" . $getCodeInfos['langType'] . "/index.php?id=" . $CODEID;

      if (!empty($getCodeInfos['id']))
        echo '
                        <div class="text-center mr-5"> 
                        <p><i class="fa fa-code d-inline-block text-success pt-2" aria-hidden="true"></i> <a href="' . $codeURL . '" target="_blank"> <span>' . $getCodeInfos['name'] . '</span></a> <i class="fa fa-code d-inline-block text-success pt-2" aria-hidden="true"></i></p>
                        </div>
                        ';
    }



    //if there is an image included
    $imgid = explode('.', $getPost['img']);
    if (!empty($getPost['img'])) {
      echo '
<div class="optionalMedia text-center mr-5">
  <img id="img' . $imgid[0] . '"  onclick="imgTrigger(' . "'img" . $imgid[0] . "'" . ')" style="max-width:350px;" class="optionalMedia-img myImg" src="../sharedPics/' . $getPost['img'] . '">
</div>';
    }
  } else {

    echo '<div class="my-3 col-10 mx-auto border border-secondary rounded ">
    <div class="col-9 mx-auto px-1" style="max-width:90%;"> 
';
    /////Shared post start
    $SharedID = $getPost['postRef'];
    $getter = $mysqli->query("SELECT * FROM posts WHERE id='$SharedID' ;");
    $SharedPost = $getter->fetch_assoc();
    $OwnerUsername = $SharedPost['username'];
    $owner = $mysqli->query("SELECT Fname,Lname,avatarEXT FROM users WHERE Email in (SELECT Email FROM profiles WHERE username='$OwnerUsername') ;");
    $owner = $owner->fetch_assoc();

    if (empty($SharedPost['id'])) { /// if the shared post 's original is deleted
      echo '
  <div class="alert alert-danger btn-block text-center px-5 py-4 mb-n1 mt-n1  " role="alert">
    <strong> Post not found ! </strong>
  </div>
  ';
    } else {
      echo '
<div class="tweetEntry-tweetHolder bg-light text-dark ml-n2 mr-2 mb-2" style="max-width:100%">
  <div class="tweetEntry ">

    <div class="tweetEntry-content" >

      <a class="tweetEntry-account-group" href="../members/?username=' . $OwnerUsername . '">
          <img class="tweetEntry-avatar" src="../Profile/Avatars/' . $OwnerUsername . '.' . $owner['avatarEXT'] . '" class="col-12" style="max-width:90%;">
          
          <strong class="tweetEntry-fullname">
          ' . $owner['Fname'] . ' ' . $owner['Lname'] . '
          </strong>
          
          <span class="tweetEntry-username">
            @<b>' . $OwnerUsername . '</b>
          </span>
      </a>
      <a class="tweetEntry-account-group" href="../posts/?post=' . $SharedID . '">
        <span class="tweetEntry-timestamp ml-1"> ' . $SharedPost['postingDate'] . '</span>
      </a>

     <div class="tweetEntry-text-container mt-2">
      ' . $SharedPost['Post'] . '  
      </div>
      ';

      if (!empty($SharedPost['codeID'])) {
        $CODEID = $SharedPost['codeID'];
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
      echo '
            </div>
            ';
      //if there is an image included
      $imgid = explode('.', $SharedPost['img']);
      if (!empty($SharedPost['img'])) {
        echo '
            <div class="optionalMedia text-center mr-5">
              <img id="img' . $imgid[0] . '" onclick="imgTrigger(' . "'img" . $imgid[0] . "'" . ')" class="optionalMedia-img myImg col-12" src="../sharedPics/' . $SharedPost['img'] . '">
            </div>';
      }





      /////Shared post end

      echo '</div>
</div>';
    }
    echo '
      </div> 
    </div> 
    ';
  }

  //check if is already liked poste
  $PID = $pid;
  $liked = $mysqli->query("SELECT username FROM likes WHERE PostID='$PID' and username='$username';");
  $liked = $liked->fetch_assoc();
  $liked = $liked['username'];

  if ($liked == $username) { //liked
    echo '
              <div class="tweetEntry-action-list mt-2" style="line-height:24px;color: #b1bbc3;">
              <ul class="row col-8 mx-auto" style="list-style: none;">
              <li class="col d-inline py-1 mt-n1">
              <button class="btn mr-4" style="padding: 0px;height:34px;width:30px;" onclick="Like(' . $PID . ')"><i class="fa fa-heart d-inline-block mr-1 mt-n1" id="post' . $PID . '" style="width: 20px;color: #ff3333;"></i></button>';
  } else {
    echo '
              <div class="tweetEntry-action-list" style="line-height:24px;color: #b1bbc3;">
              <ul class="row col-8 mx-auto" style="list-style: none;">
              <li class="col d-inline py-1 mt-n1">
              <button class="btn mr-5" style="padding: 0px;height:34px;width:30px;" onclick="Like(' . $PID . ')"><i class="fa fa-heart d-inline-block mr-1 mt-n1" id="post' . $PID . '" style="width: 20px;color: #C2C5CC;"></i></button>';
  }
  /// Ajax Syncing Likes with database into index.php


  //printing nummber of likes if not null
  $likes = $mysqli->query("SELECT count(*) AS num FROM likes WHERE PostID='$PID';");
  $likes = $likes->fetch_assoc();
  $likes = $likes['num'];
  if ($likes == 0) {
    echo '<span class="text-danger d-inline-block ml-n4 mr-1" id="NumLikes' . $PID . '"></span></li>';
  } else {
    echo '<span class="text-danger d-inline-block ml-n4 mr-1" id="NumLikes' . $PID . '">' . $likes . '</span></li>';
  }
  $comments = $mysqli->query("SELECT count(*) AS num FROM comments WHERE PostID='$PID';");
  $comments = $comments->fetch_assoc();
  $comments = $comments['num'];
  echo '
               <li class=" col d-inline py-1 "> <a href="#TheComment" ><i class="fa fa-comment d-inline-block pt-1 " style="width: 80px;cursor:pointer;"></i></a>';
  if ($comments > 0) {
    echo '<span class="text-info d-inline-block ml-n4 mr-2" >' . $comments . '</span>';
  }
  echo '
  </li><li class="col d-inline py-1 "> <i class="fa fa-share d-inline-block pt-1 text-success" style="width: 80px"></i></li></ul>
              </div>

            </div>
  ';



  ///Comments
  $Query = $mysqli->query("SELECT * FROM comments where PostID='$pid';");
  while ($GetComment = $Query->fetch_assoc()) {
    $CommentorUSERname = $GetComment['username'];
    $CommentOWnerInfos = $mysqli->query("SELECT Lname,Fname,avatarEXT FROM users where Email=(SELECT Email FROM profiles WHERE username='$CommentorUSERname');");
    $CommentOWnerInfos = $CommentOWnerInfos->fetch_assoc();
    echo '
        <div class="tweetEntry-tweetHolder bg-light text-dark border border-secondary mb-1 pt-2 pb-1 col-md-9 mt-0 " id="' . $GetComment['id'] . '"  style="width:90%;">
            <div class="tweetEntry py-1 border-0">
                <div class="tweetEntry-content">
                     <a class="tweetEntry-account-group" href="../members/index.php?username=' . $CommentorUSERname . '">
                          <img class="tweetEntry-avatar" src="../Profile/Avatars/' . $CommentorUSERname . '.' . $CommentOWnerInfos['avatarEXT'] . '">
                          
                          <strong class="tweetEntry-fullname">
                          ' . $CommentOWnerInfos['Fname'] . ' ' . $CommentOWnerInfos['Lname'] . '
                          </strong>
                          
                          <span class="tweetEntry-username">
                            @<b>' . $CommentorUSERname . '</b>
                          </span>
                      </a>
                      <span class="tweetEntry-timestamp ml-1 w-100">' . $GetComment['date'] . '</span>
                        
                      <div class="row ">
                            <div class="tweetEntry-text-container mt-2 ml-3 pb-1">
                                ' . $GetComment['comment'] . '</div>';

    if ($CommentorUSERname == $_SESSION['username']) //test pour l'affichage nonpour la supprission
      echo '<div class="d-inline text-right float-right mr-0 ml-5 pl-5 text-danger " style="float: right; position:absolute; right:10px;"><span style="cursor:pointer;"   onclick="DelCom(' . "'" . $GetComment['id'] . "'" . ',' . "'" . $pid . "'" . ')"><i class="fas fa-trash-alt ml-4 text-danger"></i> Delete</span></div>';
    echo '
                      </div>
                </div>
            </div>
        </div> 
            ';
  }


  echo '
  <div class="col-9 mx-auto d-block mb-1 mt-2 ml-1">
    <div class="form-row ml-1">
        <input type="text" class="col-8 ml-3 form-control btn-outline-dark bg-light text-dark" id="TheComment" aria-describedby="helpId" placeholder="">
        <button type="button" class="btn btn-light btn-outline-dark col-3 ml-2" onclick="SubmitComment(' . "'" . $pid . "'" . ')">Comment</button>
    </div>
  </div>
  </div>

           <!-- Pictures Modal Modal -->
            <div id="ImgModal" class="modal">
            
              <!-- The Close Button -->
              <span class="close text-light" style="font-size:60px;" id="closeTri">&times;</span>
            
              <!-- Modal Content (The Image) -->
              <img class="modal-content mt-n5 pt-0" id="img01" style="max-height:100%;">
            
              <!-- Modal Caption (Image Text) -->
              <div id="text-img" class="text-img"></div>
            </div>
            <!-- Pictures Modal Modal -->



<script src="../js/ImgTrigger.js"></script>
<script> $("#back_btn").click(function (){
    window.history.back();
  }); </script>';
  echo "
  <script>
            function rgb2hex(rgb) {
              rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
              function hex(x) {
                  return ('0' + parseInt(x).toString(16)).slice(-2);
              }
              return '#' + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
          }
            function Like(postid){
            $.ajax({
              url:'./LikesManager.php',
              method:'POST',
              data:{
                pid: postid,
                username:'" . $username . "'
                    },
             success:function(){
               var getRGB=$('#post'+postid).css('color');
               var numlikes=$('#NumLikes'+postid).text() ;
               if( ($('#NumLikes'+postid).text().length)==0 ){numlikes=0;}
               numlikes = parseInt(numlikes);
              if( rgb2hex(getRGB) =='#ff3333' ){
                $('#post'+postid).css('color','#C2C5CC');//grey
                if(numlikes>1)
                {numlikes--;
                    $('#NumLikes'+postid).text(numlikes);
                }
                else{ $('#NumLikes'+postid).text(''); }
              }else{
                $('#post'+postid).css('color','#ff3333');
                numlikes++;
                $('#NumLikes'+postid).text(numlikes);
            }
                                }
                    });
                                   };
        function del(postid){
            if(confirm('Delete This post, Sure?')){
            $.ajax({
                url:'./del.php',
                method:'POST',
                datatype: 'html',
                data:{
                  pid: postid,
                  username:'" . $username . "'
                      },
               success:function(result){
                   // hide the post from profile using parent backward
                   if(result=='true'){
                    window.history.back();
                    }
               }
               });}
        }
        
        function DelCom(ComID,pid){
            $.ajax({
                url:'./DelComment.php',
                method:'GET',
                datatype: 'html',
                data:{
                    commentID: ComID,
                        },
                success:function(result){
                    if(result=='true'){
                   $('#'+ComID).css('display','none');
                    }
                        }
                    });
        }
        function SubmitComment(pid){
                var comment=$('#TheComment').val();
                $.ajax({
                    url:'./SubmitComment.php',
                    method:'GET',
                    datatype: 'html',
                    data:{
                        comment: comment,
                        pid:pid
                            },
                    success:function(result){
                      location.reload();
                            }
                        });
        }
        </script>
</body>
    ";
}
