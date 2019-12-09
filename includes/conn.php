<?php
ob_start();
session_start();

$timezone = date_default_timezone_set("	America/Vancouver");

if($_SERVER["SERVER_NAME"] == "dev.whelandesigns.com") {
    //Production -  Connects to PLESK databse **
    $conn = mysqli_connect ("localhost", "soundwave_db", "*q6d7eB4", "soundwave");
} else {
    //Development/LOCAL - Connects to MAMP database **
    $conn = mysqli_connect ("localhost", "root", "root", "soundwave");
}

if(mysqli_connect_errno( $conn)){
    echo "failed to connect to MySQL: " . mysqli_connect_error();
}
?>