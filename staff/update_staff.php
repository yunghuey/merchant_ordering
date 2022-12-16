<?php 
    /*
        purpose: backend php process for updating staff details into database
    */
    require_once "../database/connect_db.php";
    $error = [];

    $fullname = $username = $email = $dept = $gender = $id = "";

    if ($_SERVER['REQUEST_METHOD'] === "POST"){
        if(isset($_POST['updatestaff'])){
            $fullname = trim($_POST['fullname']);
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $dept = $_POST['dept'];
            $gender = $_POST['gender'];
            $id = $_POST['id'];
         
            $username_check_SQL = "SELECT username FROM staff WHERE username = '".$username."' AND id != ".$id;
            $email_check_SQL = "SELECT email FROM staff WHERE email = '".$email."'AND id != ".$id;

            $username_result = mysqli_query($conn,$username_check_SQL);
            $email_result = mysqli_query($conn,$email_check_SQL);

            if (mysqli_num_rows($username_result) > 0)
                $error['username'] = "Username already existed";
            
            if (mysqli_num_rows($email_result) > 0)
                $error['email'] = "Email already existed";
            
            if (empty($error)){
                $update_sql = "UPDATE staff SET fullname = '".$fullname."', username = '".$username."',
                               email = '".$email."', role = '".$dept."', gender = '".$gender."' WHERE id = ".$id;
                if (mysqli_query($conn,$update_sql)){
                    $_SESSION['message'] = "User ".$fullname." is updated successfully";
                    header("location:stafflist.php");
                }
            }else{
            }
        }
    }
?>