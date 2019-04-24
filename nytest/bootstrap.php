<?php
// Initialize the session
session_start();
 

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$mail = $kode = "";
$mail_err = $kode_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["mail"]))){
        $mail_err = "Indtast mail.";
    } else{
        $mail = trim($_POST["mail"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["kode"]))){
        $kode_err = "Indtast kode.";
    } else{
        $kode = trim($_POST["kode"]);
    }
 
   // Validate credentials
   if(empty($mail_err) && empty($kode_err)){
    // Prepare a select statement
    $sql = "SELECT id, mail, kode FROM bruger WHERE mail = ?";
        
    if($stmt = $mysqli->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("s", $param_mail);
        
        // Set parameters
        $param_mail = $mail;
        
        // Attempt to execute the prepared statement
        if($stmt->execute()){
            // Store result
            $stmt->store_result();
                            
                // Check if mail exists, if yes then verify password
                if($stmt->num_rows == 1){                    
                    // Bind result variables
                    $stmt->bind_result($id, $mail, $hashed_kode);
                    if($stmt->fetch()){
                        if(password_verify($kode, $hashed_kode)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["mail"] = $mail;                            
                            
                            // Redirect user to welcome page
                            header("location: welcome.php");
                        } else{
                            // Display an error message if password is not valid
                            $kode_err = "Koden du indtastede passer ikke til email";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $mail_err = "Ingen bruger fundet med denne mail.";
                }
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
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
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
            <a class="nav-link" href="#">Home
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Services</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Content -->
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center">
        <h1 class="mt-5">A Bootstrap 4 Starter Template</h1>
        <p class="lead">Complete with pre-defined file paths and responsive navigation!</p>
      </div>
    </div>
  </div>

  <div class="wrapper">
    <h2>Login</h2>
    <p>Venligst skriv login information.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group <?php echo (!empty($mail_err)) ? 'has-error' : ''; ?>">
            <label>Mail</label>
            <input type="text" name="mail" class="form-control" value="<?php echo $mail; ?>">
            <span class="help-block"><?php echo $mail_err; ?></span>
        </div>    
        <div class="form-group <?php echo (!empty($kode_err)) ? 'has-error' : ''; ?>">
            <label>Kode</label>
            <input type="password" name="kode" class="form-control">
            <span class="help-block"><?php echo $kode_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Login">
        </div>
        <p>Har du ikke en bruger? <a href="register.php">Registerer nu</a>.</p>
    </form>
</div>  


</body>

</html>
