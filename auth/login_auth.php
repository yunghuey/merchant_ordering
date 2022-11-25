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
				// query to check in CUSTOMER
				$ssc = "SELECT * FROM customer WHERE (username = '$username' OR email = '$username') AND password = '$password'";
				$rssc = mysqli_query($conn, $ssc);
				$rwsc = mysqli_num_rows($rssc);

				// if got result, is true
				if($rwsc > 0) // one basically
				{
					// take the attribute
					$row = mysqli_fetch_array($rssc);
					session_start();
					// put value into session to hold
					$_SESSION['customerID'] = $row['customerID'];
					$_SESSION['username'] = $row['username'];
					// continue to the welcome page
					header("location: customer/index.php");
				}
				// query to check in STAFF
				else
				{
					$sss = "SELECT * FROM staff WHERE username = '$username' OR email = '$username'";
					// check variable only
					$rsss = mysqli_query($conn, $sss);
					$rwss = mysqli_num_rows($rsss);
				
					// user is staff
					if ($rwss > 0){
						// take the attribute
						$row = mysqli_fetch_array($rsss);
						session_start();
						// put value into session to hold
						$_SESSION['staffID'] = $row['staffID'];
						$_SESSION['username'] = $row['username'];
						// continue to the welcome page
						header("location: staff/index.php");
					}
					// not customer nor staff - need to check if is username or password problem
					else{
						$ssc = "SELECT * FROM customer WHERE username = '$username' OR email = '$username'";
						$rssc = mysqli_query($conn, $ssc);
						$rwsc += mysqli_num_rows($rssc);
							
						if($rwsc > 0)
						{
							$error['password'] = "Wrong password";
						}
						else
						{
							$error['username'] = "Wrong username/email address";
						}

						$sss = "SELECT * FROM staff WHERE username = '$username' OR email = '$username'";
						$rsss = mysqli_query($conn, $sss);
						$rwss += mysqli_num_rows($rsss);
							
						if($rwss > 0)
						{
							$error['password'] = "Wrong password";
						}
						else
						{
							$error['username'] = "Wrong username/email address";
						}
					}
				}
			}
		}
	}
?>