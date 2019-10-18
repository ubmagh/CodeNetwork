<?php
session_start();
if (isset($_SESSION['username'])) {
    include "../includes/config.php";
    $username = $_SESSION['username'];
    $email = $_SESSION['email'];


    echo '
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Code PlayGround</title>
<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/font-awesome.min.css">
<link rel="stylesheet" href="../css/solid.min.css">
<link rel="stylesheet" href="../css/bootstrap.css">
<link rel="stylesheet" href="../Profile/includes/css/profile.css">
<link rel="stylesheet" href="../Profile/includes/css/profile-sidebar.css">
<script src="../js/jquery.js"></script>
<script src="../js/bootstrap.js"></script>
</head>


<body style="height:100%;overflow-y: hidden; // hide vertical overflow-x: hidden; // hide horizontal">
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
<div class="area mb-0 pb-5" style="background-image: url(' . "'./includes/bg1.jpg'" . ') !important;background-size: cover !important;background-repeat:none;height:640px; ">

<!-- page content here -->
<div class="row mt-5 ml-2 mb-0 h-100">

<div class="jumbotron col-7 mx-auto bg-transparent mt-3 mb-0">
    <h1 class="display-3 text-center text-light shadow shadow-lg">Choose Your Weapon </h1>
    <p class="lead text-center text-light mt-2">Available Languages : </p>
    <hr class="my-2">

    <div class="row col-11 mx-auto">

        <div class="col px-0 mr-4">
            <a href="./C" class=""> <img src="./includes/C.png" alt="Programming C" width="100%"> </a>
        </div>
        <div class="col px-0 mx-2">
            <a href="./Cpp"> <img src="./includes/Cpp.png" alt="Programming Cpp" width="120%"> </a>
        </div>
        <div class="col px-0 ml-4 mt-n3">
                <a href="./Java" class=""> <img src="./includes/java.png" alt="Programming Java" width="130%"> </a>
        </div>
        <div class="col px-0 ml-4 mt-n3">
                <a href="./html" class=""> <img src="./includes/html.png" alt="Programming Java" width="130%"> </a>
        </div>
    </div>

    <div class="row col-8 mx-auto mb-n3">
        
    </div>

</div>

</div>

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
    <li class="active">
        <a href="./">
            <i class="fa fa-code fa-2x"></i>
            <span class="nav-text">
               Code PlayGround
            </span>
        </a>
    </li>
    <li class="has-subnav">
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
<nav class="navbar navbar-expand-sm navbar-dark text-light mt-4 pb-2" style="z-index:0; background: #212121;">
        <ul class="navbar-nav mx-auto mb-n4">
        <p> <a href="https://www.fb.com/SparoXUB" target="_blank" class="text-danger nav-link d-inline"> <span style="font-size:18px;font-family:Awsome;" ><span class="letter" style="font-size: 18px;">Code</span>Network</span></a><span class="nav-link d-inline">©2019 All Rights Reserved</span> </p>
        </ul>
    </nav>
</body>
</html>
';
} else {
    header('location:../Login');
}
