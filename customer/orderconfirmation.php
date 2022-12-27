<?php
    /*
        purpose: frontend page to make order confirmation, after user confirms, 
        then only it will add new row for order table
    */
    session_start();
    require_once "../database/connect_db.php";
    $total = $productid = $quantity = "";
    define("shipping", 7);
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if (isset($_POST['makeorder'])){
            // get data to display
            $productName = $_POST['productName'];
            $quantity = $_POST['productCurrentQty'];
            $price = $_POST['productPrice'];
            $productid = $_POST['productID'];
            $subtotal = $price * $quantity;
            $total = $subtotal + shipping;
        }
        
        if (isset($_POST['confirmorder'])){
            // create order in database
            // to display: orderID, thank you, direct to home (create check order)
            // orderStatus: created, processing, packing, shipping, delivered
            $date = date('d-m-y');
            $custid = $_SESSION['id'];
            // create order in order
            $total = $_POST['order_total'];
            $productid = $_POST['order_productid'];
            $quantity = $_POST['order_qty'];
            // $create_order_sql = "INSERT INTO `order` (orderDate,totalAmount,orderStatus,customerID,productID,orderQty) VALUES ('$date','$total','created','$custid','$productid','$quantity')";
            echo $create_order_sql;
            mysqli_query($conn,$create_order_sql);

            // update quantity in product
            $update_sql = "SELECT productCurrentQty FROM product WHERE productID =".$productid;
            if($result = mysqli_query($conn,$update_sql)){
                $row = mysqli_fetch_assoc($result);
                $leftqty = $row['productCurrentQty'];
                $leftqty -= $quantity;
                $update_sql2 = "UPDATE product SET productCurrentQty = '".$leftqty."' WHERE productID =".$productid;
                mysqli_query($conn, $update_sql2);
            }

            // get orderID in order
            if($result = mysqli_query($conn, "SELECT orderID FROM order ORDER BY desc LIMIT 1")){
                $row = mysqli_fetch_assoc($result);
                $_SESSION['neworderid'] = $row['orderID'];
                $_SESSION['message'] = "order created";
                header("location:index.php");
            }

        } 
    }

    // get customer details
    $ssc = "SELECT * FROM customer WHERE id =".$_SESSION['id'];
    $rssc = mysqli_query($conn,$ssc);
    $row = mysqli_fetch_assoc($rssc);
    $_SESSION['from_order'] = true;
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Order Confirmation</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    
        <!-- font awesome v5 -->
        <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>

        <!-- custom css -->
        <link rel="stylesheet" href="customer_style.css">
    </head>
    <body>
        <div class="container content">
            <span class="text-start fs-3"><strong>Order Confirmation</strong></span>
            <span class="float-end">Order Total: RM<span class="fs-2"><?= number_format($total,2) ?></span></span>
    
        </div>
        <br>

        <div class="container info-container">
            <div class="row">
                <div class="col-md-6 py-2">
                    <div class="head">
                        <span class="fs-5">Your Information</span> 
                        <a href="editprofile.php" class="float-end">Edit</a>
                    </div>
                    <hr>
                    <div class="body">
                        <p class="fs-4"><?= $row['fullname']?></p>
                        <p class="fs-6"><?= $row['email']?></p>
                    </div>
                </div>
                <div class="col-md-6 py-2">
                    <div class="head">
                        <span class="fs-5">Shipping Address</span> 
                        <a href="editprofile.php" class="float-end">Edit</a>
                    </div>
                    <hr>
                    <div class="body">
                        <p class="fs-6"><?= $row['shippingAddress']?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="container prod-container mt-3">
            <table class="table">
                <tr>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Price/unit (RM)</th>
                </tr>
                <tr>
                    <td id="prodName"><?= $productName ?></td>
                    <td><?= $quantity ?></td>
                    <td><?= $price ?></td>
                </tr>
            </table>
        </div>

        <form action="" method="post">
        <input type="text" name="order_productid" value="<?= $productid ?>" hidden>
        <input type="text" name="order_qty" value="<?= $quantity ?>" hidden>
        <input type="text" name="order_total" value="<?= number_format($total,2) ?>" hidden>

        <div class="container total-container">
            <div class="head float-start">
                <a href="product_display.php" class="btn btn-light back-btn">Back</a>

            </div>
            <div class="tail float-end">
                <table class="amount">
                    <tr>
                        <td>Subtotal: RM   </td>
                        <td><?= number_format($subtotal,2) ?></td>
                    </tr>
                    <tr>
                        <td>Shipping: RM   </td>
                        <td><?= number_format(shipping,2) ?></td>
                    </tr>
                    <tr>
                        <td>Total: RM   </td>
                        <td><?= number_format($total,2) ?></td>
                    </tr>
                    <tr>            
                        <td><button class="btn btn-order" type="submit" name="confirmorder">Place order</button></td>
                        </form>
                    </tr>
                </table>

            </div>
        </div>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    </body>
</html>