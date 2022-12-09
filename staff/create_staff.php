<?php 
    /*
        purpose: backend process for newstaff.php
    */
    require_once "../database/connect_db.php";
    // check if unique - username and email
    $error = [];
    $fullname = $username = $email = $dept = $gender = "";

    if($_SERVER['REQUEST_METHOD'] === "POST"){
        if(isset($_POST['createstaff'])){
            $fullname = $_POST['fullname'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $dept = $_POST['dept'];
            $gender = $_POST['gender'];
            $hash_password = password_hash("abc1234",PASSWORD_DEFAULT);

            $username_check_SQL = "SELECT username FROM staff WHERE username = '".$username."'";
            $email_check_SQL = "SELECT email FROM staff WHERE email = '".$email."'";

            $username_result = mysqli_query($conn,$username_check_SQL);
            $email_result = mysqli_query($conn,$email_check_SQL);

            if (mysqli_num_rows($username_result) > 0){
                $error['username'] = "Username already existed";
                // return;
            }
            if (mysqli_num_rows($email_result) > 0){
                $error['email'] = "Email already existed";
                return;
            }

            if (empty($error)){
                $insertSQL = "INSERT INTO staff (username,fullname,email,role,gender,password,password_check,archive) VALUES ('$username', '$fullname','$email','$dept','$gender','$hash_password',0,0)";
                if (mysqli_query($conn,$insertSQL)){
                    $_SESSION['message'] = "User ".$fullname." is created successfully";
                    header("location:index.php");
                }
            }
            
        }
        
    }
?>