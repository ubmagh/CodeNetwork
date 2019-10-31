<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location:../Login/");
}
include "../includes/config.php";
$username = $_SESSION['username'];
$email = $_SESSION['email'];


if (!empty($_POST['submit'])) {
    //get the post content could be empty
    $post = $_POST['post'];
    if (!empty($post)) {
        $post = strip_tags($post);
        $post = htmlspecialchars($post);
    } else {
        $post = "";
    }

    //chech code owner befor posting it
    if (!empty($_POST['CodeID'])) {
        $codeID = $_POST['CodeID'];
        $GetcodeOwn = $mysqli->query("SELECT username FROM codes where id='$codeID';");
        $GetcodeOwn = $GetcodeOwn->fetch_assoc();
        $GetcodeOwn = $GetcodeOwn['username'];
        if ($username != $GetcodeOwn) {
            $eRROr = "Invalide Included Code !";
        }
    } else {
        $codeID = '';
    }

    // if shared code not owned ---> not to post it

    $date = date("Y-m-d h:i:s");
    $Custom_Name = $mysqli->query("SELECT id as num FROM posts order by id desc");
    $Custom_Name = $Custom_Name->fetch_assoc();
    $Custom_Name = $Custom_Name['num'] + 1;
    if (empty($eRROr))
        if ((($_FILES['postImg']['name']) != "")) {


            $target_dir = "../sharedPics/";
            $target_file = $target_dir . $Custom_Name . '.' . pathinfo($_FILES['postImg']['name'], PATHINFO_EXTENSION);
            $imageFileType = strtolower(pathinfo($_FILES['postImg']['name'], PATHINFO_EXTENSION));

            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["postImg"]["tmp_name"]);
            if ($check == false) {
                $eRROr = "Invalide Image Formate !";
            } else {
                //check image dimensions
                // Get Image Dimension
                $width = $check[0];
                $height = $check[1];
                if ($width > 1920 || $height > 1080) {
                    $eRROr = "Image dimensions at most 1920x1080px ";
                }
            }

            // Check file size 2mb
            if ((!isset($eRROr)) && ($_FILES["postImg"]["size"] > 2000000)) {
                $eRROr = " Large image 2mb at most !";
            }

            // Allow certain file formats
            if (!isset($eRROr))
                if (($imageFileType != "jpg") && ($imageFileType != "png") && ($imageFileType != "jpeg") && ($imageFileType != "bmp") && ($imageFileType != "gif")) {
                    $eRROr = " Invalide Image Type ! " . $imageFileType;
                }

            if (!isset($eRROr)) {
                $imageName = $Custom_Name . '.' . $imageFileType;
                $mysqli->query("INSERT into posts Values('$Custom_Name','','$username','$imageName','$codeID','$date','$post');");
                move_uploaded_file($_FILES["postImg"]["tmp_name"], $target_file);
                header("location:./");
            }
            //finished with posing image case now if there is no image in the post
        } elseif ((empty($eRROr)) && (empty($_FILES['postImg']['name']))) {

            if (empty($post) && empty($_FILES['postImg']['name']) && empty($codeID))
                $eRROr = "You Just tried to Post Nothing ! :/ ";
            else {
                $mysqli->query("INSERT into posts Values('$Custom_Name','','$username','','$codeID','$date','$post');");
                header("location:./");
            }
        }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> DashBoard </title>
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

    <!--MODALS HERE -->

    <!-- Pictures Modal  Start -->
    <div id="ImgModal" class="modal">

        <!-- The Close Button -->
        <span class="close text-light" style="font-size:60px;" id="closeTri">&times;</span>

        <!-- Modal Content (The Image) -->
        <img class="modal-content mt-n5 pt-0" id="img01" height="560px">

        <!-- Modal Caption (Image Text) -->
        <div id="text-img" class="text-img"></div>
    </div>
    <!-- Pictures Modal  end -->

    <!-- post errors Modal  end -->
    <div class="modal fade" id="ErrorModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Invalid Post</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body" id="eRRor">
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" id="CloseErr" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
    <!-- post errors Modal  end -->

    <!-- Sharing Modal Start -->
    <div class="modal fade mt-n4" id="SharingModal" style="height:100%;overflow-y: hidden;overflow-x: hidden;">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content w-100 mt-n5 mb-5">

                <!-- Modal Header -->
                <div class="modal-header" style="width:100%">
                    <h4 class="modal-title" id="SharingHeading">Share Post</h4>
                    <button type="button" class="close" data-dismiss="modal" id="CloseComments"><span style="font-size:40px;">&times;</span></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body col-12" id="SharingBody" style="width:100%;overflow-x: hidden;">

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <a id="Sharebtn" class="btn btn-info mx-auto col-2 text-light" role="button" style="cursor:pointer;"><i class="fa fa-share d-inline"></i> Share </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Sharing Modal end -->
    <?php
    if (isset($eRROr)) {
        echo "
                <script>
                $('#eRRor').append('" . $eRROr . "');
            $('#ErrorModal').modal('show');
            $('#CloseErr').click(
                function(){
                    $('#eRRor').empty();
                    });
            </script>";
    }
    ?>

    <!-- Likes list Modal start -->
    <div class="modal fade" id="LikesModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="LikesModalHeader"> Likes : </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="font-size:50px;">&times;</span>
                    </button>
                </div>
                <div class="modal-body py-1 px-0" id="LikesModalBody">

                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
    <!-- Likes list Modal ENd -->

    <!-- Comments Modal Start -->
    <div class="modal fade mt-n4" id="CommentsModal" style="height:100%;overflow-y: hidden;overflow-x: hidden;">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content w-100 mt-n5 mb-5">

                <!-- Modal Header -->
                <div class="modal-header" style="width:100%">
                    <h4 class="modal-title" id="CommentsHeading">Comments</h4>
                    <button type="button" class="close" data-dismiss="modal" id="CloseComments"><span style="font-size:40px;">&times;</span></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body col-12" id="CommentsBody" style="width:100%">

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <!-- Comments Modal ENd-->

    <!--  ModalS END -->


    <div class="area min-vh-100">
        <!-- page content here -->
        <div class="container mb-1 mt-5" id="PostsContainer">

            <?php include "../Profile/New-Post.php"; ?>

            <?php
            ///Huakumalo Start :D

            $post = $mysqli->query("SELECT * FROM posts WHERE username='$username' or username in (SELECT following FROM follows where username='$username' ) order by postingDate DESC limit 10;");
            while ($row = $post->fetch_assoc()) {

                $PosterUsername = $row['username'];
                $poster = $mysqli->query("SELECT Fname,Lname,avatarEXT FROM users WHERE Email=(SELECT Email FROM profiles WHERE username='$PosterUsername' ) ; ");
                $poster = $poster->fetch_assoc();

                if (empty($row['postRef'])) {

                    /// Not A shared post
                    echo '
                    <div class="tweetEntry-tweetHolder bg-light text-dark border border-secondary mb-2" id="p' . $row['id'] . '">
                    <div class="tweetEntry ">
        
                      <div class="tweetEntry-content"  id="Con' . $row['id'] . '">
          
                        <a class="tweetEntry-account-group" href="../members/?username=' . $PosterUsername . '">
                            <img class="tweetEntry-avatar" src="../Profile/Avatars/' . $PosterUsername . '.' . $poster['avatarEXT'] . '">
                            
                            <strong class="tweetEntry-fullname">
                            ' . $poster['Fname'] . ' ' . $poster['Lname'] . '
                            </strong>
                            
                            <span class="tweetEntry-username">
                              @<b>' . $PosterUsername . '</b>
                            </span>
                        </a>
                        <a class="tweetEntry-account-group" href="../posts/?post=' . $row['id'] . '">
                          <span class="tweetEntry-timestamp ml-1"> ' . $row['postingDate'] . '</span>
                        </a>
                        <div class="tweetEntry-text-container mt-2">
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
                  <img id="img' . $imgid[0] . '" onclick="imgTrigger(' . "'img" . $imgid[0] . "'" . ')" class="optionalMedia-img myImg col-12" src="../sharedPics/' . $row['img'] . '">
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
                <button class="btn mr-4" style="padding: 0px;height:34px;width:30px;cursor:pointer;" onclick="Like(' . $PID . ')"><i class="fa fa-heart d-inline-block pt-1 mr-1" id="post' . $PID . '" style="width: 20px;color: #ff3333;"></i></button>';
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
                 <li class="col d-inline"> <i class="fa fa-comment d-inline-block pt-1 active" style="width: 80px;cursor:pointer;" onclick="Comment(' . "'" . $PID . "'" . ')"></i>';
                    if ($comments > 0) {
                        echo '<span class="text-info d-inline-block ml-n4 mr-2" >' . $comments . '</span>';
                    }
                    echo '
    </li><li class=" col d-inline"> <i class="fa fa-share d-inline-block pt-1" style="width: 80px;cursor: pointer;" onclick="share(' . "'" . $PID . "'" . ')"></i></li></ul>
                </div>
  
              </div>
            </div>
            ';


                    ///
                } else {

                    ///Shared post

                    echo '
    <div class="tweetEntry-tweetHolder bg-light text-dark border border-secondary mb-2" id="p' . $row['id'] . '">
      <div class="tweetEntry ">

        <div class="tweetEntry-content "  id="Con' . $row['id'] . '">

          <a class="tweetEntry-account-group" href="../members/?username=' . $PosterUsername . '">
              <img class="tweetEntry-avatar" src="../Profile/Avatars/' . $PosterUsername . '.' . $poster['avatarEXT'] . '">
              
              <strong class="tweetEntry-fullname">
              ' . $poster['Fname'] . ' ' . $poster['Lname'] . '
              </strong>
              
              <span class="tweetEntry-username">
                @<b>' . $PosterUsername . '</b>
              </span>
          </a>
          <a class="tweetEntry-account-group" href="../posts/?post=' . $row['id'] . '">
            <span class="tweetEntry-timestamp ml-1"> ' . $row['postingDate'] . '</span>
          </a>

          <div class="tweetEntry-text-container mt-2 mb-2">
          ' . $row['Post'] . '  
          </div>
          </div> 
          <div class="mb-3 mt-5 col-11 mx-auto border border-secondary rounded ">
            <div class="col-9 mx-auto px-1" style="max-width:90%;"> 
        ';
                    $SharedID = $row['postRef'];
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
                      <div class="tweetEntry-tweetHolder bg-light text-dark ml-n5 mr-2 mb-2" style="max-width:100%">
                        <div class="tweetEntry col-12">
                  
                          <div class="tweetEntry-content col-12" >
                  
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
                                    <div class="optionalMedia text-center mr-5 mt-4">
                                        <img id="img' . $imgid[0] . '" onclick="imgTrigger(' . "'img" . $imgid[0] . "'" . ')" class="optionalMedia-img myImg" src="../sharedPics/' . $SharedPost['img'] . '">
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
    </li><li class=" col d-inline"> <i class="fa fa-share d-inline-block pt-1" style="width: 80px;cursor: pointer;" onclick="share(' . "'" . $PID . "'" . ')"></i></li></ul>
            </div>

        </div>
        </div>
        ';
                    //
                }
            }

            ?>
        </div>
        <div class="row mx-auto col-8 mt-n2 mb-4" id="more">
            <button type="button" id="MorePosts" class="btn btn-light btn-block border-secondary btn-outline-secondary my-2 btn-md"><i class="fas fa-arrow-down    "></i> Load More Posts <i class="fas fa-arrow-down    "></i></button>
        </div>
    </div>

    <?php

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
                    pid: pid
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
        var reload='false';

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
                        reload='true';
                    }else{
                        $('#SharingBody').append('<div class=" . '"alert alert-danger py-3 text-center" role="alert"> <strong>Oops ! </strong>Something Went Wrong !</div>' . "');
                    }
                    
                        }
                    });

        });

$('#CloseComments').click(function(){ //// to refresh page if shared succeded
    if(reload=='true')
        location.reload();
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
                    $('#LikesModalHeader').html(' Likes : ');
                    $('#LikesModal').modal('show');
                        }
                    });
        }
    
        var MorePostsRequestedTimes=1;
       $('#MorePosts').click(function(){
        $.ajax({
            url:'./MorePosts.php',
            method:'GET',
            datatype: 'html',
            data:{
                times:MorePostsRequestedTimes
                    },
            success:function(result){
                if(result==''){
                    $('#MorePosts').css('display','none');
                    $('#more').append('<div class=" . '"alert alert-secondary col-8 text-center border-dark bg-white mx-auto mt-2 mb-4" role="alert"><strong>No more Posts to show</strong></div>' . "');
                }
                else{
                MorePostsRequestedTimes++;
                $('#PostsContainer').append(result);
                    }
                }
            });
        }); 

        </script>
            ";

    ?>

    <nav class="main-menu border-0 navbar-fixed-left">
        <ul class="mt-5">
            <li class="has-subnav active">
                <a href="./">
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
            <li>
                <a href="../members/">
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
            <p> <a href="https://www.fb.com/SparoXUB" target="_blank" class="text-danger nav-link d-inline"> <span style="font-size:18px;font-family:Awsome;"><span class="letter" style="font-size: 18px;">Code</span>Network</span></a><span class="nav-link d-inline">©2019 All Rights Reserved</span> </p>
        </ul>
    </nav>
</body>

</html>
';