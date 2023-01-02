<?php
    /*
        purpose: frontend page to view customer cart
        have the function to delete product in cart(delete in db too), add quantity needed(update in db too), minimum number is 1
    */
    session_start();
    if (empty($_SESSION["username"])){
        header("location:index.php");
        exit;
    }
    require_once "../database/connect_db.php";
    $total = $productid = $quantity = $cart_sql = "";
    $custid = $_SESSION['id'];   
    $view_cart_sql = "SELECT p.productName, p.productPrice, p.productPicture, p.productCurrentQty, op.orderedProductID, op.quantity FROM product p LEFT JOIN ordered_product op ON p.productID=op.productID WHERE op.customerID =".$custid." AND op.hasOrder = 0";
    $rscart = mysqli_query($conn,$view_cart_sql);

    if($_SERVER['REQUEST_METHOD'] === "POST"){
        if (isset($_POST['deletecart'])){
            $orderedProductID = $_POST['orderedProductID'];
            $delete_cart_sql = "DELETE FROM `ordered_product` WHERE orderedProductID = ".$orderedProductID."";
            mysqli_query($conn,$delete_cart_sql);
            echo "<script>alert('Cart item is deleted'); window.location.href='cart.php'; </script>";
            die();
        } else{
            $update_cart_sql = "UPDATE `ordered_product` SET quantity=".$_POST['quantity']." WHERE orderedProductID=".$_POST['orderedProductID'];
            mysqli_query($conn,$update_cart_sql);
        }
    }
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Cart</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <link rel="stylesheet" href="customer_style.css">

        <!-- font awesome v5 -->
        <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>
        
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <style>
            input[type="number"]{
                text-align: center;
                border:none;
                background-color: #ffffff;
            }

            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button{
                -webkit-appearance:none;
                margin: 0;
            }
        </style>

        <script>
            function stepper(btn,cart_id){
                let input_quantity_element = "";
                input_quantity_element = document.getElementById("prodqty-"+cart_id);
                // to know which button
                let id = btn.getAttribute("id");
                var min = input_quantity_element.getAttribute("min");
                var max = input_quantity_element.getAttribute("max");
                var step = input_quantity_element.getAttribute("step");

                // user's order
                var qty = input_quantity_element.getAttribute("value");
                // available quantity from database
                let availQty = document.getElementById("productCurrentQty").value;
                
                let calcStep = (id == "increment") ? (step * 1): (step * -1);
                var newValue = parseInt(qty) + calcStep;
                
                if (newValue >= min && newValue <= max){
                    input_quantity_element.setAttribute("value",newValue);
                    save_to_db(cart_id,newValue);
                }

                if (newValue <= 1) document.getElementById("decrement").disabled = true;
                else               document.getElementById("decrement").disabled = false;

                if (newValue >= availQty)  document.getElementById("increment").disabled = true;
                else                       document.getElementById("increment").disabled = false;

            }   

            function save_to_db(cart_id,newValue){
                $.ajax({
                url: "cart.php",
                data: "orderedProductID="+cart_id+"&quantity="+newValue,
                type: 'post',
                success: function(response){
                    $(input_quantity_element).val(newValue);
                }
                });
            }            
        </script>
    </head>
    <body>
        <!-- navigation -->
        <?php include("topmenu.php"); ?>

    <div class="container mt-5 mb-5">
            <div class="d-flex justify-content-center row">
                <div class="col-md-8">
                    <div class="p-2">
                        <h3>Shopping cart</h3>
                    </div>

                    <?php 
                        while($row = mysqli_fetch_assoc($rscart)): 
                    ?>
                    <div class="d-flex justify-content-between align-items-center p-2 bg-white mt-4 px-3 rounded">
                        <!-- product image -->
                        <div class="mr-1"><img class="rounded" src="http://localhost/merchant_ordering/product/product_images/<?= $row['productPicture']?>" width="70"></div>
                        <!-- product name -->
                        <div class="d-flex flex-column align-items-center product-details">
                            <span class="font-weight-bold"><?= $row['productName']?></span>
                        </div>
                        <!-- product qty -->
                        <div class="d-flex flex-row align-items-center stepper">
                            <button class="btn" id="decrement" onclick="stepper(this,<?= $row['orderedProductID'] ?>)"><i class="fa fa-minus text-danger"></i></button>
                            <p><h5 class="text-grey mt-1 mr-1 ml-1"><input type="number" class="form-control" value="<?= $row['quantity']?>" id="prodqty-<?= $row['orderedProductID'] ?>" min="1" max="1000" step="1" readonly></h5></p>
                            <button class="btn" id="increment" onclick="stepper(this,<?= $row['orderedProductID'] ?>)"><i class="fa fa-plus text-success"></i></button>
                        </div>
                            <!-- current quantity available in database -->
                            <input type="number" id="productCurrentQty" value="<?= $row['productCurrentQty']?>" hidden>
                        <!-- product price -->
                        <div><h5 class="text-grey"><?= $row['productPrice']?></h5></div>
                        <form action="" method="post">
                            <input type="text" name="orderedProductID" id="" value="<?= $row['orderedProductID']?>" hidden>
                            <div class="d-flex align-items-center"><button type="submit" class="btn" name="deletecart"><i class="fa fa-trash mb-1 text-danger"></i></button></div>
                        </form>
                    </div>
                    <?php endwhile; ?>
                    <div class="d-flex flex-row align-items-center mt-3 p-2 bg-white rounded"><button class="btn btn-dark btn-lg ml-2 pay-button" type="submit">Proceed to Pay</button></div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    </body>
</html>