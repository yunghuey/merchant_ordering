<?php
    /* 
        purpose: main page after login if user is staff
    */
session_start();
if($_SESSION['usertype'] == 'staff'):
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>

    <!-- font awesome v5 for leftmenu-->
    <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>

    <!-- bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href="leftmenu.css" rel="stylesheet">
  </head>
  <body>
    <?php include_once("leftmenu.php"); ?>

    <?php if(isset($_SESSION['message'])) :?>
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-left: 100px; width: 500px; ">
      <?php
        echo $_SESSION['message']."<br>";
        unset($_SESSION['message']);
      ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>
    <!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </body>
</html>
<?php else:
  header("location:../auth/logout.php");
endif;
?>