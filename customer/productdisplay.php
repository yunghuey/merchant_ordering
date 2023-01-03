<?php
    /*
        purpose: frontend php to display product card
    */
    session_start();
    require_once "../database/connect_db.php";

    $ssp = "SELECT * FROM product WHERE productCurrentQty > 0";

    if($_SERVER['REQUEST_METHOD'] === "POST"){
        if (isset($_POST['addcart'])){
            // get data to display
            $productid = $_POST['productID'];
            $quantity = $_POST['productCurrentQty'];
            $subtotal = $_POST['productPrice'] * $quantity;
            $custid = $_SESSION['id'];
            // check if got duplicated
            $sql = "SELECT orderedProductID FROM `ordered_product` WHERE productID = ".$productid." AND customerID = ".$custid." AND hasOrder = 0 LIMIT 1";
            $rsql = mysqli_query($conn,$sql);
            $rwsql = mysqli_fetch_assoc($rsql);

            if($rwsql){
                $cart_sql = "UPDATE  `ordered_product` SET quantity = quantity + ".$quantity." WHERE productID = ".$productid." AND customerID = ".$custid." AND hasOrder = 0";
            } else{
                $cart_sql = "INSERT INTO ordered_product (productID,quantity,subtotal,customerID,hasOrder) VALUES ('$productid','$quantity','$subtotal','$custid',0) ";
            }
            mysqli_query($conn,$cart_sql);     
            // sweet alert
            echo "<script>alert('Item is added into cart'); window.location.href='productdisplay.php'; </script>";
            die();
        }
    }
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="customer_style.css">
    <link rel="stylesheet" href="../product/product_style.css">

    <!-- jquery link -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity= "sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

    <!-- font awesome v5 -->
    <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>
  </head>
  <body>
    <!-- navigation -->
    <?php include("topmenu.php"); 
    unset($rssp);
    if($rssp = mysqli_query($conn,$ssp)):
         $count = 0;
         $newRow = true;
    ?>

    <div class="container my-5">
        <?php 
        
        while($row = mysqli_fetch_assoc($rssp)):   
        
            if($newRow){
                echo "<div class='row mx-auto justify-content-between align-items-center'>";
                $newRow = false;
            }
        ?>
            <div class="card col-lg-3 mx-3 my-2">
                <img src="../product/product_images/<?= $row['productPicture']?>" class="card-img-top w-100 p-4" alt="">
                <div class="card-body p-2">
                    <h4 class="card-title"><?= $row['productName']?></h4>
                    <div class="d-flex justify-content-between">
                        <p class="card-text"><?= $row['productCategory']?></p>
                        <p class="card-text mr-4 text-success">RM<?= number_format($row['productPrice'],2);?></p>
                    </div>
                    <a href="#" class="card-link modalbutton" data-bs-toggle="modal" data-bs-target="#modalproduct" data-id="<?= $row['productID']?>" data-name="<?= $row['productName']?>" data-img="<?= $row['productPicture']?>" data-desc="<?= $row['productDesc']?>" data-price="<?= number_format($row['productPrice'],2); ?>">See Details</a>
                </div>
            </div>    
        <?php 
            $count++;
            if($count == 3){
                echo "</div><br>";
                $newRow = true;
                $count = 0;
            }
            endwhile;?>   
        </div><?php endif;?>
    
        <!-- Modal -->
        <div class="modal fade" id="modalproduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Product details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <center><img src="" id="productImg" height="200" width="200"></center>
                    <div class="row mb-1">
                    <form action="productdisplay.php" method="post">

                        <div class="col-6 form-group">
                            <label for="productName">Name:</label>
                            <input type="text" class="form-control" id="productName" name="productName" readonly>
                        </div>
                        <div class="col-6 form-group mb-1">
                            <label for="productPrice">Price:</label>
                            <input type="text" class="form-control" id="productPrice" name="productPrice" readonly>
                        </div>
                    </div>
                    <div class="form-group mb-1">
                        <label for="productDescription">Description:</label>
                        <textarea class="form-control" id="productDescription" rows="2" readonly></textarea>
                    </div>
                    
                    <div class="col-6 form-group mb-1">
                        <label for="orderQty">Quantity:</label>
                        <div class="stepper row g-3">
                            <div class="btn col-lg-2" id="decrement" onclick="stepper(this)"><strong>-</strong></div>
                            <div class="col-lg-4"><input type="number" class="form-control" name="productCurrentQty" id="orderQty" min="1" max="1000" step="1" value="<?= '1';?>" required></div>
                            <div class="btn col-lg-2" id="increment" onclick="stepper(this)"><strong>+</strong></div>
                        </div>
                    </div>
                    <input type="text" class="form-control" id="productID" name="productID" hidden>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-close-modal" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn buy-btn" name="addcart">Add to cart</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </body>
</html>
<script type="text/javascript">
    $(document).ready(function(){
        $('.card').on('click','.modalbutton', function(){
            var picture = "http://localhost/merchant_ordering/product/product_images/";
            var name = $(this).attr('data-name');
            var id = $(this).attr('data-id');
            var price = $(this).attr('data-price');
            var desc = $(this).attr('data-desc');
            var picture_path = $(this).attr('data-img');
                    
            picture += picture_path;
            
            $('.modal').find('#productName').val(name);
            $('.modal').find('#productPrice').val(price);
            $('.modal').find('#productImg').attr("src",picture);
            $('.modal').find('#productDescription').val(desc);
            $('.modal').find('#productID').val(id);

        });
    });
    function stepper(btn){
        const orderQty = document.getElementById("orderQty");
        let id = btn.getAttribute("id");
        let min = orderQty.getAttribute("min");
        let max = orderQty.getAttribute("max");
        let step = orderQty.getAttribute("step");
        let val = orderQty.getAttribute("value");
        let calcStep = (id == "increment") ? (step*1): (step * -1);
        let newValue = parseInt(val) + calcStep;
        if(newValue >= min && newValue <= max){
        orderQty.setAttribute("value", newValue);
        }
    }
</script>