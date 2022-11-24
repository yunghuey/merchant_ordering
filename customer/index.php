<?php
    /*
        purpose: this is the first main page of customer after login
    */
require_once "../database/connect_db.php";

// this is to prevent uninitialized data
session_start();
if (empty($_SESSION["username"])){
    header("location:index.php");
    exit;
}

echo "Hello ".$_SESSION["username"];

echo "<a href='../logout.php'>Logout</a>";
?>