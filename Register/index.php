<?php 
include '../includes/config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign-Up !</title>
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.js"></script>
</head>
<body>


<nav class="navbar navbar-expand-md bg-dark navbar-dark py-2">
    <a class="navbar-brand" href="../"><span class="letter" style="font-size: 28px;">C-</span>NetworK </a>
    <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId"
        aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation"> <i
            class="fa fa-arrow-down "></i> </button>
    <div class="collapse navbar-collapse" id="collapsibleNavId">

        <form method="post" action="../Login/index.php" class="form-inline my-1 my-lg-0 mr-sm-4 ml-md-auto mx-md-0">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-dark"> <i class="fa fa-user btn-dark" aria-hidden="true"></i>
                    </span>
                </div>
                <input class="form-control mr-sm-2 bg-dark text-light border-top-0 border-right-0 border-left-0" type="email" name="LogEmail" placeholder="E-mail Address" required>
            </div>

            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-dark"> <i class="fa fa-key btn-dark" aria-hidden="true"></i>
                    </span>
                </div>
                <input class="form-control mr-sm-2 bg-dark text-light border-top-0 border-right-0 border-left-0" type="password" name="LogPass" placeholder="Password">
            </div>

            <div class="input-group">
            <button type="submit" name="loginbtn" value="yupe" class="btn btn-dark btn-outline-light my-2 my-sm-0"><i class="fa fa-arrow-right" aria-hidden="true"></i> Login</button>
            </div>
        </form>

    </div>
</nav>


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



<div class="jumbotron mb-n3 mt-n1" id="Register"
        style="background-image: url('../images/bg2.jpg'); 
    background-repeat: no-repeat;background-size: cover;height: 900px;border-raduis:0px;" >
        <h1 class="display-3 text-light text-center mt-n4 mb-3">Sign-Up!</h1>
        <p class="lead text-light text-center mb-0 mt-4">Allmost In !</p>

        <hr class="my-2 hidden mb-0">

        <div class="mx-auto col-7 mt-2">
        <form action="" method="post" id="regForm">

        <?php 
        if(isset($_POST['Lregister'])){
            
            $error=false;
            $fname=$_POST['fname'];
            $lname=$_POST['lname'];
            $email=$_POST['email'];
            $pwd=$_POST['password'];
            $age=$_POST['age'];
            $city=$_POST['city'];
            $Country=$_POST['Country'];

             //verify first name
            if( empty($fname) ){
                $fnamemsg="Please enter Your first name!";}
            if( isset( $fname ) && !preg_match("/^[a-zA-Z0-9 ]*$/",$fname) )
                $fnamemsg="Invalide Name,Only letters and numbers allowed!";
            
                if(isset($fnamemsg)){
                    $error=true;
                echo' 
                <div class="form-group mx-auto col-8 ">
                    <input type="text"
                        class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0 "
                        name="fname" id="fname" aria-describedby="helpId" placeholder="your first name" >
                </div>
                <div id="fnamealert" class="alert alert-danger alert-dismissible fade show col-6 text-center mx-auto mt-n3" style="left: 25%;position: absolute;z-index: 2;height:6%;" role="alert">
                    <button type="button" class="close mt-n3" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <p class="mt-n3">
                ' . $fnamemsg . ' 
                </p>
                </div>
                <script> 
                $("#fname").click(function () {
                    if ($("#fnamealert")) {
                      $("#fnamealert").hide();
                    }
                  });
                </script>
                '; }
        
                else 
                    echo '   
                    <div class="form-group mx-auto col-8 ">
                    <input type="text"
                        class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0 "
                        name="fname" id="fname" aria-describedby="helpId" placeholder="your first name" value="'.$fname.'">
                </div> ';

            // Verify last name
            if( empty($lname) ){
                $lnamemsg="Please enter Your Last name!";}
            if( isset( $lname ) && !preg_match("/^[a-zA-Z0-9 ]*$/",$lname) )
                $lnamemsg="Only letters and numbers allowed!";
            
                if(isset($lnamemsg)){
                    $error=true;
                echo' 
                <div class="form-group mx-auto col-8 ">
                <input type="text"
                    class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0 "
                    name="lname" id="lname" aria-describedby="helpId" placeholder="your Last name" >
                </div>
                <div id="lnamealert" class="alert alert-danger alert-dismissible fade show col-6 text-center mx-auto mt-n3" style="left: 25%;position: absolute;z-index: 2;height:6%;" role="alert">
                    <button type="button" class="close mt-n3" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <p class="mt-n3">
                ' . $lnamemsg . ' 
                </p>
                </div>
                <script> $("#lname").click(function () { if ($("#lnamealert")) { $("#lnamealert").hide();} }); </script>
                '; }
                else 
                    echo '   
                    <div class="form-group mx-auto col-8 ">
                    <input type="text"
                        class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0 "
                        name="lname" id="lname" aria-describedby="helpId" placeholder="your Last name" value="'.$lname.'" >
                      </div> ';

            // Verify Email Address
            if( empty($email) ){
                $emailmsg="Email Address is required !";}
            if( isset( $email)  && !filter_var($email, FILTER_VALIDATE_EMAIL) )
                $emailmsg="Invalide Email !";
            $checkEmail=mysqli_query($mysqli,"select * from users where Email='$email';");
            $EmailResult=$checkEmail->fetch_row();
            if(!empty($EmailResult['Email'])){
                $emailmsg="Already Registred Email !";
            }
            
            if(isset($emailmsg)){
                    $error=true;
                echo' 
                <div class="form-group mx-auto col-8 ">
                    <input type="email"
                        class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0 "
                        name="email" id="email" aria-describedby="helpId" placeholder="E-mail address" >
                </div>
                <div id="Emailalert" class="alert alert-danger alert-dismissible fade show col-6 text-center mx-auto mt-n3" style="left: 25%;position: absolute;z-index: 2;height:6%;" role="alert">
                    <button type="button" class="close mt-n3" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <p class="mt-n3">
                ' . $emailmsg . ' 
                </p>
                </div>
                <script> $("#email").click(function () { if ($("#Emailalert")) { $("#Emailalert").hide();} }); </script>
                '; }
                else 
                    echo '   
                    <div class="form-group mx-auto col-8 ">
                    <input type="email"
                        class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0 "
                        name="email" id="email" aria-describedby="helpId" placeholder="E-mail address" value="'.$email.'">
                </div> ';
            
            // Verify Password
            if( empty($pwd) ){
                $pwdmsg="Please enter Your Password!";}
            if( isset( $pwd ) && strlen($pwd)<8 )
            $pwdmsg="Short Password! at least 8 caracters.";
                if(isset($pwdmsg)){
                    $error=true;
                echo' 
                <div class="form-group mx-auto col-8 ">
                    <input type="password"
                        class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0 "
                        name="password" id="pwd1" aria-describedby="helpId" placeholder="Password" >
                </div>
                <div id="pwdalert" class="alert alert-danger alert-dismissible fade show col-6 text-center mx-auto mt-n3" style="left: 25%;position: absolute;z-index: 2;height:6%;" role="alert">
                    <button type="button" class="close mt-n3" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <p class="mt-n3">
                ' . $pwdmsg . ' 
                </p>
                </div>
                <div class="form-group mx-auto col-8 ">
                    <input type="password"
                        class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0 "
                        name="password1" id="pwd2" aria-describedby="helpId" placeholder="Confirm Password">
                </div>
                <script> $("#pwd1").click(function () { if ($("#pwdalert")) { $("#pwdalert").hide();} }); </script>
                '; }
                else 
                    echo '   
                    <div class="form-group mx-auto col-8 ">
                    <input type="password"
                        class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0 "
                        name="password" id="pwd1" aria-describedby="helpId" placeholder="Password">
                </div>
                <div class="form-group mx-auto col-8 ">
                    <input type="password"
                        class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0 "
                        name="password1" id="pwd2" aria-describedby="helpId" placeholder="Confirm Password">
                </div>';
            
            // Verify Age
            if( empty($age) ){
                $agemsg="Please enter Your Age!";}
            if( isset( $age ) && !preg_match("/^[0-9]*$/",$age) )
            $agemsg="Invalide Only numbers allowed!";
            if($age >90 || $age <8)
            $agemsg="invalide Age Value!";
                if(isset($agemsg)){
                    $error=true;
                echo' 
                <div class="form-group mx-auto col-8 ">
                    <input type="number" id="age" class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0 " name="age" aria-describedby="helpId" min=14 max=99 placeholder="Your Age ?" >
                </div>
                <div id="agealert" class="alert alert-danger alert-dismissible fade show col-6 text-center mx-auto mt-n3" style="left: 25%;position: absolute;z-index: 2;height:6%;" role="alert">
                    <button type="button" class="close mt-n3" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <p class="mt-n3">
                ' . $agemsg . ' 
                </p>
                </div>
                <script> $("#age").click(function () { if ($("#agealert")) { $("#agealert").hide();} }); </script>
                '; }
                else 
                    echo '   
                    <div class="form-group mx-auto col-8 ">
                    <input type="number"  value="'.$age.'" id="age" class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0 " name="age" aria-describedby="helpId" min=14 max=99 placeholder="Your Age ?" >
                </div>
                   ';

            // Verify city
            if( empty($city) ){
                $citymsg="Please enter city name!";}
            if( isset( $city ) && !preg_match("/^[a-zA-Z ]*$/",$city) )
            $citymsg="Invalide City name !";
            
                if(isset($citymsg)){
                    $error=true;
                echo' 
                <div class="form-group mx-auto col-8">
                    <input type="text" class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0"
                        name="city" id="city" aria-describedby="helpId" placeholder="city - Location">
                </div>
                <div id="Cityalert" class="alert alert-danger alert-dismissible fade show col-6 text-center mx-auto mt-n3" style="left: 25%;position: absolute;z-index: 2;height:6%;" role="alert">
                    <button type="button" class="close mt-n3" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <p class="mt-n3">
                ' . $citymsg . ' 
                </p>
                </div>
                <script> $("#city").click(function () { if ($("#Cityalert")) { $("#Cityalert").hide();} }); </script>
                '; }
                else 
                    echo '   
                    <div class="form-group mx-auto col-8">
                    <input type="text" class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0"
                        name="city" id="city" aria-describedby="helpId" placeholder="city - Location" value="'.$city.'">
                </div> ';

            // Verify Country
            if( empty($Country) ){
                $cntmsg="Please Select your Country!";}
            if( isset( $Country ) && !preg_match("/^[a-zA-Z]*$/",$Country) )
                $cntmsg="Invalide Country name!";
            
                if(isset($cntmsg)){
                    $error=true;
                echo' 
                
                <div class="form-group mx-auto col-8">
                      <select class="form-control bg-dark text-light border-right-0 border-left-0 border-top-0" name="Country" id="country">
                        <option value="" disabled selected> Select Your Country</option>';
                        $country_query="SELECT country_code,country_name from `apps_countries` ";
                        $result = mysqli_query($mysqli, $country_query); // equals to : $result = $mysqli->query($country_query);
                        while($row = $result->fetch_assoc()) { // equals to : $row = mysqli_fetch_assoc($result)
                            echo "<option value='" . $row["country_code"]. "'>" . $row["country_name"]. "</option> " ;
                        }
                echo '
                      </select>
                </div>

                <div id="CNTalert" class="alert alert-danger alert-dismissible fade show col-6 text-center mx-auto mt-n3" style="left: 25%;position: absolute;z-index: 2;height:6%;" role="alert">
                    <button type="button" class="close mt-n3" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <p class="mt-n3">
                ' . $cntmsg . ' 
                </p>
                </div>
                <script> $("#country").click(function () { if ($("#CNTalert")) { $("#CNTalert").hide();} }); </script>
                '; }
                else 
                    echo '   
                    <div class="form-group mx-auto col-8">
                      <select class="form-control bg-dark text-light border-right-0 border-left-0 border-top-0" name="Country" id="country" value="'.$Country.'">
                        <option value="" disabled selected> Select Your Country</option>';
                        $country_query="SELECT country_code,country_name from `apps_countries` ";
                        $result = mysqli_query($mysqli, $country_query); // equals to : $result = $mysqli->query($country_query);
                        while($row = $result->fetch_assoc()) { // equals to : $row = mysqli_fetch_assoc($result)
                            echo "<option value='" . $row["country_code"]. "'>" . $row["country_name"]. "</option> " ;
                        }
                echo '
                      </select>
                </div>
                    ';
            
            if(! $error){
            $fname=htmlspecialchars(strip_tags($fname));   
            $lname=htmlspecialchars(strip_tags($lname));
            $email=htmlspecialchars(strip_tags($email));
            $age=htmlspecialchars(strip_tags($age));
            $salt="SCoMae =!";
            $pwd=crypt($pwd,$salt);
            $city=htmlspecialchars(strip_tags($city));
            $Country=htmlspecialchars(strip_tags($Country));

            $register_query="INSERT INTO users  VALUES ('','$fname','$lname','$email','$pwd','$age','$city','$Country','png','false')";
            if( mysqli_query($mysqli, $register_query) ) { 
                //or using $mysqli->query($register_query);
                $registred=true;
                echo '
                <script> 
                $("#regForm").hide();  
                </script>
                ';
                
                }
            else{ 
                echo'
                <div class="alert alert-danger alert-dismissible fade show col-6 text-center mx-auto mt-n3" style="left: 25%;position: absolute;z-index: 2;height:6%;" role="alert">
                    <button type="button" class="close mt-n3" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <p class="mt-n3">
                <b>Something went Wrong!</b> try Again Later !
                </p>
                </div>
                ';
            }
            $mysqli->close();
             }
        }

        else{
            echo '
            
            <div class="form-group mx-auto col-8 ">
                    <input type="text"
                        class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0 "
                        name="fname" id="fname" aria-describedby="helpId" placeholder="your first name" >
                </div>
                <div class="form-group mx-auto col-8 ">
                    <input type="text"
                        class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0 "
                        name="lname" id="lname" aria-describedby="helpId" placeholder="your Last name" >
                </div> 
                <div class="form-group mx-auto col-8 ">
                    <input type="email"
                        class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0 "
                        name="email" id="email" aria-describedby="helpId" placeholder="E-mail address" >
                </div>
                <div class="form-group mx-auto col-8 ">
                    <input type="password"
                        class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0 "
                        name="password" id="pwd1" aria-describedby="helpId" placeholder="Password" >
                </div>
                <div class="form-group mx-auto col-8 ">
                    <input type="password"
                        class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0 "
                        name="password1" id="pwd2" aria-describedby="helpId" placeholder="Confirm Password">
                </div>
                <div class="form-group mx-auto col-8 ">
                    <input type="number" id="age" class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0 " name="age" aria-describedby="helpId" min=14 max=99 placeholder="Your Age ?" >
                </div>
                <div class="form-group mx-auto col-8">
                    <input type="text" class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0"
                        name="city" id="city" aria-describedby="helpId" placeholder="city - Location">
                </div>
                <div class="form-group mx-auto col-8">
                      <select class="form-control bg-dark text-light border-right-0 border-left-0 border-top-0" name="Country" id="country">
                        <option value="" disabled selected> Select Your Country</option>';
                        $country_query="SELECT country_code,country_name from `apps_countries` ";
                        $result = mysqli_query($mysqli, $country_query); // equals to : $result = $mysqli->query($country_query);
                        while($row = $result->fetch_assoc()) { // equals to : $row = mysqli_fetch_assoc($result)
                            echo "<option value='" . $row["country_code"]. "'>" . $row["country_name"]. "</option> " ;
                        }
                echo '
                      </select>
                </div>

            ';
        }
        ?>
                <div class="form-group mx-auto col-8 mt-4 " id="pispis">
                    <button type="submit" name="Lregister" value="yupe" class="btn form_effect btn-dark col-12 border-0" id="RegBut"><span class="shadow"> 
                    <i class="fa fa-arrow-circle-right ml-n1 mr-1" aria-hidden="true"></i> Sign In!</span></button>
                </div>

            </form>
        
        <?php
        if(! isset($registred)){
            echo'
            <div id="terms" class="text-center text-light mt-0 mb-0 pb-3">
            <p><i class="fa fa-dashcube" aria-hidden="true"></i> *By clicking Sign-in you are accepting all terms and conditions of Use !</p>
            </div>';
        }
        else{
            echo'
            <div class="alert alert-success text-center mt-0 mb-0 pb-3">
           <p class="display-5 text-success text-center"><i class="fa fa-dashcube" aria-hidden="true"></i>  You have registred succesfully! after activating your account you can log-in! !</p>
           </div> 
           <script>
           setTimeout(function(){ window.location.href = ".."; }, 8000);
           </script>
           ';
            }?>
        </div>

        <nav class="navbar navbar-expand-sm navbar-dark bg-dark text-light py-0 mt-3 mb-n4 fixed-bottom">
        <ul class="navbar-nav mx-auto py-1 mb-1">
        <p> <a href="https://www.fb.com/SparoXUB" target="_blank" class="text-danger nav-link d-inline"> <span style="font-size:18px;font-family:Awsome;" >Ayoub Maghdaoui</span></a><span class="nav-link d-inline">©2019 All Rights Reserved</span> </p>
        </ul>
        </nav>

    <?php 
if(isset($_POST['Pregister'])){
    echo "
        <script>
        document.getElementById('fname').value = '" . $_POST['fname'] ." ';
        document.getElementById('lname').value = '" . $_POST['lname'] ." ';
        document.getElementById('email').value = '" . $_POST['email'] ." ';
        document.getElementById('age').value = " . $_POST['age'] ." ;
        </script>
        ";
    }
    
    
    ?>
    <!-- script -->
    <script src="../js/myscript.js"></script>
</body>
</html>
