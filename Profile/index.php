<?php
session_start();
include "../includes/config.php";
$username=$_SESSION['username'];
$email=$_SESSION['email'];
$getdescription=$mysqli->query("SELECT Description FROM description WHERE username='$username';");
$getdescription=$getdescription->fetch_assoc();
$description=$getdescription['Description'];

$getter=$mysqli->query("SELECT Lname, Fname FROM users WHERE Email='$email';");
$getter=$getter->fetch_assoc();
$Fname=$getter['Fname'];
$Lname=$getter['Lname'];
unset($getter);

echo'
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>'.$username.' Profile</title>
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
        <div class="container mb-5">
            
            <div class="jumbotron mt-n2 pb-1 mb-1 border border-light">
                <div class="text-center mx-auto avatar"> <img src="./Avatars/'.$username.'.png" class="mx-auto" alt=""> </div>
                <h1 class="display-4 text-center my-1" id="Ful">'.$Fname.' '.$Lname.'</h1>
                <hr class="my-2">
                <p class="lead text-center">'.$description.'</p>
            </div>';

            //the image zoom trigger
            echo'<!-- The Modal -->
            <div id="ImgModal" class="modal">
            
              <!-- The Close Button -->
              <span class="close text-light" style="font-size:60px;" id="closeTri">&times;</span>
            
              <!-- Modal Content (The Image) -->
              <img class="modal-content" id="img01">
            
              <!-- Modal Caption (Image Text) -->
              <div id="text-img" class="text-img"></div>
            </div>';
            //end of image zoom trigger

            
            unset($description,$getdescription);
            include "./New-Post.php";
            include "./includes/ProfilePosts.php";


            /// Ajax Syncing Likes with database
            echo"
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
                username:'".$username."'
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
        </script>
            ";
            ///End  Ajax Syncing Likes 


        echo'
        </div>
</div>
<nav class="main-menu border-0 navbar-fixed-left">
<ul>
    <li>
        <a href="#">
            <i class="fa fa-home fa-2x"></i>
            <span class="nav-text">
                Dashboard
            </span>
        </a>
      
    </li>
    <li>
        <a href="#">
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
       <a href="#">
           <i class="fa fa-share-alt fa-2x"></i>
            <span class="nav-text">
                people & friends
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


?>
