<?php
    /*
        purpose: this backend php is to reset the password
        function: check if username and email match + check if password1 and password2 are the same
    */
    require_once "./database/connect_db.php";
    $error = [];
    $username= "";
    $email = "";
    $password = "";
    $password2 = "";
    $updatePwd = "";

    if ($_SERVER['REQUEST_METHOD'] === "POST"){
        if (isset($_POST['resetPassword'])){
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $password2 = trim($_POST['password2']);

            if ($password == $password2){
                // correct sql
                $ssc = "SELECT customerID FROM customer WHERE username = '".$username."' AND email = '".$email."'";
                $rssc = mysqli_query($conn, $ssc);
                $rwsc = mysqli_fetch_array($rssc);          
                if ($rwsc){
                    // is customer
                        $updatePwd = "UPDATE customer SET password = '".$password."' WHERE customerID = ".$rwsc['customerID'];
                } else{
                    // check if is STAFF
                    $sss = "SELECT staffID FROM staff WHERE username = '".$username."' AND email = '".$email."'";
                    $rsss = mysqli_query($conn, $ssc);
                    $rwss = mysqli_fetch_array($rsss);
                    if ($rwss){
                        // confirm is staff
                        $updatePwd = "UPDATE staff SET password = '".$password."' WHERE staffID = ".$rwss['staffID'];
                    } else{
                        // wrong error
                        $error['username'] = "Username does not exist";
                        $error['email'] = "Email does not exist";
                    }
                }
               
                
                // query check if username and email are same in database
                // if true then proceed to alter data
                // if false then proceeed to error message.
    
                
            } else{
                $error['password'] = "Password does not match";
                $error['password2'] = "Password does not match";
            }
        }   
    }
    if ($updatePwd != null){
        if(mysqli_query($conn,$updatePwd)){
            header("location:login.php");
        }else{
        }
    }    

?>     
