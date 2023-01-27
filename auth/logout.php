<?php
    /*
        purpose: for user (STAFF / CUSTOMER) to logout
    */
session_start();
if (isset($_SESSION['username'])){
    session_destroy();
    echo "<script>location.href='../login.php'</script>";
} else{
    echo "<script>location.href='../login.php'</script>";
}
?>