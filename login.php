<?php 
  /* 
    purpose: login page for customer and staff, FORGOT PASSWORD can lead to reset password
    testing acc: customer:yhuey@gmail.com, yhuey, 123456
                 staff: staffhuey@gmail.com, staffhuey, staff123
  */
require_once "./database/login_auth.php" 
?>
<!doctype html>
<html lang="en">
<head>
  <!-- required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- bootstrap css -->
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  <link rel="stylesheet" href="style/auth.css">
</head>
<body>

  <?php if(isset($_SESSION['message'])) :?>
  <div class="alert alert-success" role="alert">
    <?php
      echo $_SESSION['message']."<br>";
      session_destroy();
    ?>
  </div>
  <?php endif; ?>
  
  <div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-12 col-sm-8 col-md-6 m-auto">
          <div class="card border-0 shadow-lg">
            <div class="card-header text-center">
              <h2>Sign in</h2>
              <h6>Good to see you again</h6>
            </div>
            <div class="card-body">
              <form action="" method="post">
                <!-- input field -->
                <div class="form-floating mb-3">
                  <div class="invalid-feedback"><?php echo $error['username'] ?? '';?></div>
                  <input type="text" class="form-control my-3 py-2 <?php echo isset($error['username']) ? 'is-invalid' : '';?>" name="username" placeholder="Username/Email" value="<?php echo $username;?>" placeholder="Username" name="username" id="floatingInput" required>
                  <label for="floatingInput">Username/Email address</label>
                </div>

                <div class="form-floating mb-3">
                  <div class="invalid-feedback"><?php echo $error['password'] ?? '';?></div>
                  <input type="password" class="form-control <?php echo isset($error['password']) ? 'is-invalid' : '';?>" id="floatingPassword" placeholder="Password" name="password" required>
                  <label for="floatingPassword">Password</label>
                </div>

                <!-- submit button -->
                <div class="text-center mb-3">
                  <button type="submit" class="btn btn-primary mb-2" name="userLogin" id="submit_btn">Login now</button>
                  <a href="#" class="nav-link">Forgot password?</a>
                </div>         
              </form>
            </div>
          </div>
        </div>
    </div>
  </div>
   
    
  <!-- bootstrap bundle with popper-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>



  
  </body>
</html>

<!-- example of taking data from database SHOW  -->
<?php    
/*
  $sql = "SELECT * FROM customer WHERE customerID = 1";
  $result = mysqli_query($conn,$sql);
  if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result))
    {
      echo $row["email"];
    }
} 
*/                     
?>