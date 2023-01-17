<?php 
    /*
        purpose: backend to delete customer record
    */
    require_once "../database/connect_db.php";

    if ($_SERVER['REQUEST_METHOD'] === "POST"){
        if(isset($_POST['deletecust'])){  
            $id = $_POST['delete_id'];
            $update_record = "UPDATE `cart` c INNER JOIN `customer` cust ON cust.id=c.customerID "
            ."SET c.customerID=NULL "
            ."WHERE c.customerID=".$id;
            mysqli_query($conn,$update_record);
            $delete_sql = "DELETE FROM customer WHERE id = ".$id;
            if (mysqli_query($conn,$delete_sql)){
                // $_SESSION['message'] = "Customer is deleted";
                header("location:customerlist.php");
            }
        }
    }
?>