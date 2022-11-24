<?php
    /* 
        purpose: main page after login if user is staff
    */
session_start();

if (isset($_SESSION['username'])){
    echo "<h1> Welcome ".$_SESSION['username']."</h1>";
    
} else{
    echo "<p> nothing here</p>";
}



?>