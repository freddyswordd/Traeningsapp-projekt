<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$nyt_pass = $tjek_pass = "";
$nyt_pass_err = $tjek_pass_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate new password
    if(empty(trim($_POST["nyt_pass"]))){
        $nyt_pass_err = "Indtast nyt kodeord.";     
    } elseif(strlen(trim($_POST["nyt_pass"])) < 6){
        $nyt_pass_err = "Kodeordet skal indholde mindst 6 tegn.";
    } else{
        $nyt_pass = trim($_POST["nyt_pass"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["tjek_pass"]))){
        $tjek_pass_err = "Venligst tjek kodeord.";
    } else{
        $tjek_pass = trim($_POST["tjek_pass"]);
        if(empty($nyt_pass_err) && ($nyt_pass != $tjek_pass)){
            $tjek_pass_err = "Kodeord stemmer ikke overens.";
        }
    }
        
    // Check input errors before updating the database
    if(empty($nyt_pass_err) && empty($tjek_pass_err)){
        // Prepare an update statement
        $sql = "UPDATE bruger SET kode = ? WHERE id = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("si", $param_kode, $param_id);
            
            // Set parameters
            $param_kode = password_hash($nyt_pass, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: login.php");
                exit();
            } else{
                echo "Oops, noget gik galt - prøv igen senere.";
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


<!-- image -->

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