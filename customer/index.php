<?php
    /*
        purpose: this is the first main page of customer after login
    */
require_once "../database/connect_db.php";

// this is to prevent uninitialized data
session_start();
if (empty($_SESSION["id"])){
    header("location:../login.php");
    exit;
}
if($_SESSION['usertype'] == 'customer'):
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Farm Treasure</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="customer_style.css">
    <!-- font awesome v5 -->
    <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>
  </head>
  <body>
    <!-- navigation -->
    <?php include_once("topmenu.php"); ?>

    <?php if(isset($_SESSION['message'])) :?>
    <div class="alert alert-success alert-dismissible fade show" role="alert" >
      <?php
        echo $_SESSION['message']."<br>";
        unset($_SESSION['message']);
      ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <!-- carousel -->
    <div id="carouselExampleControls" class="carousel slide m-5" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="home_pictures/cow.jpg" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
          <img src="home_pictures/dairy_farm1.jpg" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
          <img src="home_pictures/dairy_farm2.jpg" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
          <img src="home_pictures/cheese_making.jpg" class="d-block w-100" alt="...">
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>

    <footer class="py-2">
      <div class="container text-center"><small>Copyright &copy; Farm Treasure</small></div>
    </footer>   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </body>
</html>
<?php else:
  header("location:../auth/logout.php");
endif;
?>