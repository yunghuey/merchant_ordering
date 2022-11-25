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
            $username = trimInput($_POST['username']);
            $email = trimInput($_POST['email']);
            $password = trimInput($_POST['password']);
            $password2 = trimInput($_POST['password2']);

            if ($password == $password2){
                $hash_password = passwordValidation($password);
                if ($hash_password == ""){
                    $error['password'] = "Please follow the password rules";
                    return;
                }               
                $ssc = "SELECT customerID FROM customer WHERE username = '".$username."' AND email = '".$email."'";
                $rwsc = executeQuery($conn,$ssc);          
                if ($rwsc){
                    // is customer
                        $updatePwd = "UPDATE customer SET password = '".$hash_password."' WHERE customerID = ".$rwsc['customerID'];
                } else{
                    // check if is STAFF
                    $sss = "SELECT staffID FROM staff WHERE username = '".$username."' AND email = '".$email."'";
                    $rwss = executeQuery($conn,$sss);
                    if ($rwss){
                        // confirm is staff
                        $updatePwd = "UPDATE staff SET password = '".$hash_password."' WHERE staffID = ".$rwss['staffID'];
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
    if ($updatePwd != null && !empty($hash_password)){
        if(mysqli_query($conn,$updatePwd)){
            header("location:login.php");
        }else{
        }
    } 
    function executeQuery($conn,$sql){
        $row = mysqli_fetch_array(mysqli_query($conn, $sql));
        return $row;
    }

    function trimInput($input){
        return trim($input);
    }

    function passwordValidation($pwd){
        $uppercase = preg_match('@[A-Z]@', $pwd);
        $lowercase = preg_match('@[a-z]@', $pwd);
        $number    = preg_match('@[0-9]@', $pwd);
        $specialChars = preg_match('@[^\w]@', $pwd);

        if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($pwd) < 8) {
            return;
        }

        return password_hash($pwd,PASSWORD_DEFAULT);
    }
    
    

?>     
