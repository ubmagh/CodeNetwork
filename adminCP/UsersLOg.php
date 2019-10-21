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
            <link rel="stylesheet" href="../css/bootstrap.min.css">
            <link rel="stylesheet" href="../css/all.min.css">
            <link rel="stylesheet" href="../css/solid.min.css">
            <link rel="stylesheet" href="../css/fontawesome.min.css">
            <link rel="stylesheet" href="../css/regular.min.css">
            <link rel="stylesheet" href="../css/simple-sidebar.css">
            <script src="../js/jquery.js"></script>
            <script src="../js/bootstrap.js"></script>

            <title>-Users Log-</title>
        </head><body>';
        include "includes/nav&sidebar.php";
        echo'
        <div class="container-fluid">
        <h1 class="mt-4 text-center"> Users Log :</h1>
<div class="mt-4 mb-2">
<form> 
        <table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Full Name</th>
      <th scope="col">Email</th>
      <th scope="col">Log time</th>
      <th scope="col">Log IP address</th>
      <th scope="col">
          <a href="./UsersLOg.php?Zfux=all">
             <i class="fas fa-trash-alt text-danger"></i>
          </a> 
      </th>
    </tr>
  </thead>
  <tbody>
    ';
    
    // delete
    if(isset($_GET['Zfux'])){
        $Cid=$_GET['Zfux'];
        if($Cid=="all")
          $mysqli->query("DELETE FROM `userlog`");
        $mysqli->query("DELETE FROM `userlog` WHERE `userlog`.`id` ='$Cid';");
        echo'<script>window.location.replace("http://'.$_SERVER['SERVER_NAME'].'/CodeNet/admincp/UsersLOg.php");</script>';
        unset($Cid);
     }

    $logs=mysqli_query($mysqli,"SELECT * FROM userlog ORDER BY date;");
    $num=1;
    while($row=$logs->fetch_assoc()){
    $uid=$row['guestName'];
    $getname=$mysqli->query("SELECT Fname,Lname From users WHERE id='$uid';");
    $getname=$getname->fetch_assoc();
    $Fullname=$getname['Lname']." ".$getname['Fname'];
    unset($getname);
    echo'
        <tr> 
         <th scope="row">'.$num.'</th>
         <td>'.$Fullname.'</td>
         <td class="text-info">'.$row['userEmail'].'</td>
         <td class="text-warning">'.$row['date'].'</td>
         <td>'.$row['userIp'].'</td>
         <td>
            <a href="./UsersLOg.php?Zfux='.$row['id'].'">
                <i class="fas fa-trash-alt text-danger"></i>
            </a>
         </td>
         ';
        $num++;
    }


    echo '
    </tbody>
</table>    
</form> 
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


$mysqli->close();
}
else{
header("location:.");
}
include "includes/footer.php";
