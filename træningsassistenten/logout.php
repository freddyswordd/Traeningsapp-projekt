<?php
// Initialiser sessionen
session_start();
 
// Slet alle session variablerne
$_SESSION = array();
 
// Ødelæg sessionen.
session_destroy();
 
// Omdirigere til login side
header("location: login.php");
exit;
?>