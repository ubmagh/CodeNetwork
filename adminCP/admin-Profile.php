<?php
session_start();
include "./includes/config.php";

if (isset($_SESSION['id'])) {

    echo '<!DOCTYPE html>
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
            <title>-Admin Profile-</title>
        </head><body>';
    include "includes/nav&sidebar.php";

    echo '

            <!-- modals -->
            <div class="modal fade" id="myModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
            <!-- Modal Header -->
                    <div class="modal-header">
                    <h4 class="modal-title text-warning"> <i class="fa fa-times-circle-o text-danger fa-lg" aria-hidden="true"></i> Error !</h4>
                    <button type="button" class="close" data-dismiss="modal" id="colsetick">&times;</button>
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
        <!-- modals end -->


        <div class="container-fluid">
            <h1 class="mt-4 col-md-4 mx-auto mb-3">Account Settings</h1>
            <div class="row">
                <div class="col border border-top-0 border-bottom-0 border-left-0 px-0">
                    <h3 style="font-family:Source Sans Pro;">Change Password :</h3>
                    <div class="mt-4">
                        <form method="POST" action="">
                            <div class="form-group mx-auto col-8" >
                                <input type="password"
                                    class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0 "
                                    name="pwd1" id="pwd1" aria-describedby="helpId" placeholder="Enter new Password" >
                            </div>
                            <div class="form-group mx-auto col-8 " >
                                <input type="password"
                                    class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0 "
                                id="pwd2" aria-describedby="helpId" placeholder="Re-Enter new Password" >
                            </div>
                            <div class="form-group mx-auto col-8 mt-4 " id="pispis">
                                <button id="Cpwd" type="submit" name="pwdChange" value="yupe" class="btn form_effect btn-dark col-12 border-0"><span class="shadow"> 
                                <i class="fa fa-arrow-circle-right ml-n1 mr-1" aria-hidden="true"></i>Change </span></button>
                            </div>
                        </form>
                        ';

    if (!empty($_POST['pwdChange'])) {
        $password = $_POST['pwd1'];
        $password = crypt($password, "SCoMae =!");
        $CPquery = mysqli_query($mysqli, "UPDATE admin SET password='$password' WHERE id=10 ");

        if ($CPquery) {
            echo '
                                <div id="namealert" class="alert alert-success alert-dismissible fade show col-6 text-center mx-auto mt-n3" style="left: 25%; top:250px;position: absolute;z-index: 2;" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <p>
                                        Password Updated Successfuly !
                                    </p>
                                </div>
                                ';
        } else {
            echo '
                                <div id="namealert" class="alert alert-danger alert-dismissible fade show col-6 text-center mx-auto mt-n3" style="left: 25%; top:250px;position: absolute;z-index: 2;" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <p>
                                        Password Updating failed! 
                                    </p>
                                </div>
                                ';
        }
    }

    echo '
                    </div>
                </div>
                <div class="col pr-5 pl-3">
                    <h3 style="font-family:Source Sans Pro;">Change Avatar :</h3>
                    <form action="upload.php" method="post" enctype="multipart/form-data">
                        <div class="form-group mx-auto col-11 " >
                        <input type="file" accept=".png"
                            class="form-control form_effect bg-dark text-center text-white border-top-0 border-left-0 border-right-0 py-4 h-25 mt-4"
                            name="fileToUpload" aria-describedby="helpId" >
                        </div>
                        <p class="mx-auto col-md-8 mt-n3">.png avatar 128x128 px and less than 500kb.</p>
                        <div class="form-group mx-auto col-8 mt-3" id="pispis">
                                <button type="submit" name="avaChange" value="avatar upload" class="btn form_effect btn-dark col-12 border-0" id="Cava"><span class="shadow"> 
                                <i class="fa fa-arrow-circle-up ml-n1 mr-1" aria-hidden="true"></i> upload </span></button>
                            </div>
                    </form>
                    <br/>
                    <div class="mb-5 mt-n3">
                    <h3 style="font-family:Source Sans Pro;">Select Avatar :</h3>
                    <form action="" method="post">
                    ';

    $images_array = glob("uploads/*.png");
    foreach ($images_array as $image) {
        echo '<button type="submit" name="avatar" class="p-0 m-0" value="' . $image . '"><img src="' . $image . '"alt="" class="" width="100px"></button>';
    }
    echo '
                    </div>';
    if (isset($_POST['avatar'])) {
        $sel = $_POST['avatar'];
        $ChAvaque = mysqli_query($mysqli, "UPDATE admin SET Avatar='$sel' WHERE id=10;");
        if ($ChAvaque) {
            echo '<div id="namealert" class="alert alert-success alert-dismissible fade show col-6 text-center mx-auto mt-n3" style="left: 25%; top:250px;position: absolute;z-index: 2;" role="alert">
                            <button type="button" class="close" data-dismiss="alert" id="closesuc" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <p>
                                Avatar changed !
                            </p>
                        </div>
                        <script>
                       setTimeout(function(){window.location.replace("http://' . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'] . '");},3000);
                        </script>
                        ';
        } else {
            echo '<div id="namealert" class="alert alert-danger alert-dismissible fade show col-6 text-center mx-auto mt-n3" style="left: 25%; top:250px;position: absolute;z-index: 2;" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <p>
                                failed to change avatar !  
                            </p>
                        </div>';
        }
    }
    echo '
                </div>
            </div>
          </div>
    </div>
<!-- /#page-content-wrapper -->


<script>
$("#Cpwd").click( function (event) {
    $va1= $("#pwd1").val();
    $va2= $("#pwd2").val();
    if( $va1 != $va2 ){
            $("#modal-body").append("two passwords are not equal !");
            event.preventDefault();
            $(' . "'#myModal').modal('show'" . ');
        }
    if( ($va1 == $va2) && $va1.length<8){
        $("#modal-body").append("too short password, use 8 car min.");
        event.preventDefault();
        $(' . "'#myModal').modal('show'" . ');
    }
});

$("#closebtn").click( function(){
    $("#modal-body").empty();
})
$("#colsetick").click( function(){
    $("#modal-body").empty();
})

<!-- Menu Toggle Script -->
$("#menu-toggle").click(function(e) {
  e.preventDefault();
  $("#wrapper").toggleClass("toggled");
});
 
</script>
</div>
    ';


    include "includes/footer.php";
} else {
    header("location:../");
}
