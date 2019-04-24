<?php
// Initialiser sæssionen 
session_start();
 

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}

// Inkluder config
require_once "config.php";

// Definer variabler og start med tomme værdier
$mail = $kode = "";
$mail_err = $kode_err = "";

// Behandling af formulardata, når formularen indsendes
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Tjek og brugernavn er tom
    if(empty(trim($_POST["mail"]))){
        $mail_err = "Indtast mail.";
    } else{
        $mail = trim($_POST["mail"]);
    }
    
    // Tjek om kode er tom
    if(empty(trim($_POST["kode"]))){
        $kode_err = "Indtast kode.";
    } else{
        $kode = trim($_POST["kode"]);
    }
 
   // Validér legitimationsoplysninger
   if(empty($mail_err) && empty($kode_err)){
    // Forbered en "SELECT" erklæring
    $sql = "SELECT id, mail, kode FROM bruger WHERE mail = ?";
        
    if($stmt = $mysqli->prepare($sql)){
        // Bind variabler til den forberedte sætning som parametre
        $stmt->bind_param("s", $param_mail);
        
        // Sæt parametre
        $param_mail = $mail;
        
        // Forsøg på at gennemføre den udarbejdede erklæring
        if($stmt->execute()){
            // Gem resultat
            $stmt->store_result();
                            
                // Kontroller, om mailen findes, hvis ja, bekræft adgangskoden
                if($stmt->num_rows == 1){                    
                    // Bind resultatvariabler
                    $stmt->bind_result($id, $mail, $hashed_kode);
                    if($stmt->fetch()){
                        if(password_verify($kode, $hashed_kode)){
                            // Adgangskoden er korrekt, starter ny session
                            session_start();
                            
                            // Gem data i session variabler
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["mail"] = $mail;                            
                            
                            // Omdiriger bruger til velkomst side
                            header("location: welcome.php");
                        } else{
                            // Vis en fejlmeddelelse, hvis adgangskoden ikke er gyldig
                            $kode_err = "Koden du indtastede passer ikke til email";
                        }
                    }
                } else{
                    // Vis en fejlmeddelelse, hvis brugernavnet ikke findes
                    $mail_err = "Ingen bruger fundet med denne mail.";
                }
            } else{
                echo "Oops, noget gik galt - prøv igen senere.";
            }
        }
        
        // Luk sætning
        $stmt->close();
    }
    
    // Sluk forbindelse
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
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

  /* Center og skalering */
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
      <a class="navbar-brand" href="index.html">Trænings<br>Assistenten</a>
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
            <a class="nav-link" href="login.php">Login
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

<!-- billede -->

<div class="bg" style="background-image: url('https://hips.hearstapps.com/hmg-prod.s3.amazonaws.com/images/gettyimages-601821927-1519164092.jpg'); background-repeat: no-repeat; background-size: cover; background-position: center center;">

  <!-- Siden -->
<div class="container">
<div class="card bg-secondary" style="width:400px">
      <div class="card-body text-center">
      <div class="wrapper">
    <h2>Login</h2>
    <p>Venligst skriv login information.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group <?php echo (!empty($mail_err)) ? 'has-error' : ''; ?>">
            <h4>Mail</h4>
            <input type="text" name="mail" class="form-control" value="<?php echo $mail; ?>">
            <span class="help-block"><?php echo $mail_err; ?></span>
        </div>    
        <div class="form-group <?php echo (!empty($kode_err)) ? 'has-error' : ''; ?>">
            <h4>Kode</h4>
            <input type="password" name="kode" class="form-control">
            <span class="help-block"><?php echo $kode_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Login">
        </div>
        <p>Har du ikke en bruger? <a href="register.php">Registerer nu</a>.</p>
    </form>
</div>  
      </div>
    </div>



</body>

</html>