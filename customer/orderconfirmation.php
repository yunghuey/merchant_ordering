<?php
    /*
        purpose: frontend page to make order confirmation, after user confirms, 
        then only it will add new row for order table
    */
    session_start();
    if (empty($_SESSION["username"])){
        header("location:index.php");
        exit;
    }
    require_once "../database/connect_db.php";
    $grandtotal = 7;
    $subtotal = 0;
    $product_cart = [];
    
    $ssc = "SELECT * FROM customer WHERE id =".$_SESSION['id']." LIMIT 1";
    $rssc = mysqli_query($conn,$ssc);
    $row = mysqli_fetch_assoc($rssc);
    $_SESSION['from_order'] = true;
    $cartid = $_GET['c'];
    $get_carts_sql =  "SELECT p.productName, p.productPrice, op.subtotal, op.id, op.quantity FROM `product` p LEFT JOIN `cart_product` op ON p.productID=op.productID WHERE op.cartID = ".$cartid;
    $rget_cart = mysqli_query($conn,$get_carts_sql);
    while ($rwget_cart = mysqli_fetch_assoc($rget_cart)){
        $subtotal += $rwget_cart['subtotal'];
        $product_cart[] = $rwget_cart;
    }
    $grandtotal += $subtotal; 
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Order Confirmation</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <link rel="stylesheet" href="customer_style.css">

        <!-- font awesome v5 -->
        <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>
    </head>
    <body>
        <form action="process_order.php" method="post">
        <div class="container content">
            <span class="text-start fs-3"><strong>Order Confirmation</strong></span>
            <span class="float-end">Order Total: RM<span class="fs-2"><?= number_format($grandtotal,2) ?></span></span>
        </div>
        <br>
        <div class="container info-container">
            <!-- customer details -->
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
            <!-- payment -->
            <div class="row">
                <div class="col-md-6 py-3">
                    <div class="head">
                        <span class="fs-5">Payment Option</span> 
                    </div>
                    <hr>
                    <div class="body">
                        <select class="form-select" name="paymentmethod">
                            <option value="banking">Online banking</option>
                            <option value="card">Debit card/Credit card</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 py-2">
                    <div class="head">
                        <span class="fs-5">Payment Details</span> 
                    </div>
                    <hr>
                    <div class="body">
                        <select class="form-select" name="bank">
                            <option value="Maybank">Maybank</option>
                            <option value="CIMB Group Holding">CIMB Group Holding</option>
                            <option value="Public Bank">Public Bank Berhad</option>
                            <option value="RHB Bank">RHB Bank</option>
                            <option value="Hong Leong Bank">Hong Leong Bank</option>
                            <option value="AmBank">AmBank</option>
                            <option value="UOB Malaysia">UOB Malaysia</option>
                            <option value="Bank Rakyat">Bank Rakyat</option>
                            <option value="OCBC Bank Malaysia">OCBC Bank Malaysia</option>
                            <option value="HCBC Bank Malaysia">HCBC Bank Malaysia</option>
                            <option value="Bank Islam Malaysia">Bank Islam Malaysia</option>
                            <option value="Affin Bank">Affin Bank</option>
                            <option value="Alliance Bank">Alliance Bank Malaysia Berhad</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- show product -->
        <div class="container prod-container mt-3">
            <table class="table">
                <tr>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Price/unit (RM)</th>
                    <th>Total (RM)</th>
                </tr>
                <?php foreach($product_cart as $cart): ?> 
                <tr>
                    <td><?= $cart['productName'] ?></td>
                    <td><?= $cart['quantity'] ?></td>
                    <td><?= number_format($cart['productPrice'],2) ?></td>
                    <td><?= number_format($cart['subtotal'],2) ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <!-- final price -->
        <div class="container total-container">
            <div class="head float-start"><a href="cart.php" class="btn btn-light back-btn">Back</a></div>
            <div class="tail float-end mb-4">
                <table class="amount">
                    <tr>
                        <td>Subtotal: RM</td>
                        <td><?= number_format($subtotal,2) ?></td>
                    </tr>
                    <tr>
                        <td>Shipping: RM</td>
                        <td><?= number_format(7,2) ?></td>
                    </tr>
                    <tr>
                        <td>Total: RM</td>
                        <td><?= number_format($grandtotal,2) ?></td>
                    </tr>
                    <tr>            
                        <td colspan="2"><button class="btn btn-order" type="submit" name="confirmorder">Place order and pay</button></td>
                        <input type="number" name="totalAmount" value="<?= number_format($grandtotal,2) ?>" hidden>
                        <input type="number" name="cartID" value="<?= $cartid ?>" hidden>
                        </form>
                    </tr>
                </table>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    </body>
</html>