<?php
// get connection to database
require_once "connect_db.php";
// to initialize the error
$error = [];
// $error = "";
// $username_error = "";
// $password_error = "";
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
            // query to check the name
			$sql = "SELECT * FROM customer WHERE (username = '$username' OR email = '$username') AND password = '$password'";
			$result = mysqli_query($conn, $sql);
			$rowCount = mysqli_num_rows($result);

            // if got result, is true
			if($rowCount > 0) // one basically
			{
                // take the attribute
				$row = mysqli_fetch_array($result);
				session_start();
                // put value into session to hold
				$_SESSION['customerID'] = $row['customerID'];
				$_SESSION['username'] = $row['username'];
				// continue to the welcome page
                header("location: customer/index.php");
			}
            // if no result, wrong value
			else
			{
                // check variable only
				$sql = "SELECT * FROM customer WHERE username = '$username' OR email = '$username'";
				$result = mysqli_query($conn, $sql);
				$rowCount = mysqli_num_rows($result);

				if($rowCount > 0)
				{
                    $error['password'] = "Wrong password";
				}
				else
				{
					$error['username'] = "Wrong username";
                }
			}
		}
	}
}
?>