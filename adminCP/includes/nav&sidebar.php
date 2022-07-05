<div class="d-flex" id="wrapper">
  <?php
 $avatarQUERY=mysqli_query($mysqli,"SELECT Avatar FROM admin WHERE id=10;");
 $avatar=$avatarQUERY->fetch_assoc();
 $avatar=$avatar['Avatar'];
 ?>
     <!-- Sidebar -->
    <div class="bg-dark border-right" id="sidebar-wrapper">
      <div class="sidebar-heading text-light"> Admin Control-Panel </div>
      <div class="list-group list-group-flush ">
        <a href="./index.php" class="list-group-item list-group-item-action bg-dark text-light">Dashboard</a>
        <a href="./Accounts.php" class="list-group-item list-group-item-action bg-dark text-light">Manage Accounts</a>
        <a href="./Messages.php" class="list-group-item list-group-item-action bg-dark text-light">Messages</a>
        <a href="./Reports.php" class="list-group-item list-group-item-action bg-dark text-light">Repports</a>
        <a href="./UsersLOg.php" class="list-group-item list-group-item-action bg-dark text-light">Users Log</a>
      </div>
    </div>
    <div id="page-content-wrapper">

      <nav class="navbar navbar-expand-lg navbar-light bg-dark border-bottom">
        <button class="btn btn-dark btn-outline-light" id="menu-toggle">Toggle Menu</button>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <div class="col-1 ml-n3 text-center">
        <button class=" btn btn-dark btn-outline-light " id="reloaD"><i class="fas fa-sync"></i></button>
        <script>
        $("#reloaD").click(function(){location.reload();});
        </script>
        </div>
          <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php 
              echo'<img src="'.$avatar.'" class="ts-avatar hidden-side" alt="">';
              ?>
                Admin
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="/adminCP/admin-Profile.php">Account Settings</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="/adminCP/logout.php">log-out</a>
              </div>
            </li>
          </ul>
        </div>
      </nav>

     