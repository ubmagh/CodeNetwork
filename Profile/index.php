<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location:../");
}
include "../includes/config.php";
$username = $_SESSION['username'];
$email = $_SESSION['email'];
$getdescription = $mysqli->query("SELECT Description FROM description WHERE username='$username';");
$getdescription = $getdescription->fetch_assoc();
$description = $getdescription['Description'];
$getter = $mysqli->query("SELECT Lname, Fname,avatarEXT FROM users WHERE Email='$email';");
$getter = $getter->fetch_assoc();
$Fname = $getter['Fname'];
$Lname = $getter['Lname'];
$EXT = $getter['avatarEXT'];
unset($getter);
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
                echo '<script>window.location.replace("http://' . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'] . '")</script>';
            }
            //finished with posing image case now if there is no image in the post
        } elseif ((empty($eRROr)) && (empty($_FILES['postImg']['name']))) {

            if (empty($post) && empty($_FILES['postImg']['name']) && empty($codeID))
                $eRROr = "You Just tried to Post Nothing ! :/ ";
            else {
                $mysqli->query("INSERT into posts Values('$Custom_Name','','$username','','$codeID','$date','$post');");
                echo '<script>window.location.replace("http://' . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'] . '")</script>';
            }
        }
}

$getter = $mysqli->query("SELECT * FROM userlog WHERE userEmail=(SELECT Email FROM profiles WHERE username='$username') order by date ;");
$LogInfos = $getter->fetch_assoc();
echo '
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>' . $username . ' Profile</title>
<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/font-awesome.min.css">
<link rel="stylesheet" href="../css/solid.min.css">
<link rel="stylesheet" href="../css/regular.min.css">
<link rel="stylesheet" href="../css/bootstrap.css">
<link rel="stylesheet" href="./includes/css/profile.css">
<link rel="stylesheet" href="./includes/css/profile-sidebar.css">
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
<div class="area min-vh-100">
<!-- page content here -->
        <div class="container mb-5" >
            
            <div class="jumbotron mt-n2 pb-1 mb-1 border border-light">
                <div class="text-center mx-auto avatar"> <img src="./Avatars/' . $username . '.' . $EXT . '" class="mx-auto"  width="150px;"> </div>
                <h1 class="display-4 text-center my-1" id="Ful">' . $Fname . ' ' . $Lname . '</h1>
                <p class="lead text-center">' . $description . '</p>
                <hr class="my-2">

                <div class="row col-3 mb-2 mx-auto">
                        <button type="button" id="FollowingList" class="btn btn-success btn-block" btn-lg btn-block"> <i class="fa fa-list d-inline ml-n3 mr-2 mt-0" aria-hidden="true"></i> My Followings</button>
                </div>

                <div class="alert alert-primary alert-dismissible fade show col-8 mx-auto text-center" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <h6><strong>Last Login: </strong> ' . $LogInfos['date'] . ' FromIP: ' . $LogInfos['userIp'] . ' ' . $LogInfos['guestName'] . '
                    </h6>
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
//post errors   Modal: 
echo '
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
        ';

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
          <div class="modal-body col-12" id="SharingBody"  style="width:100%;overflow-x: hidden;">
           
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
//end post errors modal
///LikesModal
echo '

<!-- Modal -->
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
</div>';

////Likes Modal end

//// Comments Modal Start
echo '
            <!-- The Modal -->
            <div class="modal fade mt-n4" id="CommentsModal" style="height:100%;overflow-y: hidden;overflow-x: hidden;">
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
///// Comments Modal END
unset($description, $getdescription);
include "./New-Post.php";
echo ' <div id="after"></div>';
include "./includes/ProfilePosts.php";
/// Ajax Syncing Likes with database
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
                   $('#p'+postid).css('display','none');/////because visibility->hidden left space 
                    }
               }
               });}
        }
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
$('#FollowingList').click(function(){
    $.ajax({
        url:'./followings.php',
        method:'GET',
        datatype: 'html',
        success:function(result){
            $('#LikesModalBody').empty();
            $('#LikesModalBody').append(result);
            $('#LikesModalHeader').html(' My Followings List :');
            $('#LikesModal').modal('show');
                }
            });
});

function Unfollow(following,item){
    $.ajax({
        url:'./follow.php',
        method:'GET',
        datatype: 'html',
        data:{
            Tofollow:following
                },
        success:function(result){
            $('#list-item-'+item).css('display','none');
                }
            });

}
        </script>
            ";
///End  Ajax Syncing Likes 
echo '
        </div>
</div>
<nav class="main-menu border-0 navbar-fixed-left">
<ul>
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
    <li class="has-subnav active">
        <a href="./">
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
       <a href="./ProfileSettings.php">
            <i class="fa fa-edit fa-2x"></i>
            <span class="nav-text">
                Account Settings
            </span>
        </a>
    </li>
    <li>
        <a href="./Report.php">
           <i class="fa fa-info fa-2x"></i>
            <span class="nav-text">
                Troubles/Report ?
            </span>
        </a>
    </li>
</ul>
<ul class="logout">
    <li>
       <a href="./logout.php">
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
