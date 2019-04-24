<?php
// Initialiser sessionen
session_start();
 
// Kontroller om brugeren er logget ind, hvis ikke, så omdirigere han til login side
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
  /* Billede */
  background-image: url("https://hips.hearstapps.com/hmg-prod.s3.amazonaws.com/images/gettyimages-601821927-1519164092.jpg");

  /* Fuld højde */
  height: 100%;

  /* Center og skaler */
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;

}

.row {
  background-color: rgba(169, 169, 169, 0.4);

  /* Fuld højde */
  height: 100%;


}



    </style>
</head>
<body>
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
    <div class="container">
      <a class="navbar-brand" href="welcome.php">Trænings<br>Assistenten</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="index.html">Hjem
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="planer.php">Planer
            </a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="reset_password.php">Ændre kodeord
            </a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="logout.php">Log Ud</a>
          </li>
          
        </ul>
      </div>
    </div>
  </nav>

<!-- billede -->
<div class="bg" style="background-image: url('https://hips.hearstapps.com/hmg-prod.s3.amazonaws.com/images/gettyimages-601821927-1519164092.jpg'); background-repeat: no-repeat; background-size: cover; background-position: center center;">

<div class="row">
  <div class="col">
  <div class="container">
    <div class="card bg-secondary" style="width:center">
          <div class="card-body text-center">
                <h1 class="card-text">Planer</h1>
                    <a href="krop.php" class="btn btn-primary">Fuld krop</a>
                <br><br>
                    <a href="#" class="btn btn-danger">Arme</a>
                <br><br>
                    <a href="#" class="btn btn-danger">Ben</a>
                <br><br>
                    <a href="#" class="btn btn-danger">Mave</a>
                <br><br>
                    <a href="#" class="btn btn-danger">Ryg</a>

                    <h1 class="card-text">Mad</h1>
                    <a href="hurtig.php" class="btn btn-primary">Hurtig at lave</a>
                <br><br>
                    <a href="#" class="btn btn-danger">Mange kalorier</a>
                <br><br>
                    <a href="#" class="btn btn-danger">Få kalorier</a>
                <br><br>
                    <a href="#" class="btn btn-danger">Mange vitaminer</a>
                <br><br>
                    <a href="#" class="btn btn-danger">Glutenfri</a>
                <br><br>
                    <a href="#" class="btn btn-danger">Vegetar</a>

          </div>
    </div>
  </div>


  </div>

</div>
    
    

</body>
</html>