<?php
    /*
        purpose: frontend php for first time login customer to register the details and normal user to update profile
    */
    session_start();
    require_once "../database/connect_db.php";
    require_once "update_customer.php";

    $ssc = "SELECT * FROM customer WHERE id = ".$_SESSION['id'];
    $rssc = mysqli_query($conn,$ssc);
    $rwsc = mysqli_fetch_assoc($rssc);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="customer_style.css">
    
    <!-- font awesome v5 -->
    <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>
    
    <!-- phone number masking -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>
  
</head>
  <body>
    <div class="container my-5 pt-4">
    <div class="row mb-2">
      <div class="text-center"><h1>Dairy Product Ordering</h1></div>
    </div>
        <div class="row">
            <div class="col-12 col-sm-8 m-auto">
            <div class="card border-0 shadow-lg">
                <div class="card-header text-center">
                    <?php if($_SESSION['password_check'] == 0) :?>
                    <h2>First Time Login</h2>
                    <h6>Please complete your registration first before proceeding</h6>
                    <?php else: ?>
                    <h2>Update profile</h2>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                <form action="" method="post">
                    <!-- to register -->
                    <div class="col input-group mb-3">
                        <span class="input-group-text" id="addon-name">Full name</span>
                        <input type="text" class="form-control" name="fullname" placeholder="Enter full name" aria-describedby="addon-name" value="<?php if (empty($fullname)) echo $rwsc['fullname']; else echo $fullname; ?>" required>
                    </div>
                    <div class="col input-group mb-3">
                        <span class="input-group-text" id="addon-address">Shipping Address</span>
                        <textarea class="form-control" name="shippingAddress" placeholder="Enter shipping address" rows="3" area-describedby="addon-address" required><?php if(empty($shippingAddress)) echo $rwsc['shippingAddress']; else echo $shippingAddress; ?></textarea>
                    </div>
                    <div class="col mb-3">
                        <span class="col">Gender:</span>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="gender" type="radio" id="radio_male" value="male" <?php if ($rwsc['gender'] == 'male') echo "checked"?> required>
                            <label class="form-check-label" for="radio_male">Male</label>
                           
                        </div>
                        <div class="form-check form-check-inline">
                             <input class="form-check-input" type="radio" name="gender" id="radio_female" value="female" <?php if ($rwsc['gender'] == 'female') echo "checked"?>>
                            <label class="form-check-label" for="radio_female">Female</label>
                        </div>
                    </div>

                    <!-- to update -->
                    <?php if($_SESSION['password_check'] == 1) :?>
                    <div class="col input-group mb-3">
                        <span class="input-group-text" id="addon-username">Username</span>
                        <input type="text" class="form-control <?php echo isset($error['username']) ? 'is-invalid' : ''; ?>" placeholder="Enter username" name="username" aria-describedby="addon-usernames" value="<?php if (empty($username)) echo $rwsc['username']; echo $username; ?>" required>
                        <div class="col-3 badge bg-warning text-wrap text-dark fs-6 my-auto"><?php echo $error['username'] ?? '';?></div>
                    </div>
                    <div class="col input-group mb-3">
                        <span class="input-group-text" id="addon-email">Email</span>
                        <input type="email" class="form-control <?php echo isset($error['email']) ? 'is-invalid' : '';?>" placeholder="Enter email" name="email" aria-describedby="addon-email" value="<?php if (empty($email)) echo $rwsc['email']; else  echo $email; ?>" required>
                        <div class="col-3 badge bg-warning text-wrap text-dark fs-6 text-center"><?php echo $error['email'] ?? '';?></div>
                    </div>
                    <div class="col input-group mb-3">
                        <span class="input-group-text" id="addon-phone">Phone number</span>
                        <input type="text" class="form-control <?php echo isset($error['phoneNum']) ? 'is-invalid' : '';?>" placeholder="Enter phone number" name="phoneNum" aria-describedby="addon-phone" id="phone-num" value="<?php if(empty($phoneNum)) echo $rwsc['phoneNumber'] ; else echo $phoneNum; ?>" required>
                        <div class="col-3 badge bg-warning text-wrap text-dark fs-6 my-auto" ><?php echo $error['phoneNum'] ?? '';?></div>
                    </div>
                    <?php endif; ?>

                    <!-- submit button -->
                    <div class="col mb-3">
                    <?php if($_SESSION['password_check'] == 0) :?>
                    <button type="submit" class="btn btn-primary mb-2 float-end submit-btn" name="custRegister">Register</button>
                    <?php else: ?>
                        <button type="submit" class="btn mb-2 float-end submit-btn" name="custUpdate">Update</button>
                        <a href="index.php" class="btn back-btn">Back</a>
                    <?php endif; ?>
                    </div>         
                </form>
                </div>
            </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </body>
</html>
<script>
    $('#phone-num').inputmask('999-9999 9999',{"placeholder": ""});
</script>
