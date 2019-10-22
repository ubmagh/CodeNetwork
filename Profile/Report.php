<?php
session_start();
if (isset($_SESSION['username'])) {
    include "../includes/config.php";
    $username = $_SESSION['username'];
    $email = $_SESSION['email'];


    if (isset($_POST['ReportBTN'])) {
        $report = $_POST['report'];
        $report = htmlspecialchars(strip_tags($report));
        if (empty($report)) {
            $flag = false;
        } else {
            $date = date("Y-m-d h:i:s");

            if ($mysqli->query("INSERT INTO reports VALUES ('','$username','$email','$date','$report');"))
                $flag = true;
            else
                $flag = false;
        }
    }

    echo '
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Report</title>
<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/font-awesome.min.css">
<link rel="stylesheet" href="../css/solid.min.css">
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
<div class="area" style="background-image: url(' . "'./includes/img/rep.jpg'" . ') !important;background-size: 100% 100% !important; height:790px;">

<!-- page content here -->

<div class="jumbotron bg-transparent text-center mt-4 mb-2">
    <h1 class="display-3">Report or Troubles ?</h1>
    <p class="lead text-4x">Please describe Your Problem</p>
    <hr class="my-2">
</div>

<div class="col-md-8 mx-auto  mt-n4">
<form action="" method="post">
<div class="form-group">
  <label for=""></label>
  <textarea class="form-control bg-light form_effect text-center text-dark p-4" name="report" rows="5" style="resize:none;" placeholder="Write about your problem"></textarea>
</div>

<div class="form-group mx-auto col-7 mt-4 opacityChange">
        <button type="submit"  name="ReportBTN" value="submit" class="btn form_effect btn-dark col-12 border-0 text-center"><span class="shadow"> <i class="fa fa-mail-forward d-inline-block mr-n3 ml-n1 pt-1" aria-hidden="true"></i> Send !</span></button>
</div>
</form>
</div>';

    if (isset($flag)) {
        if ($flag) { //if report is insered succ
            echo '
    <div class="alert alert-success alert-dismissible fade show col-md-8 mx-auto text-center" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
        </button>
        <strong>Holy guacamole!</strong> Your Repport is Sent Successfuly ! 
    </div>
    ';
        } else { //if not
            echo '
    <div class="alert alert-danger alert-dismissible fade show col-md-8 mx-auto text-center" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
        </button>
        <strong>Oops!</strong> something went wrong
    </div>
    ';
        }
    }


    echo '
</div>
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
        <a href="../Playground/">
            <i class="fa fa-code fa-2x"></i>
            <span class="nav-text">
               Code PlayGround
            </span>
        </a>
    </li>
    <li class="has-subnav">
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
    <li class="active">
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
<nav class="navbar navbar-expand-sm navbar-dark text-light fixed-bottom" style="z-index:0; background: #212121;">
        <ul class="navbar-nav mx-auto mb-n4">
        <p> <a href="https://www.fb.com/SparoXUB" target="_blank" class="text-danger nav-link d-inline"> <span style="font-size:18px;font-family:Awsome;" ><span class="letter" style="font-size: 18px;">Code</span>Network</span></a><span class="nav-link d-inline">©2019 All Rights Reserved</span> </p>
        </ul>
    </nav>
</body>
</html>
';
} else {
    header('location:./');
}
