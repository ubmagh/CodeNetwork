<?php
session_start();
include 'includes/config.php';
if (isset($_SESSION['username'])) {
    header("location:./dashboard/"); ////Untile you create a dashBoard
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CodeNetwork</title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>

    <style>
    .sticky {
  position: fixed;
  top: 0;
  width: 100%;
}
    </style>
</head>

<body data-spy="scroll" data-target="#navbarscrolspy" data-offset="600" style="overflow: unset;">

    <?php include("header.php"); ?>

    <div class="jumbotron mb-0 mt-n5 mb-n1" id="main" style="height: 90% !important; background-image: url('images/bg1.jpg');background-size: cover;height: 700px;border-raduis:0px;">
        <h1 class="display-1 my-5 text-center text-3x text-light"><span class="letter" style="font-size: 88px;">Code</span>Network</span></h1>
        <p class="lead text-center my-5 text-white">
            Having problems while coding Alone ? Join our social network
            <br>
            it's just for programmers Only! Join Now, Find your friends and start coding together !
        </p>

        <div class="text-center mt-5 mb-0 col-3 mx-auto">
            <a name="" id="" class="btn btn-dark shadow-lg btn-lg btn-outline-light border-dark btn-block" href="#Register" role="button">Sign up Now!</a>
        </div>

    </div>



    <nav class="navbar py-3 navbar-dark bg-dark sticky-top  " style="overflow:unset;" id="navbarscrolspy">
        <ul class="navbar-nav nav-pilloss mx-auto d-inline">
            <li class="nav-item d-inline pill-black mx-1"> <a href="#main" class=" px-2 nav-link active d-inline"> <i class="fa fa-home" aria-hidden="true"></i> Home</a> </li>
            <li class="nav-item d-inline pill-black"> <a href="#features" class=" px-2 nav-link d-inline"><i class="fa fa-star" aria-hidden="true"></i> Features</a> </li>
            <li class="nav-item d-inline pill-black"> <a href="#Register" class=" px-2 nav-link d-inline"><i class="fa fa-sign-in" aria-hidden="true"></i> Sign-Up</a> </li>
            <li class="nav-item d-inline pill-black"> <a href="#contact" class=" px-2 nav-link d-inline"><i class="fa fa-envelope" aria-hidden="true"></i> Contact</a> </li>
        </ul>
    </nav>


    <div class="jumbotron mb-0 mb-n1 mt-n1" id="features" style="height: 100% !important; background-image: url('images/bg3.jpg'); background-repeat: no-repeat;background-size: cover;height: 740px;border-raduis:0px;">

        <div class="container align-bottom h-75 my-0 d-flex align-items-end">
            <div class="row h-25 mt-1 ml-3">

                <div class="col-3 px-2 py-2 card text-left text-light ml-n5 " style="background-color: rgba(15,10,10,0.7);">
                    <div class="card-body text-center ">
                        <h4 class="card-title ">Available Anytime & Anywhere</h4>
                        <p class="card-text">Write, Test and view your codes from any device, and at any time.</p>
                    </div>
                </div>

                <div class="col-3 px-2 py-2 card text-left text-light mx-4" style="background-color: rgba(15,10,10,0.7);">
                    <div class="card-body text-center">
                        <h4 class="card-title ">Unbound Learning</h4>
                        <p class="card-text"> Learn by Practicing offered languages, or by Helping other members to solve their problems .</p>
                    </div>
                </div>

                <div class="col-3 px-2 py-2 card text-left text-light mr-4" style="background-color: rgba(15,10,10,0.7);">
                    <div class="card-body text-center">

                        <h4 class="card-title ">a Social Network</h4>
                        <p class="card-text"> CodeNetwork is a social network which allows several fonctionalities in common social networks like chating, comments...</p>
                    </div>
                </div>

                <div class="col-3 px-2 py-2 card text-left text-light mr-n5" style="background-color: rgba(15,10,10,0.7);">
                    <div class="card-body text-center">
                        <h4 class="card-title "> Gather Talents </h4>
                        <p class="card-text"> Discover experienced members and Boost Your Learning by Following and getting in touch with them. </p>
                    </div>
                </div>

            </div>
        </div>

    </div>


    <div class="jumbotron mb-0 mt-n1 mb-n5" id="Register" style="height: 100% !important; background-image: url('images/bg2.jpg'); 
    background-repeat: no-repeat;background-size: cover;height: 840px; ">
        <h1 class="display-3 text-light text-center">Register Now!</h1>
        <p class="lead text-white text-center">Join your Freinds, It's Free !</p>
        <hr class="my-2 hidden mb-5">

        <div class="mx-auto col-7 mt-2">

            <!-- modals -->
            <div class="modal fade" id="myModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title text-warning"> <i class="fa fa-times-circle-o text-danger fa-lg" aria-hidden="true"></i> Invalid Form !</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body text-danger text-center" id="modal-body">

                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>

                    </div>
                </div>
            </div>
            <!-- modals end --->

            <form action="./Register/" method="post">
                <div class="form-group mx-auto col-8 ">
                    <input type="text" class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0 " name="fname" id="fname" aria-describedby="helpId" placeholder="your first name">
                </div>

                <div class="form-group mx-auto col-8 ">
                    <input type="text" class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0 " name="lname" id="lname" aria-describedby="helpId" placeholder="your Last name">
                </div>

                <div class="form-group mx-auto col-8 ">
                    <input type="email" class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0 " name="email" id="email" aria-describedby="helpId" placeholder="E-mail address">
                </div>

                <div class="form-group mx-auto col-8 ">
                    <input type="number" name="age" id="age" class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0 " aria-describedby="helpId" min=14 max=99 placeholder="you Age ?">
                </div>

                <div class="form-group mx-auto col-8 mt-4 " id="pispis">
                    <button type="submit" name="Pregister" value="set" class="btn form_effect btn-dark col-12 border-0" id="RegBut"><span class="shadow">
                            <i class="fa fa-arrow-circle-right ml-n1 mr-1" aria-hidden="true"></i> Sign In!</span></button>
                </div>

            </form>

            <div id="terms" class="text-center text-light mt-4 mb-n5">
                <p><i class="fa fa-dashcube" aria-hidden="true"></i> *By clicking Sign-in you are accepting all terms and conditions of Use !</p>
            </div>
        </div>

    </div>

    <div class="jumbotron mb-0 mb-n1 mt-n2 d-flex align-items-center" id="contact" style="background-image: url('images/bg4.jpg'); background-repeat: no-repeat;background-size: 100% 100%;height: 840px;border-raduis:0px;">

        <div class="col-10 mx-auto ">
            <div class="mx-auto mt-n5 mb-3 d-block col-1"><i class="fa fa-envelope text-white display-2 ml-n2" aria-hidden="true"></i>
            </div>

            <form action="./#contact" method="post" class="col-12 mx-auto">

                <?php
                $flag = false;
                if (isset($_POST['Messaged'])) {
                    $flag = true;
                    $ContactFullName = $_POST['contactFullName'];
                    $Contactemail = $_POST['ContactEmail'];
                    $Message = $_POST['Message'];
                }


                if ($flag) {

                    $error = false;
                    //verify name
                    if (empty($ContactFullName)) {
                        $namemsg = "Please enter Your Name!";
                    }
                    if (isset($ContactFullName) && !preg_match("/^[a-zA-Z ]*$/", $ContactFullName)) ///////
                        $namemsg = "Invalide Name, Only letters and white space allowed!";

                    if (isset($namemsg)) {
                        $error = true;
                        echo ' 
        <div class="form-group col-7 mx-auto ">
            <input type="text" class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0 mb-0" required name="contactFullName" id="contactFullName" aria-describedby="helpId" placeholder="Full Name">
        </div>
        <div id="namealert" class="alert alert-danger alert-dismissible fade show col-6 text-center mx-auto mt-n3" style="left: 25%;position: absolute;z-index: 2;" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        ' . $namemsg . ' 
        </div> ';
                    } else
                        echo '   
            <div class="form-group col-7 mx-auto ">
            <input type="text" class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0" required name="contactFullName" id="contactFullName" aria-describedby="helpId" placeholder="Full Name">
            </div>  ';


                    //verify email
                    if (empty($Contactemail)) {
                        $emailmsg = "Email address is required !";
                    }
                    if (isset($Contactemail) && !filter_var($Contactemail, FILTER_VALIDATE_EMAIL)) ///////
                        $emailmsg = "Invalide email address !";

                    if (isset($emailmsg)) {
                        $error = true;
                        echo ' 
            <div class="form-group col-7 mx-auto my-4">
            <input type="email" class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0" required name="ContactEmail" id="ContactEmail" aria-describedby="helpId" placeholder="E-mail Address">
            </div>
            <div id="emailalert" class="alert alert-danger alert-dismissible fade show col-6 text-center mx-auto mt-n4" style="left: 25%;position: absolute;z-index: 2;" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            ' . $emailmsg . ' 
            </div> ';
                    } else
                        echo '   
                <div class="form-group col-7 mx-auto my-4">
                <input type="email" class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0" required name="ContactEmail" id="ContactEmail" aria-describedby="helpId" placeholder="E-mail Address">
                 </div> ';

                    //verify message
                    if (empty($Message)) {
                        $error = true;
                        echo ' 
            <div class="form-group col-7 mx-auto">
            <textarea class="form-control shadow form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0 " required style="resize:none;" name="Message" id="Message" rows="10" placeholder="Your Message"></textarea>
            </div>
            <div id="msgalert" class="alert alert-danger alert-dismissible fade show col-6 text-center mx-auto mt-n3" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                Empty Contact message !
            </div> ';
                    } else
                        echo '   
                <div class="form-group col-7 mx-auto ">
                <textarea class="form-control shadow form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0 " required style="resize:none;" name="Message" id="Message" rows="10" placeholder="Your Message"></textarea>
                </div>
                ';

                    if (!$error) {
                        echo '
            <div id="dis" class="alert alert-success alert-dismissible fade show col-6 text-center mx-auto mt-n3" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                Your Message Was Sent <bold> Successfully ! </bold>
            </div>
            <script>
                setTimeout(function() {$("#dis").hide();}, 10000);
            </script>';

                        $Message = strip_tags($Message);
                        $Message = htmlspecialchars($Message);
                        $time = date("Y-m-d h:i:s");
                        $mysqli_contact = "INSERT INTO `contact` VALUES ('','$time','$ContactFullName','$Contactemail','$Message') ";
                        $stmt_contact = $mysqli->query($mysqli_contact);
                        //$stmt_contact->execute();
                        $mysqli->close();
                    }
                } else {
                    echo '
            <div class="form-group col-7 mx-auto ">
            <input type="text" class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0" required name="contactFullName" id="contactFullName" aria-describedby="helpId" placeholder="Full Name">
            </div>
            <div class="form-group col-7 mx-auto my-4">
            <input type="email" class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0" required name="ContactEmail" id="ContactEmail" aria-describedby="helpId" placeholder="E-mail Address">
            </div>
            <div class="form-group col-7 mx-auto ">
            <textarea class="form-control shadow form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0 " required style="resize:none;" name="Message" id="Message" rows="10" placeholder="Your Message"></textarea>
            </div>
            ';
                }
                ?>

                <div class="form-group mx-auto col-7 mt-4 opacityChange">
                    <button type="submit" id="Messaging" name="Messaged" value="yupe" class="btn form_effect btn-dark col-12 border-0"><span class="shadow"> <i class="fa fa-mail-forward ml-n1 mr-1" aria-hidden="true"></i> Send !</span></button>
                </div>


            </form>
        </div>

    </div>
    <?php include "footer.php";
    ?>


    <!-- scripts-->

    
    <script src="js/myscript.js"></script>
    <!-- smooth scroll -->
    <script src="js/smooth-scroll.js"></script>
    <script>

                // When the user scrolls the page, execute myFunction
        window.onscroll = function() {myFunction()};

        // Get the navbar
        var navbar = document.getElementById("navbarscrolspy");

        // Get the offset position of the navbar
        var sticky = navbar.offsetTop;

        // Add the sticky class to the navbar when you reach its scroll position. Remove "sticky" when you leave the scroll position
        function myFunction() {
        if (window.pageYOffset >= sticky) {
            navbar.classList.add("sticky")
        } else {
            navbar.classList.remove("sticky");
        }
        } 

        var scroll = new SmoothScroll('a[href*="#"]', {
            speed: 2000,
            speedAsDuration: true //for all animation got 2000ms
        });
    </script>

</body>

</html>

<?php
mysqli_close($mysqli);
?>