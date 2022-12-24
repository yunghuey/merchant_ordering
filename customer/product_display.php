<?php
    /*
        purpose: frontend php to display product card
    */
    session_start();
    require_once "../database/connect_db.php";

    $ssp = "SELECT * FROM product WHERE productCurrentQty > 0";
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="customer_style.css">

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
                echo "<div class='row mx-auto'>";
                $newRow = false;
            }
        ?>
            <div class="card col-lg-3 mx-3 my-2">
                <img src="../product/product_images/<?= $row['productPicture']?>" class="card-img-top w-100 p-4" alt="">
                <div class="card-body p-2">
                    <h4 class="card-title"><?= $row['productName']?></h4>
                    <div class="d-flex justify-content-between">
                        <p class="card-text"><?= $row['productCategory']?></p>
                        <p class="card-text mr-4 text-success">RM<?= $row['productPrice']?></p>
                    </div>
                    <a href="#" class="card-link modalbutton" data-bs-toggle="modal" data-bs-target="#modalproduct" data-id="<?= $row['productID']?>" data-name="<?= $row['productName']?>" data-img="<?= $row['productPicture']?>" data-desc="<?= $row['productDesc']?>" data-price="<?= $row['productPrice']?>">See Details</a>
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
                <form action="" method="post">
                    <center><img src="" id="productImg" height="200" width="200"></center>
                    <div class="form-group">
                        <label for="productName">Name:</label>
                        <input type="text" class="form-control" id="productName" readonly>
                    </div>
                    <div class="form-group">
                        <label for="productDescription">Description:</label>
                        <textarea class="form-control" id="productDescription" rows="3" readonly></textarea>
                    </div>
                    <div class="form-group">
                        <label for="productPrice">Price:</label>
                        <input type="text" class="form-control" id="productPrice" readonly>
                    </div>
                    <input type="text" class="form-control" id="productID" hidden>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-close-modal" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn buy-btn" name="buyproduct">Buy Now</button>
            </div>
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
</script>