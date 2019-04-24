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
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ændre kodeord!</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.4/css/bulma.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
</head>
<body>
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