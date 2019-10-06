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

            <title>-Users Reports-</title>
        </head><body>';
        include "includes/nav&sidebar.php";

        echo'
        <div class="container-fluid">
        <h1 class="mt-4 text-center"> Repports :</h1>
<div class="mt-4 mb-2">
<form> 
        <table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col" class="px-0 text-center">#</th>
      <th scope="col" class=" col-md-2 text-center ">username</th>
      <th scope="col" class="text-center col-md-2">Date</th>
      <th scope="col" class="text-center col-md-3">Email</th>
      <th scope="col" class="text-center">Report</th>
      <th scope="col" class="text-center col-md-1"></th>
    </tr>
  </thead>
  <tbody>
    ';

    if(isset($_GET['XuytA'])){
        $Cid=$_GET['XuytA'];
        $mysqli->query("DELETE FROM `reports` WHERE `reports`.`id` ='$Cid';");
        echo'<script>window.location.replace("http://'.$_SERVER['SERVER_NAME'].'/CodeNet/admincp/Reports.php");</script>';
        unset($Cid);
     }

    $report=mysqli_query($mysqli,"SELECT * FROM reports ORDER BY date;");
    $num=1;
    while($row=$report->fetch_assoc()){
    echo'
        <tr> 
         <th scope="row" class="text-center">'.$num.'</th>
         <td class="text-center">'.$row['username'].'</td>
         <td class="text-info text-center">'.$row['date'].'</td>
         <td class="text-warning text-center">'.$row['email'].'</td>
         <td class="text-center">'.$row['report'].'</td>
         <td class="text-right">
            <a href="./Reports.php?XuytA='.$row['id'].'">
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
?>