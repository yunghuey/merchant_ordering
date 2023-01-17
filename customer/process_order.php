<?php
    /*
        purpose: to create order after cart.php
    */
    session_start();
    require_once "../database/connect_db.php";

    $orderDate = $totalAmount = $paymentMethod = $bank = $orderid = "";
    $orderStatus = "paid";
    if ($_SERVER['REQUEST_METHOD'] === "POST"){
        if (isset($_POST['confirmorder'])){
            // prepare data to insert
            date_default_timezone_set("Asia/Kuala_Lumpur");
            $dateTime = date("Y/m/d H:i:s");
            $totalAmount = $_POST['totalAmount'];
            $paymentMethod = $_POST['paymentmethod'];
            $bank = $_POST['bank'];
            $cartid = $_POST['cartID'];
            $transactionID = uniqid('T');

            // new `order` row
            $create_order_sql = "INSERT INTO `order` (orderDate,cartID,paymentMethod,bank,transactionDate,transactionID,orderStatus) "
                               ."VALUES ('$dateTime','$cartid','$paymentMethod','$bank','$dateTime','$transactionID','$orderStatus')";
            mysqli_query($conn, $create_order_sql);

            // update `cart` query - with shipping fee
            $update_cart_sql = "UPDATE `cart` SET totalAmount =".$totalAmount.",hasOrder=1 "
                              ."WHERE id=".$cartid;
            mysqli_query($conn, $update_cart_sql);
         
            // deduct quantity in `product`
            $update_qty_sql = "UPDATE `product` p "
                             ."INNER JOIN `cart_product` cp ON p.productID = cp.productID "
                             ."SET p.productCurrentQty = (p.productCurrentQty-cp.quantity) "
                             ."WHERE cp.cartID =".$cartid;
            mysqli_query($conn, $update_qty_sql);
            unset($_POST['confirmorder']);
        } else{
            header("location:index.php");
            exit;
        }
    }
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Complete Order</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <link rel="stylesheet" href="customer_style.css">
        <!-- font awesome v5 -->
        <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>
    </head>
    <body>
        <!-- navigation -->
        <?php include_once("topmenu.php"); ?>
        <div class="popup">
            <i class="fas fa-check fa-4x"></i>
            <h2>Thank you</h2>
            <p>Your order has been successfully submitted. Please check the purchase history.</p>
            <a href="http://localhost/merchant_ordering/customer/index.php" class="btn btn-light">Home</a>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    </body>
</html>