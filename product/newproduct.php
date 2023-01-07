<?php
    /*
        purpose: frontend php to create new product
    */
    session_start();
    if (empty($_SESSION["id"]) || $_SESSION['role'] == "Courier"){
      header("location:index.php");
      exit;
  }
    require_once "create_product.php";
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add new product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href="../staff/leftmenu.css" rel="stylesheet">
    <link rel="stylesheet" href="../staff/template_style.css">
    <link rel="stylesheet" href="product_style.css">

    <!-- font awesome v5 -->
    <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>
    
    <!-- masking JQuery -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
    <script src="jquery.maskMoney.js" type="text/javascript"></script>

  </head>
  <body>
    <!-- navigation -->
    <?php include("../staff/leftmenu.php"); ?>

    <div class="content">
      <header><h2>add new product</h2></header>   

      <section class="container-fluid">
        <form action="" method="post" enctype="multipart/form-data">
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="prodname" class="form-label">Product Name</label>
              <input type="text" class="form-control " name="productName" id="prodname" value="<?php echo $productName;?>" required>
            </div>
            <div class="col-md-6">
              <label for="prodRM" class="form-label">Product Price</label>
              <div class="input-group">
                <span class="input-group-text">RM</span>
                <input type="text" class="form-control" name="productPrice" id="prodRM" value="<?php echo $productPrice;?>" required>
              </div>
            </div>
          </div>

         <!-- quantity - spinner  -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="prodqty" class="form-label">Product Current Quantity</label>
              <div class="stepper row g-3">
                <div class="btn col-lg-2" id="decrement" onclick="stepper(this)"><strong>-</strong></div>
                <div class="col-lg-4"><input type="number" class="form-control" name="productCurrentQty" id="prodqty" min="1" max="1000" step="1" value="<?php if($productCurrentQty) echo $productCurrentQty; else echo '1';?>" required></div>
                <div class="btn col-lg-2" id="increment" onclick="stepper(this)"><strong>+</strong></div>
              </div>
            </div>
            <div class="col-md-6">
              <label for="prodCat" class="form-label">Product Category</label>
              <select class="form-select mb-3" name="prodCat" required>
                <option selected>Choose a category</option>
                <option value="milk" <?php if ($productCat== 'milk') echo "selected" ?>>Milk</option>
                <option value="cheese" <?php if ($productCat== 'cheese') echo "selected" ?>>Cheese</option>
                <option value="yogurt" <?php if ($productCat== 'yogurt') echo "selected" ?>>Yogurt</option>
                <option value="butter" <?php if ($productCat== 'butter') echo "selected" ?>>Butter</option>
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="prodDesc" class="form-label">Product Description</label>
              <textarea class="form-control" name="productDesc" id="prodDesc" rows="4" required><?= $productDesc; ?></textarea>         
            </div>
            <div class="col-md-6">
              <label for="prodPic" class="form-label">Product Picture</label>
              <input type="file" class="form-control <?php echo isset($error['image']) ? 'is-invalid' : '';?>" name="prod_img" accept="image/*" required>
            </div>
          </div>

          <div class="row mb-3">
            <div class="btn-group col-2" role="group">
              <input class="btn btn-primary submit-btn" name="createprod" value="Create" type="submit" >
              <a href="../staff/index.php" class="btn btn-outline-primary back-btn">Back</a>
            </div>
          </div>
        </form>
      </section>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </body>
</html>
<script>  
  function stepper(btn){
    const prodqty = document.getElementById("prodqty");
    let id = btn.getAttribute("id");
    let min = prodqty.getAttribute("min");
    let max = prodqty.getAttribute("max");
    let step = prodqty.getAttribute("step");
    let val = prodqty.getAttribute("value");
    let calcStep = (id == "increment") ? (step*1): (step * -1);
    let newValue = parseInt(val) + calcStep;
    if(newValue >= min && newValue <= max){
      prodqty.setAttribute("value", newValue);
    }
  }

  $(function(){
    $('#prodRM').maskMoney();
  })
</script>