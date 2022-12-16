<?php
    /*
        purpose: frontend php for first time login customer to register the details
    */
    require_once "../database/connect_db.php";

    $fullname = $shippingAddress = $gender = "";
    
    if ($_SERVER['REQUEST_METHOD'] === "POST"){        
        if (isset($_POST['custRegister'])){
            $fullname = trim($_POST['fullname']);
            $shippingAddress = trim($_POST['shippingAddress']);
            $gender = $_POST['gender'];
            
            $insertSQL = "UPDATE customer set shippingAddress = '$shippingAddress',fullname='$fullname',gender='$gender' WHERE id =".$_SESSION['id'];
            if(mysqli_query($conn,$insertSQL)){
                header("location:index.php");
            }
        }
    }
?>