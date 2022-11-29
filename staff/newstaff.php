<?php
    /*
        purpose: frontend to create new staff account
    */
    session_start();
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
    <link href="newstaff_style.css" rel="stylesheet">

  </head>
  <body>
    <!-- navigation -->
    <?php include("leftmenu.php"); ?>
    <div class="content">
      <header><h2>create new staff</h2></header>

      <section class="container-fluid">
        <form action="create_staff.php" method="post">
          <div class="row">
            <div class="col">
              <label class="form-label">Full name</label>
              <input type="text" class="form-control" placeholder="Enter full name" required>
            </div>
            <div class="col">
              <label class="form-label">Username</label>
              <input type="text" class="form-control" placeholder="Enter username" required>
            </div>
          </div>
          <div class="row">
            <div class="col">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" placeholder="Enter email" required>
            </div>
            <div class="col">
              <label class="form-label">Department</label>
              <select class="form-select" required>
                <option value="admin">Admin</option>
                <option value="management">Management</option>
                <option value="courier">Courier</option>
                <option value="stock">Stock</option>
              </select>
            </div>
          </div>
          <div class="col-12">
            <label class="form-label">Gender</label>
          </div>
          <div class="row">
            <div class="col-1">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="radioMale" required>
                <label class="form-check-label" for="radioMale">Male</label>
              </div>
            </div>
            <div class="col-1">
              <div class="form-check">
                  <input class="form-check-input" type="radio" name="gender" id="radioFemale" required>
                  <label class="form-check-label" for="radioFemale">Female</label>
              </div>
            </div> 
          </div>
          <div class="row">
            <div class="btn-group col-2" role="group" aria-label="">
              <input class="btn btn-primary submit-btn" value="Create" type="submit" >
              <button class="btn btn-outline-primary back-btn">Back</button>
            </div>
          </div>
        </form>
      </section>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </body>
</html>