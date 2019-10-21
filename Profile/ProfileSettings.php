<?php
session_start();
if (isset($_SESSION['username'])) {
    include "../includes/config.php";
    $username = $_SESSION['username'];
    $email = $_SESSION['email']; /////this email could get changed so update profiles and users tables

    $getter = $mysqli->query("SELECT * FROM users WHERE  Email='$email' ;");
    $getter = $getter->fetch_assoc();
    $Fname = $getter['Fname'];
    $Lname = $getter['Lname'];
    $email = $getter['Email'];
    $age = $getter['age'];
    $city = $getter['City'];
    $pwd = $getter['password'];
    $Country = $getter['Country'];
    $Uid = $getter['id'];

    $getter = $mysqli->query("SELECT * FROM description WHERE  username='$username' ;");
    $getter = $getter->fetch_assoc();
    $description = $getter['Description'];

    if (isset($_POST['Changeinfos'])) {
        $error = false;

        $salt = "SCoMae =!";

        if ($_POST['Fname'] != $Fname) {
            $Fname = $_POST['Fname'];
            if (!preg_match("/^[a-zA-Z ]*$/", $Fname)) {
                $FnameERR = 1;
                $error = true;
            } else {
                $Cfname = true;
            }
        }

        if ($_POST['Lname'] != $Lname) {
            $Lname = $_POST['Lname'];
            if (!preg_match("/^[a-zA-Z ]*$/", $Lname)) {
                $LnameERR = 1;
                $error = true;
            } else {
                $Clname = true;
            }
        }

        if ($_POST['city'] != $city) {
            $city = $_POST['city'];
            if (!preg_match("/^[a-zA-Z ]*$/", $city)) {
                $cityERR = 1;
                $error = true;
            } else {
                $Ccity = true;
            }
        }

        if ($_POST['email'] != $email) {
            $email = $_POST['email'];
            $checkEmail = mysqli_query($mysqli, "select * from users where Email='$email';");
            $EmailResult = $checkEmail->fetch_row();
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailERR = 1;
                $error = true;
            } elseif (!empty($EmailResult['Email'])) {
                $error = true;
                $emailERR = 2;
            } else {
                $Cemail = true;
            }
        }

        if ($_POST['age'] != $age) {
            $age = $_POST['age'];
            if ($age > 89 || $age < 12) {
                $ageERR = 1;
                $error = true;
            } else {
                $Cage = true;
            }
        }

        if ($_POST['country'] != $Country) {
            $Country = $_POST['age'];
            if (strlen($Country) > 2 || !preg_match("/^[a-zA-Z]*$/", $Country)) {
                $CountERR = 1;
                $error = true;
            } else {
                $Ccountry = true;
            }
        }

        if (!empty($_POST['newpassword'])) {
            $Npwd = $_POST['newpassword'];
            if (strlen($Npwd) < 8) {
                $NewPwdERR = 1;
                $error = true;
            } elseif (empty($_POST['oldpassword'])) {
                $error = true;
                $NewPwdERR = 2;
            } else {
                $Cpwd = true;
                $Npwd = crypt($Npwd, $salt);
            }
        }

        if ($_POST['description'] != $description) {
            $description = $_POST['description'];
            if (!preg_match("/^[a-z A-Z!?#@.+-]*$/", $description)) {
                $DescErr = 1;
                $error = true;
            } else {
                $CDesc = true;
            }
        }

        if (empty($_POST['oldpassword'])) {
            $error = true;
            $OldPwdERR = 1;
        } else {
            $getOldPwd = $mysqli->query("SELECT password FROM users WHERE id='$Uid';");
            $getOldPwd = $getOldPwd->fetch_assoc();
            $getOldPwd = $getOldPwd['password'];

            if ($getOldPwd != crypt($_POST['oldpassword'], $salt)) {
                $error = true;
                $OldPwdERR = 2;
            }
        }

        if (!empty($_FILES["AVA"]["name"])) {
            $target_dir = "./Avatars/";
            $target_file = $target_dir . basename($_FILES["AVA"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["AVA"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                $uploadOk = 2;
            }

            // Check file size 500kb
            if ($_FILES["AVA"]["size"] > 500000) {
                $uploadOk = 3;
            }

            // Allow certain file formats
            if (($imageFileType != "png") && ($imageFileType != "bmp") && ($imageFileType != "jpg") && ($imageFileType != "jpeg") && ($imageFileType != "gif")) {
                $uploadOk = 4;
            }

            //check image dimensions
            // Get Image Dimension
            $width = $check[0];
            $height = $check[1];
            if ($width > 512 || $height > 512) {
                $uploadOk = 5;
            }

            if ($uploadOk == 1) {
                $EXT = $mysqli->query("SELECT avatarEXT FROM users WHERE id='$Uid'");
                $EXT = $EXT->fetch_assoc();
                move_uploaded_file($_FILES["AVA"]["tmp_name"], $target_file);
                unlink($target_dir . $username . "." . $EXT['avatarEXT']);
                rename($target_file, $target_dir . $username . '.' . $imageFileType);
                $mysqli->query("UPDATE users SET avatarEXT='$imageFileType' WHERE id='$Uid'");
            } else {
                $error = true;
            }
        }


        if (!$error) {
            $updatequery = "Update users Set ";
            if (isset($Cfname)) $updatequery = $updatequery . "Fname='$Fname' ";
            if (isset($Clname)) $updatequery = $updatequery . ",Lname='$Lname' ";
            if (isset($Cage)) $updatequery = $updatequery . ",age='$age' ";
            if (isset($Ccity)) $updatequery = $updatequery . ",City='$city' ";
            if (isset($Cemail)) $updatequery = $updatequery . ",Email='$email' ";
            if (isset($Ccountry)) $updatequery = $updatequery . ",Country='$Country' ";
            if (isset($Cpwd)) $updatequery = $updatequery . ",password='$Npwd' ";

            $updatequery = $updatequery . " Where id='$Uid' ;";
            $mysqli->query($updatequery);
            if (isset($Cemail)) {
                //changer les variables de session et l'email de ce user dans profiles table
                $_SESSION['Uemail'] = $email;
                $mysqli->query("update profiles set Email='$email' where username='$username';");
            }

            if (isset($CDesc)) { //update description if changed
                $mysqli->query("UPDATE description SET Description='$description' where username='$username';");
            }
        }
    }

    echo '
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Account Settings</title>
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
<div class="area" style="background-image: url(' . "' ./includes/img/set.jpg'" . ') !important;background-size: 100% 100% !important; height:790px;">

<!-- page content here -->
<div class="jumbotron col-6 mx-auto bg-transparent mt-n3 mb-0">
    <h1 class="display-4 text-center text-light">Account Settings</h1>
    <hr class="my-1 mx-auto col-11 bg-light">  
</div>';
    if ((!empty($error)) && ($error == true)) {
        echo '
<div id="namealert" class="alert alert-danger alert-dismissible fade show col-6 text-center mx-auto mt-0" style="left: 25%; top:120px;position: absolute;z-index: 2;" role="alert">
                            <button type="button" class="close" data-dismiss="alert" id="closesuc" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <p>
                                Update Failed ! 
                            </p>
</div>';
    } elseif ((isset($error)) && ($error == false)) {
        echo '
<div id="namealert" class="alert alert-success alert-dismissible fade show col-6 text-center mx-auto mt-0" style="left: 25%; top:120px;position: absolute;z-index: 2;" role="alert">
                            <button type="button" class="close" data-dismiss="alert" id="closesuc" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <p>
                                Update Successed! 
                            </p>
</div>';
    }

    echo '
<form action="" method="post"  enctype="multipart/form-data">
<div class="row mt-0 pr-0">
    <div class="col border-right border-light ml-5 mr-0"> 

    <!-- first column -->

        <div class="form-group col-md-10 mx-auto pl-0">
            <input type="text" name="Fname" id="Fname" class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0" placeholder="First Name" value="' . $Fname . '">
        </div>
        ';
    if (isset($FnameERR)) {
        echo '
            
            <div id="namealert" class="alert alert-danger alert-dismissible fade show col-6 text-center mx-auto mt-0" style="left: 25%; top:35px;position: absolute;z-index: 2;height:35px;" role="alert">
                <button type="button" class="close mt-n2" data-dismiss="alert" id="closesuc" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <p class="mt-n2">
                    invalide First Name !
                </p>
            </div>
';
    }


    echo '
        <div class="form-group col-md-10 mx-auto pl-0 mt-5">
            <input type="email" name="email" id="email" class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0" placeholder="Email Address" value="' . $email . '">
        </div>';
    if (isset($emailERR)) {

        echo '
            
            <div id="namealert" class="alert alert-danger alert-dismissible fade show col-6 text-center mx-auto mt-0" style="left: 25%; top:120px;position: absolute;z-index: 2;height:35px;" role="alert">
                <button type="button" class="close mt-n2" data-dismiss="alert" id="closesuc" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <p class="mt-n2">';
        if ($emailERR == 1) echo 'Invalid email address!';
        else echo 'choosen email already registred';
        echo '   </p>
            </div>
                ';
    }

    echo '
        <div class="form-group col-md-10 mx-auto pl-0 mt-5">
            <input type="password" name="oldpassword" id="pwd1" class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0" placeholder="Old Password" >
        </div>';
    if (isset($OldPwdERR)) {
        echo '
            <div id="namealert" class="alert alert-danger alert-dismissible fade show col-7 text-center mx-auto mt-0" style="left: 24%; top:210px;position: absolute;z-index: 2;height:35px;" role="alert">
                <button type="button" class="close mt-n2" data-dismiss="alert" id="closesuc" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <p class="mt-n2">';
        if ($OldPwdERR == 1) echo 'oldpassword required to save any changes';
        else echo 'Wrong Password !';
        echo '
                </p>
            </div>
                    ';
    }

    echo '
        <div class="form-group col-md-10 mx-auto pl-0 mt-5">
            <input type="text" name="city" id="city" class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0" placeholder="City-Location" value="' . $city . '">
        </div>';
    if (isset($cityERR)) {
        echo '
            <div id="namealert" class="alert alert-danger alert-dismissible fade show col-6 text-center mx-auto mt-0" style="left: 25%; top:295px;position: absolute;z-index: 2;height:35px;" role="alert">
                <button type="button" class="close mt-n2" data-dismiss="alert" id="closesuc" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <p class="mt-n2">
                    invalide City Name !
                </p>
            </div>
        ';
    }

    echo '
        <div class="form-group col-md-10 mx-auto pl-0 mt-5">
          <textarea class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0" name="description" id="" rows="2" placeholder="write about YourSelf" style="resize:none;">' . $description . '</textarea>
        </div>
        ';



    echo '
    </div>
    
    <div class="col pr-0 mr-0"> 

        <!-- Second column -->

        <div class="form-group col-md-10 mx-auto pl-0">
            <input type="text" name="Lname" id="Lname" class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0" placeholder="Last Name" value="' . $Lname . '">
        </div>';
    if (isset($LnameERR)) {
        echo '
            <div id="namealert" class="alert alert-danger alert-dismissible fade show col-6 text-center mx-auto mt-0" style="left: 25%; top:38px;position: absolute;z-index: 2;height:35px;" role="alert">
                <button type="button" class="close mt-n2" data-dismiss="alert" id="closesuc" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <p class="mt-n2">
                    invalide Last Name !
                </p>
            </div>';
    }


    echo '
        <div class="form-group col-md-10 mx-auto pl-0 mt-5">
            <input type="number" name="age" id="age" class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0" placeholder="Age" value="' . $age . '">
        </div>';
    if (isset($ageERR)) {
        echo '
            <div id="namealert" class="alert alert-danger alert-dismissible fade show col-6 text-center mx-auto mt-0" style="left: 25%; top:120px;position: absolute;z-index: 2;height:35px;" role="alert">
                <button type="button" class="close mt-n2" data-dismiss="alert" id="closesuc" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <p class="mt-n2">
                    invalide Age Value!
                </p>
            </div>';
    }

    echo '
        <div class="form-group col-md-10 mx-auto pl-0 mt-5">
            <input type="password" name="newpassword" id="pwd2" class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0" placeholder="New Password" >
        </div>';
    if (isset($NewPwdERR)) {
        echo '
            <div id="namealert" class="alert alert-danger alert-dismissible fade show col-6 text-center mx-auto mt-0" style="left: 25%; top:210px;position: absolute;z-index: 2;height:35px;" role="alert">
                <button type="button" class="close mt-n2" data-dismiss="alert" id="closesuc" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <p class="mt-n2">';
        if ($NewPwdERR == 1) echo '8 caracteres at least please!';
        else echo 'old password is required !';
        echo '
                </p>
            </div>';
    }


    echo '
        <div class="form-group col-md-10 mx-auto pl-0 mt-5">
                      <select class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0" name="country" id="country">
                        <option value="" disabled> Select Your Country</option>';

    $result = mysqli_query($mysqli, "SELECT country_code,country_name from `apps_countries` ");
    while ($row = $result->fetch_assoc()) {
        if ($row["country_code"] == $Country)
            echo "<option value='" . $row["country_code"] . "' selected>" . $row["country_name"] . "</option> ";
        echo "<option value='" . $row["country_code"] . "'>" . $row["country_name"] . "</option> ";
    }

    echo '
                      </select>
        </div>';

    if (isset($CountERR)) {
        echo '
            <div id="namealert" class="alert alert-danger alert-dismissible fade show col-6 text-center mx-auto mt-0" style="left: 25%; top:296px;position: absolute;z-index: 2;height:35px;" role="alert">
                <button type="button" class="close mt-n2" data-dismiss="alert" id="closesuc" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <p class="mt-n2">
                    invalide Country name!
                </p>
            </div>';
    }

    echo '
        <div class="form-group col-md-10 mx-auto pl-0 mt-3">
          <label for="AVA" class="letter text-light">Change Avatar : </label>
            <input name="AVA" type="file" accept=".gif,.png,.jpg,.bmp,.jpeg" id="AVA" class="form-control-file form_effect bg-dark text-center text-white border border-light rounded border-top-0 border-left-0 border-right-0 py-3" aria-describedby="fileHelpId">
          <small id="fileHelpId" class="form-text  text-light">*png,jpg,bmp,jpeg&GIF 500kb 512 x 512 pixels</small>
        </div>
        ';
    if (isset($uploadOk) &&  $uploadOk != 1) {
        echo '
            <div id="namealert" class="alert alert-danger alert-dismissible fade show col-6 text-center mx-auto mt-0" style="left: 25%; top:395px;position: absolute;z-index: 2;height:35px;" role="alert">
                <button type="button" class="close mt-n2" data-dismiss="alert" id="closesuc" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <p class="mt-n2">';
        switch ($uploadOk) {
            case 2:
                echo 'Invalide File Format !';
                break;
            case 3:
                echo 'Max size 500KB!';
                break;
            case 4:
                echo 'invalid Image Formate !';
                break;
            case 5:
                echo 'Image Dimensions 512x512 px';
                break;
        }
        echo '
                </p>
            </div>
        ';
    }

    echo '
    </div>

</div>

<div class="row mt-3 pr-0">
    <div class="col mx-auto ">
        <hr class="mx-auto col-5 bg-light mb-1 d-block text-center"> 
        <button type="submit" name="Changeinfos" id="submit" class="btn btn-dark btn-outline-light col-5 mt-3" style="left:30%;" > Save </button>
    </div>
    <br>
</div>
<p class="d-block text-center text-light">Old Password Is Required for any changes!</p>

</form>

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
    <li>
        <a href="../Playground">
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
    <li class="active">
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
<nav class="navbar navbar-expand-sm navbar-dark text-light fixed-bottom" style="z-index:0; background: #212121;">
        <ul class="navbar-nav mx-auto mb-n4">
        <p> <a href="https://www.fb.com/SparoXUB" target="_blank" class="text-danger nav-link d-inline"> <span style="font-size:18px;font-family:Awsome;" ><span class="letter" style="font-size: 18px;">Code</span>Network</span></a><span class="nav-link d-inline">©2019 All Rights Reserved</span> </p>
        </ul>
    </nav>
</body>
</html>
';




    $mysqli->close();
} else {
    header('location:./');
}
