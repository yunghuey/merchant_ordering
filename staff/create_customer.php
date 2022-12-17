<?php 
    /*
        purpose: backend process for newstaff.php, create new customer and insert into database
    */
    require_once "../database/connect_db.php";
    $error = [];
    $username = $email = $phoneNum = "";

    if($_SERVER['REQUEST_METHOD'] === "POST"){
        if(isset($_POST['createcustomer'])){
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $phoneNum = $_POST['phoneNum'];
            $hash_password = password_hash("abc1234",PASSWORD_DEFAULT);

            $username_check_SQL = "SELECT username FROM customer WHERE username = '".$username."'";
            $email_check_SQL = "SELECT email FROM customer WHERE email = '".$email."'";
            $phoneNum_check_SQL = "SELECT phoneNumber FROM customer WHERE phoneNumber = '".$phoneNum."'";

            $username_result = mysqli_query($conn,$username_check_SQL);
            $email_result = mysqli_query($conn,$email_check_SQL);
            $phone_result = mysqli_query($conn,$phoneNum_check_SQL);
            
            if (mysqli_num_rows($username_result) > 0){
                $error['username'] = "Username already existed";
            }
            if (mysqli_num_rows($email_result) > 0){
                $error['email'] = "Email already existed";
            }
            if (mysqli_num_rows($phone_result) > 0){
                $error['phoneNum'] = "Phone number already existed";
                // return;
            }
            if (empty($error)){
                $insertSQL = "INSERT INTO customer (email,username,password,phoneNumber,password_check) VALUES ('$email', '$username','$hash_password','$phoneNum',0)";
                if (mysqli_query($conn,$insertSQL)){
                    $_SESSION['message'] = "Customer ".$username." is created successfully";
                    header("location:index.php");
                }
            }
        }
    }
