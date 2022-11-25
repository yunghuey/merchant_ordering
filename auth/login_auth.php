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
					$check_password = password_verify($password, $real_password);
					if(password_verify($password, $real_password)){
						session_start();
						// put value into session to hold
						$_SESSION['customerID'] = $row['customerID'];
						$_SESSION['username'] = $row['username'];
						// continue to the welcome page
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
							$_SESSION['staffID'] = $row['staffID'];
							$_SESSION['username'] = $row['username'];
							// continue to the welcome page
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
/*
				// to view php variable in console
				?>
					<script>
						console.log(<?= json_encode($password); ?>);
						console.log(<?= json_encode($real_password); ?>);
						console.log(<?= json_encode($check_password); ?>);
					</script>
					<?php 
				*/
?>