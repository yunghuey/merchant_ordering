<?php
    /*
        purpose: frontend php to create new staff account
    */
    session_start();
    require_once "create_staff.php";
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create new staff</title>
    
    <!-- font awesome v5 for leftmenu-->
    <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>

    <!-- bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href="leftmenu.css" rel="stylesheet">
    <link rel="stylesheet" href="template_style.css">

  </head>
  <body>
    <!-- navigation -->
    <?php include("leftmenu.php"); ?>
    <div class="content">
      <header><h2>create new staff</h2></header>

      <section class="container-fluid">
        <form action="" method="post">
          <div class="row">
            <div class="col input-group mb-3">
              <span class="input-group-text" id="addon-name">Full name</span>
              <input type="text" class="form-control" placeholder="Enter full name" name="fullname" aria-describedby="addon-name" value="<?php echo $fullname ?>" required>
            </div>
            <div class="col input-group mb-3">
              <span class="input-group-text" id="addon-username">Username</span>
              <input type="text" class="form-control <?php echo isset($error['username']) ? 'is-invalid' : ''; ?>" placeholder="Enter username" name="username" aria-describedby="addon-usernames" value="<?php echo $username; ?>" required>
              <div class="col-3 badge bg-warning text-wrap text-dark fs-6 my-auto"><?php echo $error['username'] ?? '';?></div>
            </div>
          </div>
          <div class="row">
            <div class="col input-group mb-3">
              <span class="input-group-text" id="addon-email">Email</span>
              <input type="email" class="form-control <?php echo isset($error['email']) ? 'is-invalid' : '';?>" placeholder="Enter email" name="email" aria-describedby="addon-email" value="<?php echo $email?>" required>
              <div class="col-3 badge bg-warning text-wrap text-dark fs-6 my-auto" ><?php echo $error['email'] ?? '';?></div>
            </div>
            <div class="col input-group mb-3">
              <span class="input-group-text" id="addon-department">Department</span>
              <select class="form-select" name="dept" aria-describedby="addon-department" required>
                <option value="Admin" <?php if ($dept== 'Admin') echo "selected" ?> >Admin</option>
                <option value="Management" <?php if ($dept== 'Management') echo "selected" ?>>Management</option>
                <option value="Courier" <?php if ($dept== 'Courier') echo "selected" ?>>Courier</option>
                <option value="Stock" <?php if ($dept== 'Stock') echo "selected" ?>>Stock</option>
              </select>
            </div>
          </div>
          <div class="row">
            <span class="col-1">Gender:</span>
            <div class="form-check col-2">
              <input class="form-check-input" type="radio" name="gender" id="radio_male" value="male" <?php if ($gender == 'male') echo "checked"?> required>
              <label class="form-check-label" for="radio_male">Male</label>
            </div>
            <div class="form-check col-2">
              <input class="form-check-input" type="radio" name="gender" id="radio_female" value="female" <?php if ($gender== 'female') echo "checked"?>>
              <label class="form-check-label" for="radio_female">Female</label>
            </div>
          </div>
          <div class="row">
            <div class="btn-group col-2" role="group">
              <input class="btn btn-primary submit-btn" name="createstaff" value="Create" type="submit" >
              <a href="index.php" class="btn btn-outline-primary back-btn">Back</a>
            </div>
          </div>
        </form>
      </section>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </body>
</html>