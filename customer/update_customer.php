<?php
    /*
        purpose: frontend php for first time login customer to register the details
    */
    require_once "../database/connect_db.php";
    $error = [];
    $fullname = $shippingAddress = $gender = $phoneNum = $email = $username = "";
    
    if ($_SERVER['REQUEST_METHOD'] === "POST"){       
        $fullname = trim($_POST['fullname']);
        $shippingAddress = trim($_POST['shippingAddress']);
        $gender = $_POST['gender'];

        if (isset($_POST['custRegister'])){   
            $updateSQL = "UPDATE customer set shippingAddress = '$shippingAddress',fullname='$fullname',gender='$gender' WHERE id =".$_SESSION['id'];
            if(mysqli_query($conn,$updateSQL)){
                $_SESSION['message'] = "Profile is successfully registered";
                $_SESSION['password_check'] = 1;
                header("location:index.php");
            }
        }

        if (isset($_POST['custUpdate'])){
            $phoneNum = trim($_POST['phoneNum']);
            $email = trim($_POST['email']);
            $username = trim($_POST['username']);

            $username_check_SQL = "SELECT username FROM customer WHERE username = '".$username."' AND id !=".$_SESSION['id'];
            $email_check_SQL = "SELECT email FROM customer WHERE email = '".$email."'AND id !=".$_SESSION['id'];
            $phoneNum_check_SQL = "SELECT phoneNumber FROM customer WHERE phoneNumber = '".$phoneNum."'AND id !=".$_SESSION['id'];

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
                return;
            }
            if (empty($error)){
                $updateSQL = "UPDATE customer SET email = '$email', username = '$username',shippingAddress = '$shippingAddress',
                phoneNumber = '$phoneNum',fullname = '$fullname',gender = '$gender' WHERE id = ".$_SESSION['id'];
                if(mysqli_query($conn,$updateSQL)){
                    $_SESSION['message'] = "Profile is successfully updated";
                    header("location:index.php");
                }
            }
        }
    }
?>