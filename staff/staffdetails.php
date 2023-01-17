<?php 
    /*
        purpose: frontend php page to display staff list and show the three buttons: view details, edit, archive, delete
    */
    session_start();
    if (empty($_SESSION['id'])){
      header("location:index.php");
      exit;
  }
    require_once "../database/connect_db.php";

    $sss = "SELECT * FROM staff WHERE id = ".$_GET['id'];
    $rsss = mysqli_query($conn,$sss);
    $rwss = mysqli_fetch_assoc($rsss);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Staff Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  
    <!-- font awesome v5 -->
    <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>
    
    <link rel="stylesheet" href="leftmenu.css">
    <link rel="stylesheet" href="template_style.css">  
</head>
  <body>
    <!-- navigation -->
    <?php include_once("leftmenu.php"); ?>
    <div class="content">
        <header><h2>details of <span style="text-transform: none;"><?php echo $rwss['username']; ?></span></h2></header>
        
        <section class="container-fluid">
          <div class="row">
            <div class="col-md-3"><label for="">Full name:</label></div>
            <div class="col-md-9"><?php echo $rwss['fullname']?></div>
          </div>
          <div class="row">
            <div class="col-md-3"><label for="">Username:</label></div>
            <div class="col-md-9"><?php echo $rwss['username']?></div>
          </div>
          <div class="row">
            <div class="col-md-3"><label for="">Email:</label></div>
            <div class="col-md-9"><?php echo $rwss['email']?></div>
          </div>
          <div class="row">
            <div class="col-md-3"><label for="">Department:</label></div>
            <div class="col-md-9"><?php echo $rwss['role']?></div>
          </div>
          <div class="row">
            <div class="col-md-3"><label for="">Gender:</label></div>
            <div class="col-md-9"><?php echo $rwss['gender']?></div>
          </div>
          <div class="row">
            <div class="btn-group col-2" role="group">
              <a href="editstaff.php?id=<?php echo $_GET['id']?>" class="btn btn-primary submit-btn">Edit</a>
              <a href="stafflist.php" class="btn btn-outline-primary back-btn">Back</a>
            </div>
          </div>
      </section>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </body>
</html>