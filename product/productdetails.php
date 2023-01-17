<?php 
    /*
        purpose: frontend php page to display product list and show the three buttons: view details, edit, delete
    */
    session_start();
    if (empty($_SESSION['id'])){
      header("location:index.php");
      exit;
    }
    require_once "../database/connect_db.php";

    $ssp = "SELECT * FROM product WHERE productID = ".$_GET['id'];
    $rssp = mysqli_query($conn,$ssp);
    $rwsp = mysqli_fetch_assoc($rssp);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Product Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  
    <!-- font awesome v5 -->
    <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>
    
    <link rel="stylesheet" href="../staff/leftmenu.css">
    <link rel="stylesheet" href="../staff/template_style.css">  
</head>
  <body>
    <!-- navigation -->
    <?php include_once("../staff/leftmenu.php"); ?>
    <div class="content">
        <header><h2>details of <span style="text-transform: none;"><?php echo $rwsp['productName']; ?></span></h2></header>
        
        <section class="container-fluid">
          <div class="row">
            <div class="col-md-3"><label for="">Product name:</label></div>
            <div class="col-md-9"><?php echo $rwsp['productName']?></div>
          </div>
          <div class="row">
            <div class="col-md-3"><label for="">Product Quantity:</label></div>
            <div class="col-md-9"><?php echo $rwsp['productCurrentQty']?></div>
          </div>
          <div class="row">
            <div class="col-md-3"><label for="">Price:</label></div>
            <div class="col-md-9">RM <?php echo $rwsp['productPrice']?></div>
          </div>
          <div class="row">
            <div class="col-md-3"><label for="">Category:</label></div>
            <div class="col-md-9"><?php echo $rwsp['productCategory']?></div>
          </div>
          <div class="row">
            <div class="col-md-3"><label for="">Description:</label></div>
            <div class="col-md-9"><?php echo $rwsp['productDesc']?></div>
          </div>
          <div class="row">
            <div class="col-md-3">Product image:</div>
            <div class="col-md-5"><img src="product_images/<?= $rwsp['productPicture'];?>" alt="product_images" style="height: 200px;"></div>
          </div>
          <div class="row">
            <div class="btn-group col-2" role="group">
              <a href="editproduct.php?id=<?php echo $_GET['id']?>" class="btn btn-primary submit-btn">Edit</a>
              <a href="http://localhost/merchant_ordering/product/productlist.php" class="btn btn-outline-primary back-btn">Back</a>
            </div>
          </div>
      </section>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </body>
</html>