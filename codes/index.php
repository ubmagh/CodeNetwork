<?php 
session_start();
if( ! isset($_SESSION['username']))
header("location:../Login");
$username=$_SESSION['username'];
include "../includes/config.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title> Codes </title> 
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


<body style="height:100%">
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
<div class="  area mb-0 pb-5 " style="background-image: url('./bg.jpg') !important;background-size: 85% 100% !important;background-repeat:none;height:660px;">

<!-- page content here -->

    <div class=" d-flex align-items-center mt-5 ml-5  mr-n5 mb-0 h-100 w-100">
        
        <div class="w-100 ml-5 h-100 mt-3 mr-5 align-items-center">

            <div class="row w-100">
                <h3 class="text-center text-dark letter mx-auto"> Your saved Codes :</h3>
            </div>
            <div class="row mt-0 w-100">
                <div class="col card h-50 mr-1 pt-2 pb-1 shadow" style="background:rgba(1,1,1,0.7);">
                    <h4 class="text-center text-light border border-top-0 border-left-0 border-right-0 border-secondary shadow"><span class="badge badge-light">C++</span></h4>
                    <table class="table table-hover mt-n2 table-dark bg-transparent my-0">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">code Name</th>
                            <th scope="col">creation date</th>
                            <th scope="col">actions</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php 
                        $getCppS_Query=$mysqli->query("select * From codes where langType='cpp' order by date;");
                        $num=1;
                        while( $getCppS_Row=$getCppS_Query->fetch_assoc() ){
                            echo'
                            <tr>
                                <th scope="row">'.$num.'</th>
                                <td>'.$getCppS_Row['name'].'</td>
                                <td>'.$getCppS_Row['date'].'</td>
                                <td> <a href="../Playground/Cpp/index.php?id='.$getCppS_Row['id'].'"> <i class="fas fa-eye "></i></a>  <span style="cursor:pointer;" onclick="del('."'".$getCppS_Row['id']."','".$getCppS_Row['langType']."'".')"> <i class="fas fa-trash-alt ml-4 text-danger"></i> </span> </td>
                            </tr>
                            ';

                            //using one ajax function to check on username to delete a codeFile in certain language 
                            $num++;
                        }
                        ?>
                            
                            
                        </tbody>
                    </table>
                </div>

                <div class="col card h-50 ml-1 pt-2 pb-1 shadow" style="background:rgba(254,254,254,0.7);">
                    <h4 class="text-center text-dark border border-top-0 border-left-0 border-right-0 border-secondary shadow"><span class="badge badge-dark">C</span></h4>
                    <table class="table table-hover mt-n2 table-secondary bg-transparent my-0">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">code Name</th>
                            <th scope="col">creation date</th>
                            <th scope="col">actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $getCppS_Query=$mysqli->query("select * From codes where langType='c' order by date;");
                        $num=1;
                        while( $getCppS_Row=$getCppS_Query->fetch_assoc() ){
                            echo'
                            <tr>
                                <th scope="row">'.$num.'</th>
                                <td>'.$getCppS_Row['name'].'</td>
                                <td>'.$getCppS_Row['date'].'</td>
                                <td> <a href="../Playground/C/index.php?id='.$getCppS_Row['id'].'"> <i class="fas fa-eye "></i></a>  <span style="cursor:pointer;" onclick="del('."'".$getCppS_Row['id']."','".$getCppS_Row['langType']."'".')"> <i class="fas fa-trash-alt ml-4 text-danger"></i> </span> </td>
                            </tr>
                            ';

                            //using one ajax function to check on username to delete a codeFile in certain language  DONE !!
                            $num++;
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row mt-3 w-100 ">
                <div class="col card h-50 mr-1 pt-2 pb-1 shadow" style="background:rgba(102,153,204,0.7);">
                    <h4 class="text-center text-danger border border-top-0 border-left-0 border-right-0 border-danger shadow"><span class="badge badge-danger">Java</span></h4>
                    <table class="table table-hover table-danger mt-n2 bg-transparent my-0">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">code Name</th>
                            <th scope="col">creation date</th>
                            <th scope="col">actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $getCppS_Query=$mysqli->query("select * From codes where langType='java' order by date;");
                        $num=1;
                        while( $getCppS_Row=$getCppS_Query->fetch_assoc() ){
                            echo'
                            <tr>
                                <th scope="row">'.$num.'</th>
                                <td>'.$getCppS_Row['name'].'</td>
                                <td>'.$getCppS_Row['date'].'</td>
                                <td> <a href="../Playground/Java/index.php?id='.$getCppS_Row['id'].'"> <i class="fas fa-eye "></i></a>  <span style="cursor:pointer;" onclick="del('."'".$getCppS_Row['id']."','".$getCppS_Row['langType']."'".')"> <i class="fas fa-trash-alt ml-4 text-danger"></i> </span> </td>
                            </tr>
                            ';

                            //using one ajax function to check on username to delete a codeFile in certain language 
                            $num++;
                        }
                        ?>
                        </tbody>
                    </table>               
                </div>

                <div class="col card h-50 ml-1 pt-2 pb-1 shadow" style="background:rgba(204,102,0,0.7);">
                    <h4 class="text-center text-info border border-top-0 border-left-0 border-right-0 border-warning shadow"><span class="badge badge-warning">Html/Css/Js</span></h4>
                    <table class="table table-hover table-warning mt-n2 bg-transparent my-0">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">code Name</th>
                            <th scope="col">creation date</th>
                            <th scope="col">actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $getCppS_Query=$mysqli->query("select * From codes where langType='html' order by date;");
                        $num=1;
                        while( $getCppS_Row=$getCppS_Query->fetch_assoc() ){
                            echo'
                            <tr>
                                <th scope="row">'.$num.'</th>
                                <td>'.$getCppS_Row['name'].'</td>
                                <td>'.$getCppS_Row['date'].'</td>
                                <td> <a href="../Playground/html/index.php?id='.$getCppS_Row['id'].'"> <i class="fas fa-eye "></i></a>  <span style="cursor:pointer;" onclick="del('."'".$getCppS_Row['id']."','".$getCppS_Row['langType']."'".')"> <i class="fas fa-trash-alt ml-4 text-danger"></i> </span> </td>
                            </tr>
                            ';

                            //using one ajax function to check on username to delete a codeFile in certain language 
                            $num++;
                        }
                        ?>
                        </tbody>
                    </table> 
                </div>
            </div>
            
            <div class="row mt-4 w-25 mx-auto ">
                <div class="col card mr-1 pt-1 pb-0 shadow" style="background:rgba(102,204,153,0.7);">
                    <h5 class="text-center text-warning border border-top-0 border-left-0 border-right-0 border-danger shadow">Total number :</h5>
                    <h4 class="text-center"> <span class="badge badge-info px-3"> 
                     <?php 
                    $num=$mysqli->query("SELECT count(*) AS nm FROM codes WHERE username='$username'");
                    $num=$num->fetch_assoc();
                    echo $num['nm'];
                    ?>  
                    </span>  </h4>
                </div>
            </div>

        </div>
    </div>

    <script>
    
    function del(id,lang){
        $.ajax({

            type: "POST", //type of submit
            url: "./del.php", //destination
            data: { id : id , lang : lang } , //target your form's data and serialize for a POST
            success: function() { // data is the var which holds the output of your process.php
                // locate the div with #result and fill it with returned data from process.php
                location.reload();
            }
        });
        }
    
    </script>

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
    <li class="active">
        <a href="./">
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
        <a href="../Profile/">
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
<nav class="navbar navbar-expand-sm navbar-dark text-light fixed-bottom" style="z-index:0; background: #212121;">
        <ul class="navbar-nav mx-auto mb-n4">
        <p> <a href="https://www.fb.com/SparoXUB" target="_blank" class="text-danger nav-link d-inline"> <span style="font-size:18px;font-family:Awsome;" ><span class="letter" style="font-size: 18px;">Code</span>Network</span></a><span class="nav-link d-inline">©2019 All Rights Reserved</span> </p>
        </ul>
    </nav>
</body>
</html>
';

