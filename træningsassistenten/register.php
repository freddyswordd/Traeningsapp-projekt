<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$mail = $kode = $tjek_kode = "";
$mail_err = $kode_err = $tjek_kode_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["mail"]))){
        $mail_err = "Indtast email.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM bruger WHERE mail = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_mail);
            
            // Set parameters
            $param_mail = trim($_POST["mail"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
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
         
        // Close statement
        $stmt->close();
    }
 
    // Validate password
    if(empty(trim($_POST["kode"]))){
        $kode_err = "Indtast kodeord.";     
    } elseif(strlen(trim($_POST["kode"])) < 6){
        $kode_err = "Kodeordet skal være på mindst 6 tegn.";
    } else{
        $kode = trim($_POST["kode"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["tjek_kode"]))){
        $tjek_kode_err = "Venligst bekræft koden.";     
    } else{
        $tjek_kode = trim($_POST["tjek_kode"]);
        if(empty($kode_err ) && ($kode != $tjek_kode)){
            $tjek_kode_err = "Koden stemmer ikke overens.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($mail_err) && empty($kode_err) && empty($tjek_kode_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO bruger (mail, kode) VALUES (?, ?)";
         
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ss", $param_mail, $param_kode);
            
            // Set parameters
            $param_mail = $mail;
            $param_kode = password_hash($kode, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Noget gik galt. Prøv igen senere";
            }
        }
         
        // Close statement
        $stmt->close();
    }
    
    // Close connection
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
  /* The image used */
  background-image: url("https://hips.hearstapps.com/hmg-prod.s3.amazonaws.com/images/gettyimages-601821927-1519164092.jpg");

  /* Full height */
  height: 100%;

  /* Center and scale the image nicely */
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}

.card {
        margin: 0 auto; /* Added */
        float: none; /* Added */
        margin-bottom: 10px; /* Added */
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

<!-- image -->

<div class="bg" style="background-image: url('https://hips.hearstapps.com/hmg-prod.s3.amazonaws.com/images/gettyimages-601821927-1519164092.jpg'); background-repeat: no-repeat; background-size: cover; background-position: center center;">

  <!-- Page Content -->
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