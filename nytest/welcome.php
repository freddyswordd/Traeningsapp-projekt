<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Velkommen</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }

        body, html {
  height: 100%;
}
.bg {
  /* The image used */
  background-image: url("http://www.maartenlambrechts.com/assets/journal.pbio_.1002128.g0011.png");

  /* Half height */
  height: 50%;

  /* Center and scale the image nicely */
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}


    </style>
</head>
<body>
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
    <div class="container">
      <a class="navbar-brand" href="#">Start Bootstrap</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Hjem
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">statestik</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Kost</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Log ud</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

    <div class="page-header">
        <h1>Hej, <b><?php echo htmlspecialchars($_SESSION["mail"]); ?></h1>
    </div>
    
    <div class="bg"></div>



    <p>
        <a href="reset_password.php" class="btn btn-warning">Ændre kodeord</a>
        <a href="logout.php" class="btn btn-danger">Log ud</a>
    </p>
</body>
</html>