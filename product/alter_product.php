<?php
    /*
        purpose: backend process to delete the edited product data into database
    */
    require_once "../database/connect_db.php";

    if ($_SERVER['REQUEST_METHOD'] === "POST"){
        if(isset($_POST['deleteproduct'])){
            $id = $_POST['delete_id'];
            $delete_sql = "DELETE FROM product WHERE productID = ".$id;
            if (mysqli_query($conn,$delete_sql)){
                // session cannot work
                $_SESSION['message'] = "Product is deleted";
                header("location:../staff/index.php");
            } else{
                echo "<script> alert('Error occur'); </script>";
            }
        }
    }
?>