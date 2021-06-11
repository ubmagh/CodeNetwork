    <?php
session_start();
if( isset($_SESSION['username']) ){
    include "../../includes/config.php";
    $username=$_SESSION['username'];
    $email=$_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>C++ PlayGround</title>
<link rel="shortcut icon" href="../../favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="../../css/style.css">
<link rel="stylesheet" href="../../css/font-awesome.min.css">
<link rel="stylesheet" href="../../css/solid.min.css">
<link rel="stylesheet" href="../../css/bootstrap.css">
<link rel="stylesheet" href="../../Profile/includes/css/profile.css">
<link rel="stylesheet" href="../../Profile/includes/css/profile-sidebar.css">
<script src="../../js/jquery.js"></script>
<script src="../../js/bootstrap.js"></script>
<script>function startTime(){
var today=new Date();
var h=today.getHours();
var m=today.getMinutes();
var s=today.getSeconds();
// add a zero in front of numbers<10
h=checkTime(h);
m=checkTime(m);
s=checkTime(s);
document.getElementById('timer').innerHTML="Server Time : "+h+":"+m+":"+s;
t=setTimeout(function(){startTime()},500);}
function checkTime(i){if (i<10){i="0" + i;}return i;}</script>
</head>

<body onload="startTime()">
<nav class="navbar navbar-expand-sm navbar-dark text-light fixed-top pb-4 pt-2 " style="z-index:10; background: #212121;">
        <ul class="navbar-nav ml-auto mb-n4 mt-n2 ">
        <li id="timer" class="mr-5 text-center text-info mt-2 ml-n5">  </li>
        <li class=" ">
        <a> <i class="fas fa-envelope mr-4 mt-2 mb-1" style="font-size:25px;"></i> </a>
        </li>
        <li>
        <a> <i class="fas fa-bell mr-3 mt-2 mb-1" style="font-size:25px;"></i> </a>
        </li>
        </ul>
</nav>
<div class="area mb-0 pb-3" style="background-image: url('/PlayGround/includes/bg1.jpg') !important;background-size: 100% 100% !important;background-repeat:none;height:990px; ">

<!-- page content here -->
<div class="row  ml-2 mb-0 mt-n3">
        <div class="jumbotron col-7 mx-auto bg-transparent mt-n3 mb-n5">
            <h1 class="display-4 text-center text-light ml-n1"> <span class="letter" style="font-size: 58px;">C++ Programming</span> </h1>
            <hr class="mt-n2 mb-3 bg-light mb-0">
        </div>
</div>


<form action="compile.php" id="form" name="f2" method="POST">

    <div class="row container-fluid mt-n5 mb-0 py-0">
        <div class="form-group col-10 mx-auto pl-5 pr-0">
            <label for="Code-input" class="text-secondary text-center bg-light mb-0">Code source input : </label>
            <textarea name="input" class="form-control text-dark bg-light btn-outline-dark px-4 py-2" id="Code-input" cols="30" rows="10" style="resize:none;font-family:Courier New;">
        <?php
        if(isset($_GET['id'])){
            $id=$_GET['id'];
            $getter=$mysqli->query("SELECT username FROM codes WHERE id='$id' ;");
            $getter=$getter->fetch_assoc();
            $username=$getter['username'];
            $Code=$mysqli->query("select * From codes where id='$id'");
            $Code=$Code->fetch_assoc();
            if($Code['langType']!='cpp'){
                header("location:../".$Code['langType'].'/index.php?id='.$id);
            }
            if( empty($Code['id']) ){echo 'File Not Found/Deleted !! ';}

            else{

            $file_path="../../codes/".$username."/Cpp/".$Code['name'].".cpp";


            $file = fopen($file_path,"r");

            function RespectHTML($Str){
                $Str=str_replace("&","&#38;",$Str);
                $Str=str_replace("<","&lt;",$Str);
                $Str=str_replace(">","&gt;",$Str);
                return $Str;
            }

            $To_Insert="";
            while(! feof($file))
            {
            $To_Insert=fgets($file);
            $To_Insert=RespectHTML($To_Insert);
            echo $To_Insert;
            }
            fclose($file);
        }}
            else echo'
            #include <iostream>
            using namespace std;
                int main(){
                 cout << " \n\t Hello World !";
                 return 0;
                }
                ';
                ?>

            </textarea>
        </div>
    </div>

    <div class="row container-fluid mt-n2 mb-0">
        <div class="col-10 mx-auto pl-5 pr-0">
        <label for="args" class="text-secondary text-center bg-light mb-0">Parameters Input :</label>
            <textarea class="form-control text-dark bg-light btn-outline-dark  px-5 pt-2 pb-0" name="Args" id="args" cols="30" rows="1" style="resize:none;font-family:Courier New;"></textarea>
        </div>
    </div>

    <div class="row container col-10 ml-auto mt-2 mb-n2">
        <div class="col d-block">
            <div class="col-5 mx-auto">
                <button name="submit" value="Compile" type="submit" id="st" class="btn btn-success btn-outline-light mx-auto px-4"><i class="fas fa-cogs dis px-1 ml-n2 mr-n1"></i> Run Code !</button>
            </div>
        </div>
        <div class="col d-block">
            <div class="col-5 mr-auto">
                <button id="save" class="btn btn-info btn-outline-light mx-auto px-4"><i class="fas fa-save"></i> Save Code!</button>
            </div>
        </div>
    </div>

    </form>

    <script type="text/javascript">
  $(document).ready(function(){
     $("#st").click(function(){
        window.scroll({
        top: 350,
        left: 0,
        behavior: 'smooth'
        });
           $("#div").html(" Compiling ......");
     });
  });
</script>

<script>
//wait for page load to initialize script
$(document).ready(function(){
    //listen for form submission
    $('form').on('submit', function(e){
      //prevent form from submitting and leaving page
      e.preventDefault();
      // AJAX
      $.ajax({
            type: "POST", //type of submit
            cache: false, //important or else you might get wrong data returned to you
            url: "./tmp/Cpp-compile.php", //destination
            datatype: "html", //expected data format from process.php
            data: $('form').serialize(), //target your form's data and serialize for a POST
            success: function(result) { // data is the var which holds the output of your process.php
                // locate the div with #result and fill it with returned data from process.php
                $('#div').html(result);
            }
        });
    });
});


$("#save").click(
        function(){
        var name=prompt("Enter code name : (could be erased if existed) \n");
        while(name==""){
            name=prompt("Enter code name : (could be erased if existed) \n");
        }
        if(name){
        var lang="cpp";
        var code=$("#Code-input").val().toString();
        $.ajax({
            type: "POST", //type of submit
            cache: false, //important or else you might get wrong data returned to you
            url: "../../codes/save.php", //destination
            data: {lang: lang ,name: name,code: code }, //target your form's data and serialize for a POST
            success: function() { // data is the var which holds the output of your process.php
                // locate the div with #result and fill it with returned data from process.php
                alert("saved successfully");
            }
        });
    }
        else{alert("Code Not Saved !");}
        }
    )
</script>

    <div class="row container-fluid mt-2 mb-3">
        <div class="col-10 mx-auto pl-5 pr-0">
        <label for="args" class="text-white text-secondary bg-light mb-0">OutPut :</label>
            <textarea class="form-control text-dark bg-light btn-outline-dark px-5 pt-2 pb-0" name="div" id="div" cols="30" rows="10" readonly style="resize:none;font-family:Courier New;"></textarea>
        </div>
    </div>



</div>
</div>
<nav class="main-menu border-0 navbar-fixed-left">
<ul class="mt-5">
    <li>
        <a href="../../dashboard/">
            <i class="fa fa-home fa-2x"></i>
            <span class="nav-text">
                Dashboard
            </span>
        </a>

    </li>
    <li>
        <a href="../../codes/">
            <i class="fa fa-list-alt fa-2x"></i>
            <span class="nav-text">
                Your Codes
            </span>
        </a>
    </li>
    <li class="active">
        <a href="../">
            <i class="fa fa-code fa-2x"></i>
            <span class="nav-text">
               Code PlayGround
            </span>
        </a>
    </li>
    <li class="has-subnav">
    <?php echo '<a href="../../Profile/">' ?>;
           <i class="fa fa-user fa-2x"></i>
            <span class="nav-text">
                Profile
            </span>
        </a>

    </li>
    <li>
       <a href="../../members/">
           <i class="fa fa-share-alt fa-2x"></i>
            <span class="nav-text">
                Members & friends
            </span>
        </a>
    </li>
    <li>
       <a href="../../Profile/ProfileSettings.php">
            <i class="fa fa-edit fa-2x"></i>
            <span class="nav-text">
                Account Settings
            </span>
        </a>
    </li>
    <li>
        <a href="../../Profile/Report.php">
           <i class="fa fa-info fa-2x"></i>
            <span class="nav-text">
                Troubles/Report ?
            </span>
        </a>
    </li>
</ul>

<ul class="logout">
    <li>
       <a href="../../Profile/logout.php">
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



<?php

}else{
    header('location:../../Login');
}

?>
