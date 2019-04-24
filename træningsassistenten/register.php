<?php
// Inkluder config
require_once "config.php";
 
// Definer variabler og start med tomme værdier
$mail = $kode = $tjek_kode = "";
$mail_err = $kode_err = $tjek_kode_err = "";
 
// Behandling af formulardata, når formularen indsendes
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Valider brugernavn
    if(empty(trim($_POST["mail"]))){
        $mail_err = "Indtast email.";
    } else{
        // forbered en "SELECT" erklæring
        $sql = "SELECT id FROM bruger WHERE mail = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variabler til den forberedte sætning som parametre
            $stmt->bind_param("s", $param_mail);
            
            // Sæt parametre
            $param_mail = trim($_POST["mail"]);
            
            // Forsøg på at gennemføre den udarbejdede erklæring
            if($stmt->execute()){
                // gem resultat
                $stmt->store_result();
                
                if($stmt->num_rows == 1){
                    $mail_err = "Denne mail er allerede i brug.";
                } else{
                    $mail = trim($_POST["mail"]);
                }
            } else{
                echo "Oops, noget gik galt - prøv igen senere.";
            }
        }
         
        // luk sætning
        $stmt->close();
    }
 
    // Valider kodeord
    if(empty(trim($_POST["kode"]))){
        $kode_err = "Indtast kodeord.";     
    } elseif(strlen(trim($_POST["kode"])) < 6){
        $kode_err = "Kodeordet skal være på mindst 6 tegn.";
    } else{
        $kode = trim($_POST["kode"]);
    }
    
    // Valider bekæft kodeord
    if(empty(trim($_POST["tjek_kode"]))){
        $tjek_kode_err = "Venligst bekræft koden.";     
    } else{
        $tjek_kode = trim($_POST["tjek_kode"]);
        if(empty($kode_err ) && ($kode != $tjek_kode)){
            $tjek_kode_err = "Koden stemmer ikke overens.";
        }
    }
    
    // Kontroller indgangsfejl, inden du indsætter i databasen
    if(empty($mail_err) && empty($kode_err) && empty($tjek_kode_err)){
        
        // Forbered en "INSERT" erklæring
        $sql = "INSERT INTO bruger (mail, kode) VALUES (?, ?)";
         
        if($stmt = $mysqli->prepare($sql)){
            // Bind variabler til den forberedte sætning som parametre
            $stmt->bind_param("ss", $param_mail, $param_kode);
            
            // Sæt parametre
            $param_mail = $mail;
            $param_kode = password_hash($kode, PASSWORD_DEFAULT); // Skaber password hash
            
            // Forsøg på at gennemføre den udarbejdede erklæring
            if($stmt->execute()){
                // Videresend til login side
                header("location: login.php");
            } else{
                echo "Noget gik galt. Prøv igen senere";
            }
        }
         
        // luk sætning
        $stmt->close();
    }
    
    // Sluk forbindelsen
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

  <!-- siden -->
<div class="container">
<div class="card bg-secondary" style="width:400px">
      <div class="card-body text-center">
    <div class="wrapper">
        <h2>Registrer</h2>
        <p>Udfyld for at oprette en konto.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($mail_err)) ? 'has-error' : ''; ?>">
                <h4>Mail</h4>
                <input type="email" name="mail" class="form-control" value="<?php echo $mail; ?>">
                <span class="help-block"><?php echo $mail_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($kode_err)) ? 'has-error' : ''; ?>">
                <h4>Kode</h4>
                <input type="password" name="kode" class="form-control" value="<?php echo $kode; ?>">
                <span class="help-block"><?php echo $kode_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($tjek_kode_err)) ? 'has-error' : ''; ?>">
                <h4>Bekræft kode</h4>
                <input type="password" name="tjek_kode" class="form-control" value="<?php echo $tjek_kode; ?>">
                <span class="help-block"><?php echo $tjek_kode_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Registrer">
                <input type="reset" class="btn btn-primary" value="Reset">
            </div>
            <p>Har du allerede en bruger? <a href="login.php">Login her</a>.</p>
        </form>
    </div>    
</body>
</html>