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

            <title>-Manage Accounts-</title>
        </head><body>';
        include "includes/nav&sidebar.php";
        echo'
        <div class="container-fluid">
        <h1 class="mt-4 text-center">Accounts Management : </h1>
<div class="mt-4 mb-2">
<form> 
        <table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col-1">#</th>
      <th scope="col">First Name</th>
      <th scope="col">Last Name</th>
      <th scope="col">Email</th>
      <th scope="col-1">Age</th>
      <th scope="col">City - Country</th>
      <th scope="col-1">Activate</th>
    </tr>
  </thead>
  <tbody>
    ';
    if(isset($_GET['QCtu'])){
        $Cid=$_GET['QCtu'];
        $acchange = $mysqli->query("SELECT Activated FROM users WhERE id='$Cid';");
        $acchange = $acchange->fetch_assoc();
        $acchange= $acchange['Activated'];
        if($acchange=='1')
            {$newStat="0";}
        else 
            {$newStat="1";}
        $mysqli->query("UPDATE users SET Activated= '".$newStat."' WHERE id='$Cid';");
        echo'<script>window.location.replace("http://'.$_SERVER['SERVER_NAME'].'/admincp/Accounts.php");</script>';
        unset($Cid,$acchang,$newStat);
     }

    $users=mysqli_query($mysqli,"SELECT * FROM users ORDER BY Fname;");
    $num=1;
    while($row=$users->fetch_assoc()){
    $country=$row['Country'];
    $userContry=mysqli_query($mysqli,"SELECT country_name FROM apps_countries WHERE country_code='$country';");
    $country=$userContry->fetch_assoc();
    $country=$country['country_name']; 
    echo'
        <tr> 
         <th scope="row">'.$num.'</th>
         <td>'.$row['Fname'].'</td>
         <td>'.$row['Lname'].'</td>
         <td>'.$row['Email'].'</td>
         <td>'.$row['age'].'</td>
         <td>'.$row['City'].' - '.$country.'</td>';


         if($row['Activated']==1){
                            echo'
                            <td>
                               <a href="./Accounts.php?QCtu='.$row['id'].'" >
                               <i class="fas fa-toggle-on text-success"></i>
                               <span class="text-success"> Activated</span>
                               </a>
                            </td>';
                                   }
        else{
            echo'
            <td>
                <a href="./Accounts.php?QCtu='.$row['id'].'" >
                <i class="fas fa-toggle-off text-warning"></i>
                    <span class="text-warning">Desactivated</span>
                </a>
            </td>';
        }
         echo'
       </tr>
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
header("location:./index.php");
}
include "includes/footer.php";
?>