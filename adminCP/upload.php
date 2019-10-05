<?php

if(isset($_POST["avaChange"])) {

    include "./includes/config.php";
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
    
    // Check file size 500kb
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

    // Allow certain file formats
    if($imageFileType != "png") {
        echo "Sorry, PNG files are allowed.";
        $uploadOk = 0;
    }

    //check image dimensions
    // Get Image Dimension
    $width = $check[0];
    $height = $check[1];
    if($width>128 || $height >128){
        echo 'Too big dimensions';
        $uploadOk=0;
    }


    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file ". basename( $_FILES["fileToUpload"]["name"]). ' has been uploaded You can choose it from the last page 
                        <script>
                       setTimeout(function(){window.location.replace("http://'.$_SERVER['SERVER_NAME'].'/admincp/admin-Profile.php");},3000);
                        </script>
            ';
            $lastnumqu=mysqli_query($mysqli,"SELECT LastAvaNum FROM admin WHERE id=10;");
            $lastnumqu=$lastnumqu->fetch_assoc();
            $lastnumqu=$lastnumqu['LastAvaNum'];
            rename( "./uploads/".$_FILES["fileToUpload"]["name"],"./uploads/".$lastnumqu.".png");
            $lastnumqu++;
            $lastnumqu=mysqli_query($mysqli,"UPDATE admin SET lastAvaNum ='".$lastnumqu."' WHERE id=10; ");
        } else {
            echo 'Sorry, there was an error uploading your file.
            <script>
              setTimeout(function(){window.location.replace("http://'.$_SERVER['SERVER_NAME'].'/admincp/admin-Profile.php");},3000);
            </script>';
                } 
        }
        
}else{echo'
    <script>
   setTimeout(function(){window.location.replace("http://'.$_SERVER['SERVER_NAME'].'/admincp");},10);
      </script>';
}
?>
