<?php
    /*
        purpose: connecting to localhost database server 
    */
    $host = 'localHost';
    $user = 'root';
    $pass = '';
    $db = 'merchant_ordering';
    $conn = new mysqli($host,$user, $pass, $db) or die("Unable to connect to database.");
?>