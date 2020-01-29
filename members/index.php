<?php
session_start();
if (empty($_SESSION['username'])) {
    header("location:../Login/");
}

if (isset($_GET['username']))
    if ($_GET['username'] == $_SESSION['username']) {
        header("location:../profile/");
    }

include "../includes/config.php";


$username = $_SESSION['username'];
if (!empty($_GET['username'])) {

    $Profile = $_GET['username'];


    ////Get Description
    $getter = $mysqli->query("SELECT Description FROM description WHERE username='$Profile' ;");
    $getter = $getter->fetch_assoc();
    $description = $getter['Description'];

    $getter = $mysqli->query("SELECT Lname, Fname,avatarEXT,City,age,Country FROM users WHERE Email=(SELECT Email FROM profiles WHERE username='$Profile') ;");
    $getter = $getter->fetch_assoc();
    $Fname = $getter['Fname'];
    $Lname = $getter['Lname'];
    $City = $getter['City'];
    $Country = $getter['Country'];
    $age = $getter['age'];
    $EXT = $getter['avatarEXT'];
    unset($getter);

    //get Country Full name
    $Country = $mysqli->query("SELECT country_name FROM apps_countries WHERE country_code='$Country'; ");
    $Country = $Country->fetch_assoc();
    $Country = $Country['country_name'];

    $Follow = $mysqli->query("SELECT * FROM follows WHERE username='$username' and following='$Profile' ;");
    $Follow = $Follow->fetch_assoc();

    $numFollows = $mysqli->query("SELECT count(*) as num FROM follows where following='$Profile' ;");
    $numFollows = $numFollows->fetch_assoc();
    $numFollows = $numFollows['num'];

    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>' . $Profile . '`s Profile</title>
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/solid.min.css">
    <link rel="stylesheet" href="../css/regular.min.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../Profile/includes/css/profile.css">
    <link rel="stylesheet" href="../Profile/includes/css/profile-sidebar.css">
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.js"></script>

    </head>


    <body>
    <nav class="navbar navbar-expand-sm navbar-dark text-light fixed-top pb-4 pt-2 " style="z-index:10; background: #212121;">
            <ul class="navbar-nav ml-auto mb-n4 mt-n2">
            <li class=" ">
            <a> <i class="fas fa-envelope mr-4 mt-2 mb-1" style="font-size:25px;"></i> </a>
            </li>
            <li>
            <a> <i class="fas fa-bell mr-3 mt-2 mb-1" style="font-size:25px;"></i> </a>
            </li>
            </ul>
    </nav>
    <div class="area min-vh-100" style="height : unset !important;">

    <!-- page content here -->
            <div class="container mb-5" >
                
                <div class="jumbotron mt-n2 pb-1 mb-1 border border-light">
                    <div class="text-center mx-auto avatar"> <img src="../Profile/Avatars/' . $Profile . '.' . $EXT . '" class="mx-auto"  width="150px;"> </div>
                    <h1 class="display-4 text-center my-1" id="Ful">' . $Fname . ' ' . $Lname . '</h1>
                    <p class="text-secondary text-center mb-0 mt-n2">' . $age . ' years</p>
                    <p class="text-secondary text-center mb-n1 mt-n1">' . $City . ' - ' . $Country . '</p>
                    <p class="lead text-center mb-0">' . $description . '</p>
                    <h5 class="text-center mb-0"> <span class="badge badge-warning"> +' . $numFollows . ' Followers </span> </h5>
                    <hr class="my-2">
                    <div class="row col-6 mx-auto mt-0">';

    if (empty($Follow['id']))
        echo '
                    <div class="col mt-0">
                    <button type="button" id="FollowBtn" class="btn btn-success btn-block mx-2 px-0" btn-lg btn-block"><i class="fas fa-plus-circle"></i> Follow</button>
                </div>';
    else
        echo '<div class="col mt-0">
        <button type="button" id="FollowBtn" class="btn btn-success btn-block mx-2 px-0" btn-lg btn-block"><i class="fas fa-spinner"></i> Following</button>
    </div>';

    echo '    <div class="col">
                        <button type="button" id="ChatBtn" class="btn btn-primary btn-block mx-2 px-0" btn-lg btn-block"><i class="fas fa-envelope"></i> Message</button>
                        </div>
                    </div>
                </div>';


    //the image zoom trigger
    echo '<!-- The Modal -->
        <div id="ImgModal" class="modal">
        
          <!-- The Close Button -->
          <span class="close text-light" style="font-size:60px;" id="closeTri">&times;</span>
        
          <!-- Modal Content (The Image) -->
          <img class="modal-content mt-n5 pt-0" id="img01" style="max-height:600px;">
        
          <!-- Modal Caption (Image Text) -->
          <div id="text-img" class="text-img"></div>
        </div>';
    //end of image zoom trigger

    ///LikesModal
    echo '

<!-- Modal -->
<div class="modal fade" id="LikesModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Likes : </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body py-1 px-0" id="LikesModalBody">
            
            </div>
            <div class="modal-footer">
               
            </div>
        </div>
    </div>
</div>';

    ////Likes Modal end


    //// Comments Modal Start
    echo '
            <!-- The Modal -->
            <div class="modal fade mt-n4" id="CommentsModal" style="height:100%;overflow-y: hidden; overflow-x: hidden; ">
              <div class="modal-dialog modal-dialog-scrollable modal-xl">
                <div class="modal-content w-100 mt-n5 mb-5">
            
                  <!-- Modal Header -->
                  <div class="modal-header"  style="width:100%">
                    <h4 class="modal-title" id="CommentsHeading">Comments</h4>
                    <button type="button" class="close" data-dismiss="modal" id="CloseComments"><span style="font-size:40px;">&times;</span></button>
                  </div>
            
                  <!-- Modal body -->
                  <div class="modal-body col-12" id="CommentsBody"  style="width:100%">
                   
                  </div>
            
                  <!-- Modal footer -->
                  <div class="modal-footer">
                    </div>
                </div>
              </div>
            </div>
                        ';
    ///// Comments Modal END*

    //// Sharing Modal Start
    echo '
            <!-- The Modal -->
            <div class="modal fade mt-n4" id="SharingModal" style="height:100%;overflow-y: hidden;overflow-x: hidden;">
              <div class="modal-dialog modal-dialog-scrollable modal-xl">
                <div class="modal-content w-100 mt-n5 mb-5">
            
                  <!-- Modal Header -->
                  <div class="modal-header"  style="width:100%">
                    <h4 class="modal-title" id="SharingHeading">Share Post</h4>
                    <button type="button" class="close" data-dismiss="modal" id="CloseComments"><span style="font-size:40px;">&times;</span></button>
                  </div>
            
                  <!-- Modal body -->
                  <div class="modal-body col-12" id="SharingBody"  style="width:100%">
                   
                  </div>
            
                  <!-- Modal footer -->
                  <div class="modal-footer">
                  <a id="Sharebtn" class="btn btn-info mx-auto col-2 text-light" role="button" style="cursor:pointer;"><i class="fa fa-share d-inline"></i> Share </a>
                    </div>
                </div>
              </div>
            </div>
                        ';
    ///// Sharing Modal END*


    ////ADD here (add Foreign POST on somebody profile) Fonctionality
    echo ' <div id="after"></div>';

    ////// Looping for This Profile Posts Without delete edit buttons

    //Getting this Profile POsts
    $getter = $mysqli->query("SELECT * FROM posts where username='$Profile' order by postingDate desc ;");
    while ($row = $getter->fetch_assoc()) {
        if (empty($row['postRef'])) {
            echo '
                <div class="tweetEntry-tweetHolder bg-light text-dark border border-secondary mb-2" id="p' . $row['id'] . '">
                  <div class="tweetEntry ">
      
                    <div class="tweetEntry-content"  id="Con' . $row['id'] . '">
        
                      <a class="tweetEntry-account-group" href="./?username=' . $Profile . '">
                          <img class="tweetEntry-avatar" src="../Profile/Avatars/' . $Profile . '.' . $EXT . '">
                          
                          <strong class="tweetEntry-fullname">
                          ' . $Fname . ' ' . $Lname . '
                          </strong>
                          
                          <span class="tweetEntry-username">
                            @<b>' . $Profile . '</b>
                          </span>
                      </a>
                      <a class="tweetEntry-account-group" href="../posts/?post=' . $row['id'] . '">
                      <span class="tweetEntry-timestamp ml-1"> ' . $row['postingDate'] . '</span>
                      </a>
                      <div class="tweetEntry-text-container mt-2" >
                      ' . $row['Post'] . '  
                      </div>
                      ';

            if (!empty($row['codeID'])) {
                $CODEID = $row['codeID'];
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
            $imgid = explode('.', $row['img']);
            if (!empty($row['img'])) {
                echo '
                <div class="optionalMedia text-center mr-5">
                  <img id="img' . $imgid[0] . '" onclick="imgTrigger(' . "'img" . $imgid[0] . "'" . ')" style="max-width:100%;x" class="optionalMedia-img myImg" src="../sharedPics/' . $row['img'] . '">
                </div>';
            }

            //check if is already liked poste
            $PID = $row['id'];
            $liked = $mysqli->query("SELECT username FROM likes WHERE PostID='$PID' and username='$username';");
            $liked = $liked->fetch_assoc();
            $liked = $liked['username'];

            if ($liked == $username) { //liked
                echo '</div>
                <div class="tweetEntry-action-list" style="line-height:24px;color: #b1bbc3;">
                <ul class="row col-8 mx-auto" style="list-style: none;">
                <li class="col d-inline">
                <button class="btn mr-4" style="padding: 0px;height:34px;width:30px;" onclick="Like(' . $PID . ')"><i class="fa fa-heart d-inline-block pt-1 mr-1" id="post' . $PID . '" style="width: 20px;color: #ff3333;"></i></button>';
            } else {
                echo '</div>
                <div class="tweetEntry-action-list" style="line-height:24px;color: #b1bbc3;">
                <ul class="row col-8 mx-auto" style="list-style: none;">
        <li class="col d-inline">
                <button class="btn mr-5" style="padding: 0px;height:34px;width:30px;" onclick="Like(' . $PID . ')"><i class="fa fa-heart d-inline-block pt-1 mr-1" id="post' . $PID . '" style="width: 20px;color: #C2C5CC;"></i></button>';
            }
            /// Ajax Syncing Likes with database into index.php


            //printing nummber of likes if not null
            $likes = $mysqli->query("SELECT count(*) AS num FROM likes WHERE PostID='$PID';");
            $likes = $likes->fetch_assoc();
            $likes = $likes['num'];
            if ($likes == 0) {
                echo '<span class="text-danger d-inline-block ml-n4 mr-1" id="NumLikes' . $PID . '" style="cursor:pointer;" onclick="Likes(' . "'" . $PID . "'" . ')"> </span></li>';
            } else {
                echo '<span class="text-danger d-inline-block ml-n4 mr-1" id="NumLikes' . $PID . '" style="cursor:pointer;" onclick="Likes(' . "'" . $PID . "'" . ')">' . $likes . '</span></li>';
            }

            $comments = $mysqli->query("SELECT count(*) AS num FROM comments WHERE PostID='$PID';");
            $comments = $comments->fetch_assoc();
            $comments = $comments['num'];
            echo '
            <li class="col d-inline"><i class="fa fa-comment d-inline-block pt-1 active" style="width: 80px;cursor:pointer;" onclick="Comment(' . "'" . $PID . "'" . ')"></i>';
            if ($comments > 0) {
                echo '<span class="text-info d-inline-block ml-n4 mr-2" >' . $comments . '</span>';
            }
            echo '
            </li><li class=" col d-inline"><i class="fa fa-share d-inline-block pt-1" style="width: 80px;cursor:pointer;" onclick="share(' . "'" . $PID . "'" . ')"></i></li></ul>
                </div>
  
              </div>
            </div>';
        } else {
            /////
            echo '
                <div class="tweetEntry-tweetHolder bg-light text-dark border border-secondary mb-2" id="p' . $row['id'] . '">
                  <div class="tweetEntry ">
      
                    <div class="tweetEntry-content"  id="Con' . $row['id'] . '">
        
                      <a class="tweetEntry-account-group" href="./?username=' . $Profile . '">
                          <img class="tweetEntry-avatar" src="../Profile/Avatars/' . $Profile . '.' . $EXT . '">
                          
                          <strong class="tweetEntry-fullname">
                          ' . $Fname . ' ' . $Lname . ' 
                          </strong>
                          
                          <span class="tweetEntry-username">
                            @<b>' . $Profile . '</b>
                          </span>
                      </a>
                      <a class="tweetEntry-account-group" href="../posts/?post=' . $row['id'] . '">
                      <span class="tweetEntry-timestamp ml-1"> ' . $row['postingDate'] . '</span>
                      </a>
                      <div class="tweetEntry-text-container mt-2" >
                      ' . $row['Post'] . '  
                      </div>
                      </div>
          <div class="my-3 col-11 mx-auto border border-secondary rounded mt-5 ">
            <div class="col-9 mx-auto px-1" style="max-width:90%;"> 
                    

                        
            
                      ';
            /////Shared post start
            $SharedID = $row['postRef'];
            $getter2 = $mysqli->query("SELECT * FROM posts WHERE id='$SharedID' ;");
            $SharedPost = $getter2->fetch_assoc();
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
          <img class="tweetEntry-avatar" src="../Profile/Avatars/' . $OwnerUsername . '.' . $owner['avatarEXT'] . '" style="max-width:90%;">
          
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
              <img id="img' . $imgid[0] . '" onclick="imgTrigger(' . "'img" . $imgid[0] . "'" . ')" class="optionalMedia-img myImg" src="../sharedPics/' . $SharedPost['img'] . '">
            </div>';
                }





                /////Shared post end

                echo '</div>
</div>';
            }

            //// Closure 
            echo '</div>
</div> ';

            //check if is already liked poste
            $PID = $row['id'];
            $liked = $mysqli->query("SELECT username FROM likes WHERE PostID='$PID' and username='$username';");
            $liked = $liked->fetch_assoc();
            $liked = $liked['username'];

            if ($liked == $username) { //liked
                echo '
                <div class="tweetEntry-action-list" style="line-height:24px;color: #b1bbc3;">
                <ul class="row col-8 mx-auto" style="list-style: none;">
                <li class="col d-inline">
                <button class="btn mr-4" style="padding: 0px;height:34px;width:30px;" onclick="Like(' . $PID . ')"><i class="fa fa-heart d-inline-block pt-1 mr-1" id="post' . $PID . '" style="width: 20px;color: #ff3333;"></i></button>';
            } else {
                echo '
                <div class="tweetEntry-action-list" style="line-height:24px;color: #b1bbc3;">
                <ul class="row col-8 mx-auto" style="list-style: none;">
                <li class="col d-inline">
                <button class="btn mr-5" style="padding: 0px;height:34px;width:30px;" onclick="Like(' . $PID . ')"><i class="fa fa-heart d-inline-block pt-1 mr-1" id="post' . $PID . '" style="width: 20px;color: #C2C5CC;"></i></button>';
            }
            /// Ajax Syncing Likes with database into index.php


            //printing nummber of likes if not null
            $likes = $mysqli->query("SELECT count(*) AS num FROM likes WHERE PostID='$PID';");
            $likes = $likes->fetch_assoc();
            $likes = $likes['num'];
            if ($likes == 0) {
                echo '<span class="text-danger d-inline-block ml-n4 mr-1" id="NumLikes' . $PID . '" style="cursor:pointer;" onclick="Likes(' . "'" . $PID . "'" . ')"> </span></li>';
            } else {
                echo '<span class="text-danger d-inline-block ml-n4 mr-1" id="NumLikes' . $PID . '" style="cursor:pointer;" onclick="Likes(' . "'" . $PID . "'" . ')">' . $likes . '</span></li>';
            }

            $comments = $mysqli->query("SELECT count(*) AS num FROM comments WHERE PostID='$PID';");
            $comments = $comments->fetch_assoc();
            $comments = $comments['num'];
            echo '
            <li class="col d-inline"> <i class="fa fa-comment d-inline-block pt-1 active" style="width: 80px;cursor:pointer;" onclick="Comment(' . "'" . $PID . "'" . ')"></i>';
            if ($comments > 0) {
                echo '<span class="text-info d-inline-block ml-n4 mr-2" >' . $comments . '</span>';
            }
            echo '
            </li><li class=" col d-inline"> <i class="fa fa-share d-inline-block pt-1" style="width: 80px;cursor:pointer;" onclick="share(' . "'" . $PID . "'" . ')"></i></li></ul>
                </div>
  
              </div>
            </div>';

            ///
            ////
        }
    }
    ///END getting this PROFILE POSTS

    /// Ajax Syncing Likes/comments.. with database
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
                        datatype: 'html',
                        data:{
                            pid: postid,
                            username:'" . $username . "'
                                },
                        success:function(result){
                            if(result='true'){
                        var getRGB=$('#post'+postid).css('color');
                        var numlikes=$('#NumLikes'+postid).text() ;
                        if( ($('#NumLikes'+postid).text().length)==0 ){numlikes=0;}
                        
                            if(numlikes==' '){
                                numlikes=0;
                                    }
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
                                        }
                                });
                                            };

                    $('#CloseComments').click(
                        function(){
                            $('#CommentsModal').modal('hide');
                            $('#CommentsBody').empty();
                        }
                        );

                    function Comment(pid){
                        $.ajax({
                            url:'./GetComments.php',
                            method:'POST',
                            datatype: 'html',
                            data:{
                                pid: pid,
                                poster:'" . $Profile . "'
                                    },
                            success:function(result){
                                    $('#CommentsBody').empty();
                                    $('#CommentsBody').append(result);
                                    $('#CommentsModal').modal('show');

                                }
                        });

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
                                Comment(pid);}
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
                                    Comment(pid);//reload Comments modal
                                        }
                                    });
                    }
                    
                    var Postid='';

                    function share(pid){
                        $('#SharingBody').empty();
                        Postid=pid;
                        $('#Sharebtn').css('display','block');
                        
                        $.ajax({
                            url:'./GetShare.php',
                            method:'GET',
                            datatype: 'html',
                            data:{
                                pid:pid,
                                    },
                            success:function(result){
                            $('#SharingBody').append('" . '<div class="border border-info rounded py-2 mb-2"> <div class="form-group col-11 mx-auto mb-1"><textarea placeholder="add something.." class="form-control bg-light border-dark btn-outline-dark text-dark" name="" id="postShare" rows="3" style="resize:none;"></textarea></div> <div class="col-10  border border-secondary rounded mx-auto"><div class="py-2 col-10 ml-auto mb-3 pr-0" style="max-width:90%;">' . "'+result+'" . '</div></div>' . "');
                                    }
                                });
                        
                        $('#SharingModal').modal('show');
                    }
                    

                    
                    $('#Sharebtn').click(function(){
                        var post= $('#postShare').val();

                        $.ajax({
                            url:'./Share.php',
                            method:'GET',
                            datatype: 'html',
                            data:{
                                pid:Postid,
                                POST:post
                                    },
                            success:function(result){
                                $('#SharingBody').empty();
                                $('#Sharebtn').css('display','none');
                                if(result=='true'){
                                    $('#SharingBody').append('<div class=" . '"alert alert-success py-3 text-center" role="alert"> <strong>Successfully Shared ! </strong></div>' . "');
                                }else{
                                    $('#SharingBody').append('<div class=" . '"alert alert-danger py-3 text-center" role="alert"> <strong>Oops ! </strong>Something Went Wrong !</div>' . "');
                                }
                                    }
                                });

                    });
                    
                    //printing Likers 
function Likes(pid){
            $.ajax({
                url:'./likers.php',
                method:'GET',
                datatype: 'html',
                data:{
                    postID:pid
                        },
                success:function(result){
                    $('#LikesModalBody').empty();
                    $('#LikesModalBody').append(result);
                    
                    $('#LikesModal').modal('show');
                        }
                    });
        }
        
        $('#ChatBtn').click(function(){alert('This Function is not available yet !');});
        
        $('#FollowBtn').click(function(){
            
            var profile='" . $Profile . "';
            $.ajax({
                url:'./follow.php',
                method:'GET',
                datatype: 'html',
                data:{
                    Tofollow:profile
                        },
                success:function(result){
                    
                    var getContent=$('#FollowBtn').html();
            if( getContent =='<i class=" . '"fas fa-plus-circle"' . "></i> Follow' ){ // If not Following yet
                $('#FollowBtn').html('<i class=" . '"fas fa-spinner"' . "></i> Following');
            }else{
                $('#FollowBtn').html('<i class=" . '"fas fa-plus-circle"' . "></i> Follow');
            }

                        }
                    });


        });


        $('#FollowBtn').mouseover(function(){
            var getContent=$('#FollowBtn').html();
            if( getContent !='<i class=" . '"fas fa-plus-circle"' . "></i> Follow' ){ // If not Following yet
                $('#FollowBtn').html('<i class=" . '"fas fa-minus-circle"' . "></i> unFollow');
            }
        });
        $('#FollowBtn').mouseout(function(){
            var getContent=$('#FollowBtn').html();
            if( getContent =='<i class=" . '"fas fa-minus-circle"' . "></i> unFollow'){ // If not Following yet
                $('#FollowBtn').html('<i class=" . '"fas fa-spinner"' . "></i> Following');
            }
        });
        
                    </script>
                    </div>";
} else {
    /// Not entring to Sombody's PRofile

    //generate three Columns of suggested Members using Z/3Z
    $Col1 = '';
    $Col2 = '';
    $Col3 = '';
    $i = 0;

    $memberEmail = '';



    $getter = $mysqli->query("SELECT Fname,Lname,Email,City,Country,avatarEXT FROM users order by rand() limit 12  ; ");
    while ($row = $getter->fetch_assoc()) {

        $memberEmail = $row['Email'];

        $GetUsername = $mysqli->query("SELECT username FROM profiles WHERE Email='$memberEmail';");
        $GetUsername = $GetUsername->fetch_assoc();
        $GetUsername = $GetUsername['username'];

        if ($GetUsername == $username)
            continue;

        if (($i % 3) == 0) {
            $Col1 = $Col1 . '
                <div class="card m-2 p-2 bg-white">
                    
                        <div class="mt-1">
                            <a href="./?username=' . $GetUsername . '">
                                <img src="../Profile/Avatars/' . $GetUsername . '.' . $row['avatarEXT'] . '" class="rounded" alt="' . $GetUsername . '-Avatar" style="max-width:180px;height:180px;">
                            </a>
                        </div>
                        <div>
                            <a href="./?username=' . $GetUsername . '">
                                <h4 class="mt-1 text-dark mb-0">' . $row['Fname'] . ' ' . $row['Lname'] . '</h4>
                                <p class="text-center m-0 p-0 text-secondary">@' . $GetUsername . '</p>
                            </a>
                             <p class="text-secondary"> ' . $row['City'] . ' - ' . $row['Country'] . '</p>
                        </div>
                    </a>
                </div>
            ';
        }

        if (($i % 3) == 1) {
            $Col2 = $Col2 . '
                <div class="card m-2 p-2 bg-white">
                    
                        <div class="mt-1">
                            <a href="./?username=' . $GetUsername . '">
                                <img src="../Profile/Avatars/' . $GetUsername . '.' . $row['avatarEXT'] . '" class="rounded" alt="' . $GetUsername . '-Avatar" style="max-width:180px;height:180px;">
                            </a>
                        </div>
                        <div>
                            <a href="./?username=' . $GetUsername . '">
                                <h4 class="mt-1 text-dark mb-0">' . $row['Fname'] . ' ' . $row['Lname'] . '</h4>
                                <p class="text-center m-0 p-0 text-secondary">@' . $GetUsername . '</p>
                            </a>
                             <p class="text-secondary"> ' . $row['City'] . ' - ' . $row['Country'] . '</p>
                        </div>
                    </a>
                </div>
            ';
        }

        if (($i % 3) == 2) {
            $Col3 = $Col3 . '
                <div class="card m-2 p-2 bg-white">
                    
                        <div class="mt-1">
                            <a href="./?username=' . $GetUsername . '">
                                <img src="../Profile/Avatars/' . $GetUsername . '.' . $row['avatarEXT'] . '" class="rounded" alt="' . $GetUsername . '-Avatar" style="max-width:180px;height:180px;">
                            </a>
                        </div>
                        <div>
                        <a href="./?username=' . $GetUsername . '">
                        <h4 class="mt-1 text-dark mb-0">' . $row['Fname'] . ' ' . $row['Lname'] . '</h4>
                        <p class="text-center m-0 p-0 text-secondary">@' . $GetUsername . '</p>
                    </a>
                     <p class="text-secondary"> ' . $row['City'] . ' - ' . $row['Country'] . '</p>
                        </div>
                    </a>
                </div>
            ';
        }

        $i++;
    }

    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Find Friends </title>
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/solid.min.css">
    <link rel="stylesheet" href="../css/regular.min.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../Profile/includes/css/profile.css">
    <link rel="stylesheet" href="../Profile/includes/css/profile-sidebar.css">
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.js"></script>

    </head>
    
    <body style="height:100%;overflow-y: hidden;overflow-x: hidden; ">
    <nav class="navbar navbar-expand-sm navbar-dark text-light fixed-top pb-4 pt-2 " style="z-index:10; background: #212121;">
            <ul class="navbar-nav ml-auto mb-n4 mt-n2">
            <li class=" ">
            <a> <i class="fas fa-envelope mr-4 mt-2 mb-1" style="font-size:25px;"></i> </a>
            </li>
            <li>
            <a> <i class="fas fa-bell mr-3 mt-2 mb-1" style="font-size:25px;"></i> </a>
            </li>
            </ul>
    </nav>
    <div class="area min-vh-100">
    <div class="container mt-5 ">
        <div class="row ml-5 mr-n5 pl-5">
            <div class="form-group col-8 mx-auto mt-4">
                <input type="text" class="form-control ml-5 btn-outline-dark bg-light text-dark mr-n3 px-4 text-center" id="lookOn"  placeholder="Find a New Friend !">
            </div>
            <div class="form-group col-4 mt-4">
                <button type="button" id="Search" class="btn btn-dark ml-3 btn-outline-light bg-dark text-light"> <i class="fa fa-search d-inline mr-2 ml-0" ></i>Search</button>
            </div>
        </div>
        
        <div class="row col-12 mt-4">
            <h3 class="text-dark mx-auto col-2 border-bottom border-secondary text-center pb-1"> Members </h3>
        </div>

        <div class="row col-12 mt-2 mb-5 ml-5 text-center px-2 py-4 bg-light rounded" id="ToShow" style="display:none;">

        </div>

        <div class="row col-12 mt-2 mb-5 ml-5 text-center px-2 py-4 bg-light rounded" id="Tohide">

            <div class="col" id="Col1">
            ' . $Col1 . '
            </div>

            <div class="col" id="Col2">
            ' . $Col2 . '
            </div>

            <div class="col" id="Col3">
            ' . $Col3 . '
            </div>

        </div>
        
        
</div>

    </div>
    <script>

    $("#lookOn").keyup(function(){
        
        if( $("#lookOn").val()=="" ){
            $("#ToShow").css("display","none");
            $("#Tohide").css("display","flex");
        }
    });


    $("#Search").click(function(){

        var ToSearch=$("#lookOn").val();

        if(ToSearch !="")
        $.ajax({
            url:"./Search.php",
            method:"GET",
            datatype: "html",
            data:{
                Keywords: ToSearch,
                    },
            success:function(result){


                    if(result=="nothing"){
                            //append to row nothing found + clear columns
                            $("#ToShow").empty();
                            $("#ToShow").append("<h4 class=' . "'text-center text-dark  mx-auto'" . '>Nothing Found for : "+ToSearch+"</h4>");
                            $("#ToShow").css("display","block");
                            $("#Tohide").css("display","none");
                    }else{
                        $("#ToShow").empty();
                        /// Apend found profiles and show them
                        $("#ToShow").append(result);
                        $("#ToShow").css("display","flex");
                        $("#Tohide").css("display","none");
                    }

                    }
                });

    });
    </script>
    ';
}
echo '
       
</div>
<nav class="main-menu border-0 navbar-fixed-left">
<ul class="mt-5">
    <li>
        <a href="../dashboard/">
            <i class="fa fa-home fa-2x"></i>
            <span class="nav-text">
                Dashboard
            </span>
        </a>
      
    </li>
    <li>
        <a href="../codes/">
            <i class="fa fa-list-alt fa-2x"></i>
            <span class="nav-text">
                Your Codes
            </span>
        </a>
    </li>
    <li>
        <a href="../Playground">
            <i class="fa fa-code fa-2x"></i>
            <span class="nav-text">
               Code PlayGround
            </span>
        </a>
    </li>
    <li>
        <a href="../Profile/">
           <i class="fa fa-user fa-2x"></i>
            <span class="nav-text">
                Profile
            </span>
        </a>
       
    </li>
    <li  class="has-subnav active">
       <a href="./">
           <i class="fa fa-share-alt fa-2x"></i>
            <span class="nav-text">
                Members & friends
            </span>
        </a>
    </li>
    <li>
       <a href="../Profile/ProfileSettings.php">
            <i class="fa fa-edit fa-2x"></i>
            <span class="nav-text">
                Account Settings
            </span>
        </a>
    </li>
    <li>
        <a href="../Profile/Report.php">
           <i class="fa fa-info fa-2x"></i>
            <span class="nav-text">
                Troubles/Report ?
            </span>
        </a>
    </li>
</ul>

<ul class="logout">
    <li>
       <a href="../Profile/logout.php">
             <i class="fa fa-power-off fa-2x"></i>
            <span class="nav-text">
                Logout
            </span>
        </a>
    </li>  
</ul>
</nav>
<script src="../js/ImgTrigger.js"></script>
<nav class="navbar navbar-expand-sm navbar-dark text-light fixed-bottom" style="z-index:0; background: #212121;">
        <ul class="navbar-nav mx-auto mb-n4">
        <p> <a href="https://www.fb.com/SparoXUB" target="_blank" class="text-danger nav-link d-inline"> <span style="font-size:18px;font-family:Awsome;" ><span class="letter" style="font-size: 18px;">Code</span>Network</span></a><span class="nav-link d-inline">©2019 All Rights Reserved</span> </p>
        </ul>
    </nav>
</body>
</html>
';
