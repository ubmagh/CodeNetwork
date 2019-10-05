<?php
include "../includes/config.php";
session_start();
if(empty($_SESSION['email'])){
    header("location:./");
}
else{


    if(isset($_POST['Ubtn'])){
        $choosen=$_POST['Username'];
        $eMail=$_SESSION['email'];
        //check if an email has already a username
        $check=$mysqli->query("SELECT Email FROM profiles WHERE Email='".$eMail."';");
        $CheckResult=$check->fetch_assoc();
        if( empty($CheckResult['Email'])){
        unset($CheckResult);
        //check duplicated username
        $check=$mysqli->query("SELECT Email FROM profiles WHERE username='".$choosen."';");
        $CheckResult=$check->fetch_assoc();
        if( empty($CheckResult['Email']) ){

            //check invalide usernames
            if( preg_match("/^[a-zA-Z]*$/",$choosen)){
            $Insert=$mysqli->query("INSERT INTO profiles VALUES ('$eMail','$choosen');");
            mkdir("../Profiles/".$choosen);
            mkdir("../Profiles/".$choosen."/uploads");
            $profileIndex=fopen("../Profiles/".$choosen."/index.php","w");
            fclose($profileIndex);
            copy("../Profiles/Default-Avatar.png","../Profiles/".$choosen."/avatar.png");
            header("location:../Profiles/".$choosen);
            $mysqli->query("INSERT INTO description VALUES ('','$choosen','little description');");
        
        }
            else{$alreadyExisted=2;}
        }
        else{
            $alreadyExisted=1;
        }
    }
    else{
        $alreadyExisted=3;
    }
}
    echo'
    
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile</title>
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-md bg-dark navbar-dark py-3 mb-0">
    <div class="mx-auto">
        <a class="navbar-brand" href="../"><span class="letter" style="font-size: 28px;">C-</span>NetworK </a>
    </div>
</nav>

            <div class="modal fade my-0 text-center" id="myModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                    <h4 class="modal-title text-warning "> <i class="fa fa-times-circle-o text-danger fa-lg" aria-hidden="true"></i> error ! </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body text-danger text-center" id="modal-body">
                    </div>  
                    <!-- Modal footer -->
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closebtn">Close</button>
                    </div>
                    </div>
                </div>
            </div>
    
            <div class="container-fluid  " style="background-image: url('."../images/bg5.jpg".'); 
            background-repeat: no-repeat;background-size: 100% 100%;height: 690px;border-raduis:0px; display: flex; align-items: center;">
        
                <div class="mx-auto col-md-8 mt-n5">
                    <div class="jumbotron bg-transparent text-center text-light">
                        <h1 class="display-3" id="titles">Set your Username</h1>
                    </div>
                <form action="" method="post">
                    
                        <div class="form-group mx-auto col-8 pb-3">
                            <input type="text"
                                class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0 "
                                name="Username" id="username" placeholder="Enter your Username" required>
                        </div>
                        ';

                        if(isset($alreadyExisted)){


        if($alreadyExisted==1){
                            echo "<script> 
        $(function(){
            $('#modal-body').append('<p><i class=".'"fa fa-dashcube"' .' aria-hidden= '.'"true"'."></i>".$choosen." Is already existing choose another !</p> ');
            $('#myModal').modal('show');
        });
        $('#closebtn').click(function(){
            $('#modal-body').empty();
        });
        </script> ";  }
        else{ if($alreadyExisted==2){
            echo "<script> 
            $(function(){
                $('#modal-body').append('<p><i class=".'"fa fa-dashcube"' .' aria-hidden= '.'"true"'."></i>Invalide username, use letters and numbers only!(white space isnt allowed)</p> ');
                $('#myModal').modal('show');
            });
            $('#closebtn').click(function(){
                $('#modal-body').empty();
            });
            </script> ";}
            else{
                echo "<script> 
                $(function(){
                    $('#modal-body').append('<p><i class=".'"fa fa-dashcube"' .' aria-hidden= '.'"true"'."></i>You have already choosen a username!</p> ');
                    $('#myModal').modal('show');
                });
                $('#closebtn').click(function(){
                    $('#modal-body').empty();
                });
                </script> ";
            }
        }
                        }

                        echo'<div class="form-group mx-auto col-8 mt-4 " id="pispis">
                            <button type="submit" name="Ubtn" value="yupe" class="btn form_effect btn-dark col-12 border-0" id="RegBut"><span class="shadow"> 
                            <i class="fa fa-arrow-circle-right ml-n1 mr-1" aria-hidden="true"></i> Set</span></button>
                        </div>
        
                </form>
                </div>
                </div>
                
    
    ';
    
    echo'
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark text-light py-0">
        <ul class="navbar-nav mx-auto mt-3">
        <p> <a href="https://www.fb.com/SparoXUB" target="_blank" class="text-danger nav-link d-inline"> <span style="font-size:18px;font-family:Awsome;" >Ayoub Maghdaoui</span></a><span class="nav-link d-inline">©2019 All Rights Reserved</span> </p>
        </ul>
</nav>
    ';
}
?>