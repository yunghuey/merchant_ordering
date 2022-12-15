<?php 
    /*
        purpose: frontend php page to edit one product
    */
    session_start();
    require_once "../database/connect_db.php";
    require_once "update_product.php";

    $ssp = "SELECT * FROM product WHERE productID = ".$_GET['id'];
    $rssp = mysqli_query($conn,$ssp);
    $rwsp = mysqli_fetch_assoc($rssp);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  
    <!-- font awesome v5 -->
    <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>
  
    <link rel="stylesheet" href="../staff/leftmenu.css">
    <link rel="stylesheet" href="../staff/template_style.css">
    <link rel="stylesheet" href="product_style.css">

    <!-- masking JQuery -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
    <script src="jquery.maskMoney.js" type="text/javascript"></script>

  </head>
  <body>
    <!-- navigation -->
    <?php include("../staff/leftmenu.php"); ?>
    <div class="content">
        <header><h2>Edit product</h2></header>
        <section class="container-fluid">
            <form action="" method="post" enctype="multipart/form-data">
            <div class="row">
                <input type="text" value="<?php echo $_GET['id']; ?>" name="id" hidden>
            </div>
            <div class="row">
                <div class="col input-group mb-3">
                <span class="input-group-text" id="addon-name">Product name</span>
                <input type="text" class="form-control" placeholder="Enter product name" name="productName" aria-describedby="addon-name" value="<?php if(!empty($productName)) echo $productName; else echo $rwsp['productName'] ?>" required>
                </div>
                <div class="col input-group mb-3">
                <span class="input-group-text" id="addon-price">Price RM</span>
                <input type="text" class="form-control" name="productPrice" id="prodRM" aria-describedby="addon-price" value="<?php if(!empty($productPrice)) echo $productPrice; else echo $rwsp['productPrice']?>" required>
                </div>
            </div>
            <div class="row">
                <div class="col input-group mb-3">
                    <span class="input-group-text" id="addon-quantity">Quantity</span>
                    <div class="btn btn-outline-secondary col-lg-2" id="decrement" onclick="stepper(this)"><strong>-</strong></div>
                    <input type="number" class="form-control" name="productCurrentQty" id="prodqty" min="1" max="1000" step="1" value="<?php if(!empty($productCurrentQty)) echo $productCurrentQty; else echo $rwsp['productCurrentQty'];?>" aria-describedby="addon-quantity" required>   
                    <div class="btn btn-outline-secondary col-lg-2" id="increment" onclick="stepper(this)"><strong>+</strong></div>
                </div>
                <div class="col input-group mb-3">
                    <span class="input-group-text" id="addon-cat">Category</span>
                    <select class="form-select" name="productCat" aria-describedby="addon-cat" required>
                        <option value="milk" <?php if ($rwsp['productCategory'] == 'milk') echo "selected" ?>>Milk</option>
                        <option value="cheese" <?php if ($rwsp['productCategory'] == 'cheese') echo "selected" ?>>Cheese</option>
                        <option value="yogurt" <?php if ($rwsp['productCategory'] == 'yogurt') echo "selected" ?>>Yogurt</option>
                        <option value="butter" <?php if ($rwsp['productCategory'] == 'butter') echo "selected" ?>>Butter</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col input-group mb-3">
                    <span class="input-group-text" id="addon-desc">Description:</span>
                    <textarea class="form-control" name="productDesc" id="prodDesc" aria-describedby="addon-desc" rows="4" required><?= $rwsp['productDesc']; ?></textarea>              
                </div>
                <div class="col mb-3">
                    <input type="file" class="form-control <?php echo isset($error['image']) ? 'is-invalid' : '';?>" name="prod_img" accept="image/*">
                    <br><img src="product_images/<?= $rwsp['productPicture'];?>" alt="product_images" style="height: 200px;">
                </div>
            </div>
            <div class="row">
                <div class="btn-group col-2" role="group">
                    <input class="btn btn-primary submit-btn" name="updateproduct" value="Update" type="submit" >
                    <a href="productlist.php" class="btn btn-outline-primary back-btn">Back</a>
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