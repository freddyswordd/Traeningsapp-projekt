<?php
// Initialiser sessionen
session_start();
 
// Kontroller om brugeren er logget ind, ellers omdirigere til login side
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
 
// indkluder config
require_once "config.php";
 
// Definer variabler og start med tomme værdier
$nyt_pass = $tjek_pass = "";
$nyt_pass_err = $tjek_pass_err = "";
 
// Behandling af formulardata, når formularen indsendes
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validér ny adgangskode
    if(empty(trim($_POST["nyt_pass"]))){
        $nyt_pass_err = "Indtast nyt kodeord.";     
    } elseif(strlen(trim($_POST["nyt_pass"])) < 6){
        $nyt_pass_err = "Kodeordet skal indholde mindst 6 tegn.";
    } else{
        $nyt_pass = trim($_POST["nyt_pass"]);
    }
    
    // Tjek bekræft adgangskode
    if(empty(trim($_POST["tjek_pass"]))){
        $tjek_pass_err = "Venligst tjek kodeord.";
    } else{
        $tjek_pass = trim($_POST["tjek_pass"]);
        if(empty($nyt_pass_err) && ($nyt_pass != $tjek_pass)){
            $tjek_pass_err = "Kodeord stemmer ikke overens.";
        }
    }
        
    // Kontrollér inputfejl, inden databasen opdateres
    if(empty($nyt_pass_err) && empty($tjek_pass_err)){
        // Forbered "UPDATE" erklæring
        $sql = "UPDATE bruger SET kode = ? WHERE id = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variabler til den forberedte sætning som parametre
            $stmt->bind_param("si", $param_kode, $param_id);
            
            // Sæt parametre
            $param_kode = password_hash($nyt_pass, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            // Forsøg på at gennemføre den udarbejdede erklæring
            if($stmt->execute()){
                // Adgangskode opdateret med succes. Ødelæg sessionen og omdirigere til login side
                session_destroy();
                header("location: login.php");
                exit();
            } else{
                echo "Oops, noget gik galt - prøv igen senere.";
            }
        }
        
        // luk erklæring
        $stmt->close();
    }
    
    // luk forbindelse
    $mysqli->close();
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
  /* billede */
  background-image: url("https://hips.hearstapps.com/hmg-prod.s3.amazonaws.com/images/gettyimages-601821927-1519164092.jpg");

  /* Fuld højde */
  height: 100%;

  /* Center og skaler */
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;

}


.card {
        margin: 0 auto; 
        float: none; 
        margin-bottom: 10px; 
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


<div class="container">
<div class="card bg-secondary" style="width:400px">
      <div class="card-body text-center">
    <div class="wrapper">
        <h2>Ændre kodeord</h2>
        <p>Fyld dette ud for at ændre dit kodeord.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <div class="form-group <?php echo (!empty($nyt_pass_err)) ? 'has-error' : ''; ?>">
                <label>Nyt kodeord</label>
                <input type="password" name="nyt_pass" class="form-control" value="<?php echo $nyt_pass; ?>">
                <span class="help-block"><?php echo $nyt_pass_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($tjek_pass_err)) ? 'has-error' : ''; ?>">
                <label>Bekræft kodeord</label>
                <input type="password" name="tjek_pass" class="form-control">
                <span class="help-block"><?php echo $tjek_pass_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-link" href="welcome.php">Cancel</a>
            </div>
        </form>
    </div>    

</body>
</html>