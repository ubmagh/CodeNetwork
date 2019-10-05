<?php 
session_start();
include "./includes/config.php";


if(isset($_SESSION['id'])){

echo'<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/font-awesome.min.css">
        <link rel="stylesheet" href="../css/bootstrap.css">
        <link rel="stylesheet" href="../css/simple-sidebar.css">
        <script src="../js/jquery.js"></script>
        <script src="../js/bootstrap.js"></script>
        <title>-AdminCP-</title>
    </head><body>';

include "includes/nav&sidebar.php";
$LastLog=$mysqli->query("SELECT LastLogin FROM admin WHERE id=10;");
$LastLog=$LastLog->fetch_assoc();
$LastLog=$LastLog['LastLogin'];
echo'
<div class="container-fluid">
<h1 class="mt-4 col-md-4 mx-auto">DashBoard</h1>
<div class="row mt-4">  
    <div class="col alert alert-success pr-0 py-5">
        <h3>last Time Logged-In:</h3> <br> 
        <h5 class="ml-5 mr-n5 pl-4 col-6 text-info ">'.$LastLog.'</h5>   
    </div>';

    $usersInfos=mysqli_query($mysqli,"SELECT count(*) AS NUM FROM users;");
    $usersInfos= $usersInfos->fetch_assoc();
    $numUsers=$usersInfos['NUM'];
    $usersInfos= mysqli_query($mysqli,"SELECT count(*) AS NUMAC FROM users WHERE Activated=1 ;");
    $usersInfos= $usersInfos->fetch_assoc();
    $numUsersAc= $usersInfos['NUMAC'];
    echo '
    <div class="col">
        <div class="alert alert-info py-5 pr-0">
            <h4>Number Of registred Users :  <span class="mx-3 text-success">'.$numUsers.' </span>  </h4> <br> 
            <h4>activated accounts :  <span class="mx-3 text-success">'.$numUsersAc.' </span>  </h4> <br>
            <h5 class="ml-5 mr-n5 pl-4 col-6 text-info "></h5>  
        </div>
    </div>
</div>';

$messages=$mysqli->query("SELECT count(*) as nmsg FROM contact;");
$messages= $messages->fetch_assoc();
$messages=$messages['nmsg'];

$reports=$mysqli->query("SELECT count(*) as numrep FROM reports;");
$reports=$reports->fetch_assoc();
$reports=$reports['numrep'];

echo'
<div class="row mt-1 mb-5">  
    
    <div class="col alert alert-warning pr-0 py-5"> 
        <h3>Messages : </h3> <br> 
        <h5 class="pl-5 col-6 text-danger text-center ml-5 mt-n3">'.$messages.'</h5>   
    </div>
    <div class="col alert alert-danger py-5 pr-0 ml-3">
    <h3>Reports : </h3> <br> 
    <h5 class="pl-5 col-6 text-danger text-center ml-5 mt-n3">'.$reports.'</h5> 
    </div>
</div>
</div>
</div>
<!-- /#page-content-wrapper -->

<!-- Menu Toggle Script -->
<script>
$("#menu-toggle").click(function(e) {
e.preventDefault();
$("#wrapper").toggleClass("toggled");
});
</script>
</div>
';


}else{
    echo'<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.js"></script>
    <title>Admin Login</title>
</head><body>';

    echo'


    <nav class="navbar navbar-expand-md bg-dark navbar-dark py-3 mb-0">
    <div class="mx-auto">
        <a class="navbar-brand" href="../"><span class="letter mt-n5" style="font-size: 28px;">Code</span>NetworK </a>
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
                    <p><i class="fa fa-dashcube" aria-hidden= "true"></i> Bad Credentiels, Try again! </p>
                    </div>  
                    <!-- Modal footer -->
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closebtn">Close</button>
                    </div>
                    </div>
                </div>
            </div>
   
    <div style="background-image: url('."'../images/bg6.jpg'".');height:700px;background-repeat: no-repeat;background-size: cover;" class="py-5 mt-n5">
        <form action="" method="post" class="col-8 mx-auto mt-3">
    
            <div class="jumbotron bg-transparent text-center text-dark mt-3">
                <h1 class="display-3" id="titles">Control Panel</h1>
            </div>

              <div id="usernamediv" class="form-group mx-auto col-8 " >
                    <input type="text"
                        class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0 "
                        name="username" id="username" aria-describedby="helpId" placeholder="Username" >
                </div>';

                if(isset($_POST['CPlogin'])){

                    $error=false;
                    $username=$_POST['username'];
                    $password=$_POST['password'];
                
                    //checking username
                    if( empty($username) ){
                        $error=true;
                        echo '
                        <div id="namealert" class="alert alert-danger alert-dismissible fade show col-6 text-center mx-auto mt-n3" style="left: 25%;position: absolute;z-index: 2;height:6%;" role="alert">
                        <button type="button" class="close mt-n3" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <p class="mt-n3">
                        Enter Username ! 
                    </p>
                    </div>
                        <script>
                        $("#username").click(function () {
                                 if ($("#namealert")) {
                                     $("#namealert").hide();
                                    }
                                  });
                         </script>
                        ';
                    }

                echo'
                <div class="form-group mx-auto col-8 ">
                    <input type="password"
                        class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0 "
                        name="password" id="pwd" aria-describedby="helpId" placeholder="Password" >
                </div>';

                    //check password not null
                    if( empty($password) ){
                        $error=true;
                        echo '
                        <div id="pwdalert" class="alert alert-danger alert-dismissible fade show col-6 text-center mx-auto mt-n3" style="left: 25%;position: absolute;z-index: 2;height:6%;" role="alert">
                        <button type="button" class="close mt-n3" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <p class="mt-n3">
                        Enter Password !
                    </p>
                    </div>
                        <script>
                        $("#pwd").click(function () {
                                 if ($("#pwdalert")) {
                                     $("#pwdalert").hide();
                                    }
                                  });
                         </script>
                        ';
                    }
                    // credentiels checking from db !
                if(! $error){
                $password=crypt($password,"SCoMae =!");
                $CP=mysqli_query($mysqli,"SELECT id,password FROM admin WHERE username='$username' ");
                $result=$CP->fetch_assoc();
                if( $result["password"]===$password){
                   $_SESSION['id']=$result['id'];
                   $time=date("Y-m-d h:i:s");
                   $CP="UPDATE `admin` SET `LastLogin` = '$time' WHERE `admin`.`id` = 10; ";
                   $mysqli->query($CP);
                   if($CP)    {
                    header("location:./");
                }

                }
                else{
                    //bad credentiels SC9aLMg218r6E 
                    echo"
                    <script> 
                    $(function(){
                    $('#myModal').modal('show');
                            });
                     </script> ";
                }
                }

                }else{
                    echo'
                <div class="form-group mx-auto col-8 ">
                    <input type="password"
                        class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0 "
                        name="password" id="pwd" aria-describedby="helpId" placeholder="Password" >
                </div>';
                }
                echo'
                <div class="form-group mx-auto col-8 mt-4 " id="pispis">
                    <button type="submit" name="CPlogin" value="yupe" class="btn form_effect btn-dark col-12 border-0" id="RegBut"><span class="shadow"> 
                    <i class="fa fa-arrow-circle-right ml-n1 mr-1" aria-hidden="true"></i> Log In!</span></button>
                </div>

        </form>
    </div>';
}

include "includes/footer.php";
?>
