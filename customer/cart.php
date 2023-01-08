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
    $rscart = $cartid = "";
    // check if got existing cartid that can use
    $check_cartid_sql = "SELECT id FROM `cart` WHERE hasOrder=0 AND customerID=".$_SESSION['id']." LIMIT 1";
    $rcartid = mysqli_query($conn,$check_cartid_sql);
    if ($rwcartid = mysqli_fetch_assoc($rcartid)){
        $cartid = $rwcartid['id'];
        $view_cart_sql = "SELECT p.productName, p.productPrice, p.productPicture, p.productCurrentQty, op.id, op.quantity FROM `product` p LEFT JOIN `cart_product` op ON p.productID=op.productID WHERE op.cartID=".$cartid;
        $rscart = mysqli_query($conn,$view_cart_sql);
    }
  
    if($_SERVER['REQUEST_METHOD'] === "POST"){
        if (isset($_POST['deletecart'])){
            $id = $_POST['id'];
            $delete_cart_sql = "DELETE FROM `cart_product` WHERE id = ".$id."";
            mysqli_query($conn,$delete_cart_sql);
            die();
        } else if (isset($_POST['updatecart'])){
            $update_cart_sql = "UPDATE `cart_product` SET quantity=".$_POST['quantity'].",subtotal=".($_POST['quantity']*$_POST['price'])." WHERE id=".$_POST['id'];        
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

        <!-- jquery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <!-- sweet alert -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <script>
            function stepper(btn,cart_id){
                var input_quantity_element = document.getElementById("prodqty-"+cart_id);
                var id = btn.getAttribute("id");
                var min = input_quantity_element.getAttribute("min");
                var max = input_quantity_element.getAttribute("max");
                var step = input_quantity_element.getAttribute("step");
                var productPrice = document.getElementById("price").value;
                var qty = input_quantity_element.getAttribute("value");
                let availQty = document.getElementById("productCurrentQty").value;
                let calcStep = (id == "increment") ? (step * 1): (step * -1);
                var newValue = parseInt(qty) + calcStep;
                
                if (newValue >= min && newValue <= max){
                    input_quantity_element.setAttribute("value",newValue);
                    save_to_db(cart_id,newValue,productPrice);
                }

                if (newValue <= 1) document.getElementById("decrement").disabled = true;
                else               document.getElementById("decrement").disabled = false;

                if (newValue >= availQty)  document.getElementById("increment").disabled = true;
                else                       document.getElementById("increment").disabled = false;
            }   

            function save_to_db(cart_id,newValue,productPrice){
                $.ajax({
                url: "cart.php",
                data: "id="+cart_id+"&quantity="+newValue+"&price="+productPrice+"&updatecart=1",
                type: 'post',
                success: function(response){}
                });
            }
            function delete_cart_db(cart_id){
                $.ajax({
                url: "cart.php",
                data: "id="+cart_id+"&deletecart=1",
                type: 'post',
                success: function(response){
                    swal({
                        title: "Deleted",
                        text: "Item has been removed from cart",
                        type: "success",
                    }).then(function(){ location.reload(); });
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
                        if(!empty($rscart)):
                        while($row = mysqli_fetch_assoc($rscart)): 
                    ?>
                    <div class="d-flex justify-content-between align-items-center p-2 bg-white mt-4 px-3 rounded">
                        <div class="mr-1"><img class="rounded" src="http://localhost/merchant_ordering/product/product_images/<?= $row['productPicture']?>" width="70"></div>
                        <div class="d-flex flex-column align-items-center product-details">
                            <span class="font-weight-bold"><?= $row['productName']?></span>
                        </div>
                        <div class="d-flex flex-row align-items-center stepper">
                            <button class="btn" id="decrement" onclick="stepper(this,<?= $row['id'] ?>)"><i class="fa fa-minus text-danger"></i></button>
                            <p><h5 class="text-grey mt-1 mr-1 ml-1"><input type="number" class="form-control" value="<?= $row['quantity']?>" id="prodqty-<?= $row['id'] ?>" min="1" max="1000" step="1" readonly></h5></p>
                            <button class="btn" id="increment" onclick="stepper(this,<?= $row['id'] ?>)"><i class="fa fa-plus text-success"></i></button>
                        </div>
                            <input type="number" id="productCurrentQty" value="<?= $row['productCurrentQty']?>" hidden>
                        <div><h5 class="text-grey">RM<?= number_format($row['productPrice'],2)?></h5></div>
                        <input type="text" id="price" value="<?= number_format($row['productPrice'],2)?>" hidden>
                            <div class="d-flex align-items-center"><button class="btn" onclick="delete_cart_db(<?= $row['id']?>)"><i class="fa fa-trash mb-1 text-danger"></i></button></div>
                    </div>
                    <?php endwhile; ?>
                    <div class="d-flex flex-row align-items-center mt-3 p-2 bg-white rounded"><a href="orderconfirmation.php?c=<?= $cartid?>" class="btn btn-outline-success">Checkout</a></div>
                    </form>
                    <?php else: ?>
                    <div class="alert alert-success text-dark"><h3>Oops, your shopping cart is empty</h3></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    </body>
</html>