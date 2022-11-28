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
    $current_password = "";

    if ($_SERVER['REQUEST_METHOD'] === "POST"){        
        if (isset($_POST['resetPassword'])){
            $password = trimInput($_POST['password']);
            $password2 = trimInput($_POST['password2']);

            if ($password == $password2){
                $hash_password = passwordValidation($password);
                if ($hash_password == ""){
                    $error['password'] = "Please follow the password rules";
                    return;
                }
                // from index
                if (isset($_SESSION['username'])){
                    $current_password = trimInput($_POST['current_password']);

                    if(password_verify($current_password, $_SESSION['password'])){
                        $updatePwd = "UPDATE ".$_SESSION['usertype']." SET password = '".$hash_password."' WHERE username = '".$_SESSION['username']."'";   
                    } else{
                        $error['current_password'] = "Current password is incorrect";
                        return;
                    }
                    if(mysqli_query($conn,$updatePwd)){
                        $_SESSION['message'] = "Password reset successfully";
                        if ($_SESSION['usertype'] == "customer"){
                            header("location:customer/index.php");
                        }
                        else{
                            header("location:staff/index.php");
                        }
                    } 
                }
                // from login
                else {
                    $username = trimInput($_POST['username']);
                    $email = trimInput($_POST['email']);

                    $ssc = "SELECT id FROM customer WHERE username = '".$username."' AND email = '".$email."'";
                    $rwsc = executeQuery($conn,$ssc);
                    if ($rwsc){
                        $table = "customer";
                        $user_id = $rwsc['id'];
                    } else{
                        // check if is STAFF
                        $sss = "SELECT id FROM staff WHERE username = '".$username."' AND email = '".$email."'";
                        $rwss = executeQuery($conn,$sss);
                        if ($rwss){
                            $table = "staff";
                            $row = mysqli_fetch_array($rwss);
                            $user_id = $rwss['id'];
                        } else{
                            // wrong error
                            $error['username'] = "Username does not exist";
                            $error['email'] = "Email does not exist";
                        }
                    }
                    $updatePwd = "UPDATE `".$table."` SET password = '".$hash_password."' WHERE id = ".$user_id;
                    if ($updatePwd != null){
                        if(mysqli_query($conn,$updatePwd)){
                            session_start();
                            $_SESSION['reset_password'] = "Password reset successfully";
                            header("location:login.php");
                        }else{
                        }
                    } 
                }
            } 
            else{
                $error['password'] = "Password does not match";
                $error['password2'] = "Password does not match";
                return;
            }
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
