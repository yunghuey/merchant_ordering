<?php 
    /*
        purpose: backend to delete customer record
    */
    require_once "../database/connect_db.php";

    if ($_SERVER['REQUEST_METHOD'] === "POST"){
        if(isset($_POST['deletecust'])){  
            $id = $_POST['delete_id'];
            $delete_sql = "DELETE FROM customer WHERE id = ".$id;
            if (mysqli_query($conn,$delete_sql)){
                // $_SESSION['message'] = "Customer is deleted";
                header("location:customerlist.php");
            }
        }
    }
?>