<?php
  session_start();
?>

<!DOCTYPE html>

<head>
  <title>Car Rental Application</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</head>

<!-- (Bootstrap, n.d) -->
<!-- https://getbootstrap.com/docs/4.0/components/navbar/ -->

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="collapse navbar-collapse" id="navbarSupportedContent">

    <a class="navbar-brand" href="index.php">Car Rentals</a>

    <ul class="navbar-nav mr-auto">
      <!-- navbar items for everyone (even logged out individuals-->
      <li <?php if(basename($_SERVER['SCRIPT_NAME'])=="index.php") { ?>  class="active"   <?php   }  ?>><a class="nav-link" href="index.php">Home</a></li>
    
      <!-- navbar items for admin -->
      <?php if(isset($_SESSION["usertype"]) && $_SESSION["usertype"] == "admin"): ?>
        <li <?php if(basename($_SERVER['SCRIPT_NAME'])=="managerentals.php") { ?>  class="active"   <?php   }  ?>><a class="nav-link" href="managerentals.php">Manage Rentals</a></li>
        <li <?php if(basename($_SERVER['SCRIPT_NAME'])=="managevehicles.php") { ?>  class="active"   <?php   }  ?>><a class="nav-link" href="managevehicles.php">Manage Vehicles</a></li>
        <li <?php if(basename($_SERVER['SCRIPT_NAME'])=="manageusers.php") { ?>  class="active"   <?php   }  ?>><a class="nav-link" href="manageusers.php">Manage Users</a></li>
        <li <?php if(basename($_SERVER['SCRIPT_NAME'])=="managebranches.php") { ?>  class="active"   <?php   }  ?>><a class="nav-link" href="managebranches.php">Manage Branches</a></li>
        <li <?php if(basename($_SERVER['SCRIPT_NAME'])=="rentalhistory.php") { ?>  class="active"   <?php   }  ?>><a class="nav-link" href="rentalhistory.php">Rental History</a></li>
        <li <?php if(basename($_SERVER['SCRIPT_NAME'])=="mybookings.php") { ?>  class="active"   <?php   }  ?>><a class="nav-link" href="mybookings.php">My Bookings</a></li>

      <!-- navbar items for user -->
      <?php elseif(isset($_SESSION["usertype"]) && $_SESSION["usertype"] == "user"): ?>
        <li <?php if(basename($_SERVER['SCRIPT_NAME'])=="mybookings.php") { ?>  class="active"   <?php   }  ?>><a class="nav-link" href="mybookings.php">My Bookings</a></li>
      <?php endif;?>

    </ul>

    <!-- log out button-->
    <ul class="nav navbar-nav navbar-right">
      <?php
        if (isset($_SESSION["userid"]))
        {
          echo '<li><a class="nav-link" href="./controllers/Users.ctrl.php?state=logout">Log Out</a></li>';
        }
        else
        {
          echo '<li><a class="nav-link" href="login.php">Log In</a></li>';
          echo '<li><a class="nav-link" href="createuser.php">Register</a></li>';
        }
      ?>
    </ul>
  </div>
</nav>
  
<br/><br/>

<div class="container p-3 my-3">