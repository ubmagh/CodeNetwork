<?php
session_start();
include('../includes/config.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>C- Login</title>
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
            <a class="navbar-brand" href="../"><span class="letter" style="font-size: 28px;">Code</span>NetworK </a>
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


    <div class="container-fluid pt-5 " style="background-image: url('../images/bg5.jpg'); 
    background-repeat: no-repeat;background-size: 100% 100%;height: 690px;border-raduis:0px; display: flex; align-items: center;">

        <div class="mx-auto col-md-8 mt-n5">
            <div class="jumbotron bg-transparent text-center text-light">
                <h1 class="display-3" id="titles">Log-in</h1>
            </div>
            <form action="" method="post">

                <div class="form-group mx-auto col-8 pb-3">
                    <input type="email" class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0 " name="LogEmail" id="email" placeholder="Email Address">
                </div>

                <div class="form-group mx-auto col-8 ">
                    <input type="Password" class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0 " name="LogPass" id="password" placeholder="Password">
                </div>

                <div class="form-group mx-auto col-8 mt-4 " id="pispis">
                    <button type="submit" name="loginbtn" value="yupe" class="btn form_effect btn-dark col-12 border-0" id="RegBut"><span class="shadow">
                            <i class="fa fa-arrow-circle-right ml-n1 mr-1" aria-hidden="true"></i> Login</span></button>
                </div>

            </form>
        </div>
    </div>


    <?php

    if (isset($_POST['loginbtn'])) {
        $email = $_POST['LogEmail'];
        $password = $_POST['LogPass'];
        $password = crypt($password, "SCoMae =!");
        $stmt = $mysqli->prepare("SELECT Email,password,id FROM `users` WHERE Email=? and password=? ");
        $stmt->bind_param('ss', $email, $password);
        $stmt->execute();
        $stmt->bind_result($email, $password, $id);
        $rs = $stmt->fetch();
        $stmt->close();
        $_SESSION['id'] = $id;
        $_SESSION['login'] = $email;
        $uip = $_SERVER['REMOTE_ADDR'];
        $ldate = date("Y-m-d h:i:s");
        $isActivated = mysqli_query($mysqli, "select Activated from users where id='$id'");
        $isActivated = $isActivated->fetch_row();
        if ($isActivated[0] == 0) {
            $isActivated = false;
        } else {
            $isActivated = true;
        }
        if ($rs) {
            ////////
            if ($isActivated) {

                $uid = $_SESSION['id'];
                $uemail = $_SESSION['login'];
                $ip = $_SERVER['REMOTE_ADDR'];
                $hostName = '<br>' . $_SERVER['REMOTE_HOST'] . ' ' . $_SERVER['HTTP_USER_AGENT'];
                $log = "insert into userlog values('','$hostName','$uemail','$ip','$ldate')";
                $mysqli->query($log);

                $Profiled = $mysqli->query("SELECT username FROM profiles WHERE Email='$uemail';");
                $Profiled = $Profiled->fetch_assoc();
                $username = $Profiled['username'];
                if (empty($username)) {
                    $_SESSION['email'] = $uemail;
                    header("location:./create_username.php");
                } else {
                    if ($log) {
                        $_SESSION['email'] = $uemail;
                        $_SESSION['username'] = $username;
                        $_SESSION['id'] = $id;
                        header("location:../dashboard/");
                    } else {
                        echo '<script>alert("Login Error!");</script>';
                    }
                }
            } else {
                echo "<script> 
            $(function(){
                $('#modal-body').append('<p><i class=" . '"fa fa-dashcube"' . ' aria-hidden= ' . '"true"' . "></i> Your Account is not activated yet!</p> ');
                $('#myModal').modal('show');
            });
            $('#closebtn').click(function(){
                $('#modal-body').empty();
                $('#email').attr('value','" . $_POST['LogEmail'] . "') ;
            });
            </script> ";
            }
        } else {

            echo "<script> 
        $(function(){
            $('#modal-body').append('<p><i class=" . '"fa fa-dashcube"' . ' aria-hidden= ' . '"true"' . "></i> Bad Credentiels, Try again! </p> ');
            $('#myModal').modal('show');
        });
        $('#closebtn').click(function(){
            $('#modal-body').empty();
            $('#email').attr('value','" . $_POST['LogEmail'] . "') ;
        });
        </script> ";
        }
    } else { }
    $mysqli->close();
    ?>
    <?php include "../footer.php"; ?>


    <!-- scripts-->


</body>

</html>