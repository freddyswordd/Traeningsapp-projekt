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


  <div class="container">
    <div class="card bg-secondary" style="width:center">
          <div class="card-body text-center">
                <h1 class="card-text">Kylling i karry</h1>
                <img src="https://www.dk-kogebogen.dk/billeder-opskrifter/billeder/23547/4_300.jpg" alt="Card image" width="300" height="300">>
      <div class="row">
            <div class="col-sm-4">
                <h3>Ingredienser</h3>
                <ul type="square">
                        <p>500gram Kyllingefilet uden skind og ben</p>
                        <p>2 Æbler</p>
                        <p>25 gram smør</p>
                        <p>2 tsk. Karry</p>
                        <p>2 tsk. Gurkemeje, stødt</p>
                        <p>3 dl. Hønseboullion</p>
                        <p>200 gram fødeost, naturel</p>


                    </ul>



            </div>
            <div class="col-sm-8">
            <h3>Opskrift</h3>
            <a>Kyllingefilet, skæres i tern, løget pilles og og hakkes, fjern kernehuset fra æblerne, og skær også dem i tern, de kan, evt. skrælles men det er ikke nødvendigt. <br><br>

Smelt smørret. <br>
Svits kylling, æbler, løg, karry og gurkemeje ca. 5 minutter.<br><br>

Tilsæt hønsebouillon og flødeost og lad det simre til osten er kogt ud og har jævnet ca. 5 minutter.<br><br>

Spises med ris til, og evt. en klat mangochutney.</a>

            </div>
          </div> 



 </div>
    </div>
  </div>




    
    

</body>
</html>