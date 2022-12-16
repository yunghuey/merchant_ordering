<?php
    /*
        purpose: frontend php for first time login customer to register the details
    */
    session_start();
    require_once "../database/connect_db.php";
    require_once "update_customer.php";
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="customer_style.css">
    <!-- font awesome v5 -->
    <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>
  </head>
  <body>
    <div class="container mt-5 pt-4">
    <div class="row mb-2">
      <div class=" text-center"><h1>Dairy Product Ordering</h1></div>
    </div>
        <div class="row">
            <div class="col-12 col-sm-8 col-md-6 m-auto">
            <div class="card border-0 shadow-lg">
                <div class="card-header text-center">
                <h2>First Time Login</h2>
                <h6>Please complete your registration first before proceeding</h6>
                </div>
                <div class="card-body">
                <form action="" method="post">
                    <div class="col input-group mb-3">
                        <span class="input-group-text" id="addon-name">Full name</span>
                        <input type="text" class="form-control" name="fullname" placeholder="Enter full name" aria-describedby="addon-name" value="<?php echo $fullname ?>" required>
                    </div>
                    <div class="col input-group mb-3">
                            <span class="input-group-text" id="addon-address">Shipping Address</span>
                            <textarea class="form-control" name="shippingAddress" placeholder="Enter shipping address" rows="3" area-describedby="addon-address" required><?php echo $shippingAddress; ?></textarea>
                    </div>
                    <div class="col mb-3">
                        <span class="col">Gender:</span>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="gender" type="radio" id="radio_male" value="male" <?php if ($gender == 'male') echo "checked"?> required>
                            <label class="form-check-label" for="radio_male">Male</label>
                           
                        </div>
                        <div class="form-check form-check-inline">
                             <input class="form-check-input" type="radio" name="gender" id="radio_female" value="female" <?php if ($gender== 'female') echo "checked"?>>
                            <label class="form-check-label" for="radio_female">Female</label>
                        </div>
                    </div>

                    <!-- submit button -->
                    <div class="col mb-3">
                    <button type="submit" class="btn btn-primary mb-2 float-end" name="custRegister" id="submit_btn">Register</button>
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
