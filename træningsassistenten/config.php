<?php
/* Database information. */
define('host', 'mysql88.unoeuro.com');
define('db_username', 'aarhustech_tg_2018_dk');
define('db_password', 'HTX2018TG');
define('db_name', 'aarhustech_tg_2018_dk_db_frederik_it');
 
/* Forsøg på at oprette forbindelse til MySQL database */
$mysqli = new mysqli(host, db_username, db_password, db_name);

// Tjek forbindelse
if($mysqli === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}
?>