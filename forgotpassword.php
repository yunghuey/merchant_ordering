<?php
    /*
        purpose: to let user change password if they forgot
    */
    session_start();
    require_once "./auth/reset_password.php";
?>
<!doctype html>
<html lang="en">
<head>
    <!-- required meta tags -->
    <meta charset="utf-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1">
  
    <!-- bootstrap css -->
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style/auth.css">

</head>
<body>
<div class="container my-2 pt-5">
    <div class="row">
        <div class="col-12 col-sm-8 col-md-6 m-auto">
          <div class="card border-0 shadow-lg">
            <div class="card-header text-center">
              <h2>Reset Password</h2>
            </div>
            <div class="card-body">
              <form action="" method="post">
              <div class="alert alert-primary" role="alert">
                Password should include at least 8 characters, 1 number, 1 special character and 1 uppercase letter
              </div>
                <?php if(!isset($_SESSION['username'])) :?>
                <div class="form-floating mb-3">
                  <input type="text" class="form-control <?php echo isset($error['username']) ? 'is-invalid' : ''; ?> " placeholder="Username" name="username" value="<?php $username ?>" required> 
                  <label for="floatingInput">Username</label>
                  <div class="invalid-feedback"><?php echo $error['username'] ?? '';?></div>
                </div>

                <div class="form-floating mb-3">
                  <input type="email" class="form-control <?php echo isset($error['email']) ? 'is-invalid' : '';?>" placeholder="Email"  name="email" value="<?php echo $email ?>" required >
                  <label for="floatingEmail">Email</label>
                  <div class="invalid-feedback"><?php echo $error['email'] ?? '';?></div>
                </div>
                <?php endif; ?>
                <?php if(isset($_SESSION['username'])) :?>
                  <div class="form-floating mb-3">
                    <input type="password" class="form-control <?php echo isset($error['current_password']) ? 'is-invalid' : '';?>" placeholder="Current Password" name="current_password" required>
                    <label for="floatingPassword">Current password</label>
                    <div class="invalid-feedback"><?php echo $error['current_password'] ?? '';?></div>
                  </div>
                <?php endif; ?>

                <div class="form-floating mb-3">
                  <input type="password" class="form-control <?php echo isset($error['password']) ? 'is-invalid' : '';?>" placeholder="Password" name="password" required>
                  <label for="floatingPassword">New Password</label>
                  <div class="invalid-feedback"><?php echo $error['password'] ?? '';?></div>
                </div>

                <div class="form-floating mb-3">
                  <input type="password" class="form-control <?php echo isset($error['password2']) ? 'is-invalid' : '';?>" placeholder="Confirm Password" name="password2" required>
                  <label for="floatingPassword2">Confirm Password</label>
                  <div class="invalid-feedback"><?php echo $error['password2'] ?? '';?></div>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary mb-2" name="resetPassword" id="submit_btn">Change password</button>
                  <?php if(!isset($_SESSION['username'])) :?>
                  <br>Already have account? <a href="./login.php" class="nav-link">Login here</a>
                  <?php else: ?>    
                    <?php if($_SESSION['usertype'] == 'customer') :?>
                      <a href="customer/index.php" type="button" class="btn btn-primary mb-2" id="submit_btn">Back</a>
                    <?php else: ?>  
                      <a href="staff/index.php" type="button" class="btn btn-primary mb-2" id="submit_btn">Back</a>
                    <?php endif; ?>
                  <?php endif; ?>
                </div>
              </form>
            </div>
          </div>
        </div>
    </div>
  </div>
</body>