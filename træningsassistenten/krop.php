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
        body{ font: 14px sans-serif;
            background-color: rgb(105,105,105);
}
        .wrapper{ width: 350px; padding: 20px; }

        body, html {
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
<div class="row">
<div class="col">
<div class="container">
    <div class="card bg-secondary" style="width:center">
          <div class="card-body text-center">
                <h1 class="card-text">Fuld krop workout</h1>       
      <p class="card-text">
        <h1> Lav volumen </h1>
        <br>
        <h3> Barbell squat </h3>
        <img src="https://www.bodybuilding.com/exercises/exerciseImages/sequences/3861/Male/l/3861_1.jpg" alt="squat1" width="300" height="300">
        <img src="https://www.bodybuilding.com/exercises/exerciseImages/sequences/3861/Male/l/3861_2.jpg" alt="squat2" width="300" height="300">
        <br>
        <h6>3 sæts, 5-6 reps</h6>
        <br><br>
        <h3> Barbell Bench Press </h3>
        <img src="https://www.bodybuilding.com/exercises/exerciseImages/sequences/360/Male/l/360_1.jpg" alt="bænk1" width="300" height="300">
        <img src="https://www.bodybuilding.com/exercises/exerciseImages/sequences/360/Male/l/360_2.jpg" alt="bænk2" width="300" height="300">
        <br>
        <h6>3 sæts, 6-8 reps</h6>
        <br><br>
        <h3> Foroverbøjet barbell row </h3>
        <img src="https://www.bodybuilding.com/exercises/exerciseImages/sequences/20/Male/l/20_1.jpg" alt="for1" width="300" height="300">
        <img src="https://www.bodybuilding.com/exercises/exerciseImages/sequences/20/Male/l/20_2.jpg" alt="for2" width="300" height="300">
        <br>
        <h6>3 sæts, 6-8 reps</h6>
        <br><br>
        <h3> Mavebøjninger </h3>
        <img src="https://www.bodybuilding.com/exercises/exerciseImages/sequences/102/Male/l/102_1.jpg" alt="mave1" width="300" height="300">
        <img src="https://www.bodybuilding.com/exercises/exerciseImages/sequences/102/Male/l/102_2.jpg" alt="mave2" width="300" height="300">
        <br>
        <h6>3 sæt, 8-10 reps</h6>
        <br><br>
      </p>


</div>
</div>
    </div>
  </div>
</div>



    
    

</body>
</html>