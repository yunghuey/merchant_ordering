<?php
	/*
		purpose: this php is to check the authentication of user
		sst - script select transactionn table
		rsst - result script select transaction
		rwst - row script transaction
	*/
	require_once "./database/connect_db.php";
	
	$error = [];
	$username = $password = "";

	if($_SERVER['REQUEST_METHOD'] === "POST")
	{
		// if the button with name 'userLogin' is clicked
		if(isset($_POST['userLogin']))
		{
			// take the $_POST and put into variable
			$username = trim($_POST['username']);
			$password = trim($_POST['password']);

        // if both variable has value
			if($username && $password)
			{
				$getPwd = "SELECT * FROM customer WHERE (username = '$username' OR email = '$username')";
				$rssc = mysqli_query($conn, $getPwd);
				$rwsc = mysqli_num_rows($rssc);
				// is customer
				if($rwsc > 0){ // check password
					$row = mysqli_fetch_array($rssc);
					$real_password = $row['password'];	
					if(password_verify($password, $real_password)){
						session_start();
						// put value into session to hold
						$_SESSION['id'] = $row['id'];
						$_SESSION['username'] = $row['username'];
						$_SESSION['email'] = $row['email'];
						$_SESSION['password'] = $row['password'];
						$_SESSION['usertype'] = "customer";
						// $_SESSION['fullname'] = $row['fullname'];
						// $_SESSION['shippingAddress'] = $row['shippingAddress'];
						// $_SESSION['gender'] = $row['gender'];
						if($row['password_check'] == 0 )
							header("location: forgotpassword.php");
						else
							header("location: customer/index.php");
					} else{
						// wrong password
						$error['password'] = "Wrong password";
					}
				}
				// check if staff
				else {
					$getPwd = "SELECT * FROM staff WHERE (username = '$username' OR email = '$username')";
					$rsss = mysqli_query($conn, $getPwd);
					$rwss = mysqli_num_rows($rsss);
					if ($rwss > 0){
						$row = mysqli_fetch_array($rsss);
						$real_password = $row['password'];
						if(password_verify($password, $real_password)){
							// it is staff, check password
							session_start();
							// put value into session to hold
							$_SESSION['id'] = $row['staffID'];
							$_SESSION['username'] = $row['username'];
							$_SESSION['email'] = $row['email'];
							$_SESSION['password'] = $row['password'];
							$_SESSION['usertype'] = "staff";
							if($row['password_check'] == 0 )
								header("location: forgotpassword.php");
							else
								header("location: staff/index.php");
						} else{
							// wrong password
							$error['password'] = "Wrong password";
						}
					}
					else{
						$error['username'] = "Wrong username/email";
					}
				}
			}
		}
	}
?>