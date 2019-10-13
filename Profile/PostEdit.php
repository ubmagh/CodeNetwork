<?php
if(!isset($_GET['post'])){
    header("location:./");
}
session_start();
include "../includes/config.php";

$pid=$_GET['post'];
$username=$_SESSION['username'];


//check post owner <!!

$GetPostInfos=$mysqli->query("SELECT * FROM posts WHERE id='$pid';");
$GetPostInfos=$GetPostInfos->fetch_assoc();

if( $GetPostInfos['username'] != $username ){
    header("location:./");
}

$Userid=$_SESSION['id'];

$getUserInfo=$mysqli->query("SELECT * FROM users where id='$Userid' ;");
$getUserInfo=$getUserInfo->fetch_assoc();

$Lname=$getUserInfo['Lname'];
$Fname=$getUserInfo['Fname'];




if(isset($_POST['submit'])){

    //The same as Creating new post in index page !

    $post=$_POST['post'];
    if(!empty($post)){
        $post=strip_tags($post);
        $post=htmlspecialchars($post);
    }else{$post="";}

    if( !empty($_POST['CodeID'])){
        $codeID=$_POST['CodeID'];
        $GetcodeOwn=$mysqli->query("SELECT username FROM codes where id='$codeID';");
        $GetcodeOwn=$GetcodeOwn->fetch_assoc();
        $GetcodeOwn=$GetcodeOwn['username'];
        if($username != $GetcodeOwn){
            $eRROr="Invalide Included Code !";
        }
        }else{$codeID='';}

    // just for re-using the same code vaiables from index page
    $Custom_Name=$pid;


    if(empty($eRROr) )
    if(  ( ($_FILES['postImg']['name']) != "") ){  

        
    
        $target_dir = "../sharedPics/";
        $target_file =$target_dir. $Custom_Name .'.'. pathinfo($_FILES['postImg']['name'],PATHINFO_EXTENSION);
        $imageFileType = strtolower(pathinfo($_FILES['postImg']['name'],PATHINFO_EXTENSION));
    
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["postImg"]["tmp_name"]);
        if($check == false) {
            $eRROr = "Invalide Image Formate !";
        }else{
                //check image dimensions
                // Get Image Dimension
                $width = $check[0];
                $height = $check[1];
                if($width>1920 || $height >1080){
                    $eRROr = "Image dimensions at most 1920x1080px ";
                }
        }
        
        // Check file size 2mb
        if ( (! isset($eRROr)) && ($_FILES["postImg"]["size"] > 2000000) ) {
            $eRROr = " Large image 2mb at most !";
        }
    
         // Allow certain file formats
         if (! isset($eRROr))
         if( ($imageFileType !="jpg") && ($imageFileType !="png") && ($imageFileType !="jpeg") && ($imageFileType !="bmp") && ($imageFileType !="gif") ) {
            $eRROr = " Invalide Image Type ! ".$imageFileType;
        }
    
        if(!isset($eRROr)){
            $imageName=$Custom_Name.'.'.$imageFileType;
            $mysqli->query("UPDATE posts SET img='$imageName', codeID='$codeID',Post='$post' WHERE id='$Custom_Name' ;");
            move_uploaded_file($_FILES["postImg"]["tmp_name"],$target_file);
         }
    //finished with posing image case now if there is no image in the post
    }elseif(( empty($eRROr) ) && ( empty($_FILES['postImg']['name'])  ) ){
        
        if( empty($post) && empty($_FILES['postImg']['name']) && empty($codeID) )
        $eRROr="You Just tried to Post Nothing ! :/ ";
        else{
        $mysqli->query("UPDATE posts SET codeID='$codeID', Post='$post' WHERE id='$Custom_Name';");
    }
    }

    if(empty($eRROr))
    header("location:./");
}

?>








<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Post</title>
    
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/solid.min.css">
    <link rel="stylesheet" href="../css/regular.min.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
<link rel="stylesheet" href="./includes/css/profile.css">
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.js"></script>
</head>
<body>
    <div class="container mt-5">

    <div class="tweetEntry-tweetHolder bg-light text-dark border border-secondary mb-2" id="p<?php echo $GetPostInfos['id']; ?>" >
            <div class="tweetEntry ">
  
                <div class="tweetEntry-content">
    
                  <a class="tweetEntry-account-group" href="./">
                      <img class="tweetEntry-avatar" src="./Avatars/<?php echo $username.'.'.$getUserInfo['avatarEXT'] ?> ">
                      
                      <strong class="tweetEntry-fullname">
                      <?php echo $Fname.' '.$Lname; ?>
                      
                      </strong>
                      
                      <span class="tweetEntry-username">
                        @<b><?php echo $username; ?></b>
                      </span>
                        <span class="tweetEntry-timestamp ml-1"> <?php echo $GetPostInfos['postingDate'] ?> </span>
                  </a>



                <form action="" method="post" enctype="multipart/form-data">

                  <div class="tweetEntry-text-container mt-3">
                        <div class="form-group mb-1">
                        <textarea class="form-control btn-outline-secondary text-dark bg-light px-4 py-3" name="post" id="post" rows="5" style="resize:none;" placeholder="What do you think?"> <?php echo $GetPostInfos['Post']; ?>  </textarea>
                        </div>
                  </div>
                
                        <div class="row mt-3 py-0">
                            <div class="input-group col-6 ">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-image"></i></span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" accept=".png,.gif,.jpeg,.jpg,.bmp" class="custom-file-input" id="customFile" name="postImg">
                                    <label class="custom-file-label" for="customFile">Change/add Picture</label>
                                </div>
                            </div>

                            <div class="input-group col-5 ">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-code py-0"></i></span>
                                </div>
                                <select name="CodeID" class="form-control custom-select text-center"><!--user can include his saved code in a post-->
                                    
                                    <?php //if code not included 
                                    if( !empty($GetPostInfos['codeID']) )
                                        echo '<option value="">do not include any code</option>';
                                        //if no code is included into post
                                    else
                                        echo '<option selected value="">include saved code</option>';
                                    ?>
                                    
                                    <?php 
                                    ///fetch all codes
                                    $GetUserCodes=$mysqli->query("SELECT * FROM codes WHERE username='$username' order by date desc");
                                    while($row=$GetUserCodes->fetch_assoc()){
                                        switch($row['langType']){
                                        case 'cpp':
                                            if( $row['id'] == $GetPostInfos['codeID'] )
                                                echo '<option selected value="'.$row['id'].'" style="border-radius:15px;background-color:rgba(1,1,1,0.5);color:white;"><span class="badge badge-light">C++/</span> '.$row['name'].'</option>';
                                            else 
                                                echo '<option value="'.$row['id'].'" style="border-radius:15px;background-color:rgba(1,1,1,0.5);color:white;"><span class="badge badge-light">C++/</span> '.$row['name'].'</option>';                                        
                                            break;

                                        case 'c':
                                            if( $row['id'] == $GetPostInfos['codeID'] )
                                                echo '<option selected value="'.$row['id'].'"><span class="badge badge-dark">C/</span> '.$row['name'].'</option>';
                                            else
                                                echo '<option value="'.$row['id'].'"><span class="badge badge-dark">C/</span> '.$row['name'].'</option>';
                                            break;

                                        case 'java':
                                            if( $row['id'] == $GetPostInfos['codeID'] )
                                                echo '<option selected value="'.$row['id'].'" style="border-radius:15px;background-color:rgba(153,51,51,0.5);"><span class="badge badge-danger">Java/</span> '.$row['name'].'</option>';
                                            else
                                                echo '<option value="'.$row['id'].'" style="border-radius:15px;background-color:rgba(153,51,51,0.5);"><span class="badge badge-danger">Java/</span> '.$row['name'].'</option>';                                        
                                            break;

                                        case 'html':    
                                            if( $row['id'] == $GetPostInfos['codeID'] )
                                                echo '<option selected value="'.$row['id'].'" style="border-radius:15px;background-color:rgba(255,153,51,0.5);"><span class="badge badge-warning text-warning">Web/</span> '.$row['name'].'</option>';
                                            else
                                                echo '<option value="'.$row['id'].'" style="border-radius:15px;background-color:rgba(255,153,51,0.5);"><span class="badge badge-warning text-warning">Web/</span> '.$row['name'].'</option>';                                        
                                            break;
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-3 py-0 mb-3">
                            <div class=" col ">
                                <button id="GOPOST" type="submit" name="submit" value="submit" class="btn btn-light btn-block text-dark btn-outline-white border-secondary"> <i class="fas fa-wrench mr-1 ml-0"></i> Modify</button>
                            </div>
                            <div class=" col "> 
                                <a class="btn btn-danger btn-block" href="./"><i class="fas fa-times mr-2 ml-0"></i>Cancel</a>
                            </div>                
                        </div>
                    </form>
                    
                      <?php
                            
                                //post errors   Modal: 
                        echo'
                        <div class="modal fade" id="ErrorModal">
                <div class="modal-dialog">
                <div class="modal-content">
                
                    <!-- Modal Header -->
                    <div class="modal-header">
                    <h4 class="modal-title">Invalid Post</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body" id="eRRor">
                    </div>
                    
                    <!-- Modal footer -->
                    <div class="modal-footer">
                    <button type="button" id="CloseErr" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                    
                </div>
                </div>
            </div>
            ';
            if(isset($eRROr)) {echo "
                <script>
                $('#eRRor').append('".$eRROr."');
            $('#ErrorModal').modal('show');
            $('#CloseErr').click(
                function(){
                    $('#eRRor').empty();
                    });
            </script>";
                    }

                        //end post errors modal
                        ?>

                    </div>

                </div>
            </div>



    </div>
</body>
</html>

