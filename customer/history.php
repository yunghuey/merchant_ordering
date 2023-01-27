<?php
    /*
        purpose: frontend php to display purchase history, no other function 
    */
    session_start();
    if (empty($_SESSION["username"])){
        header("location:index.php");
        exit;
    }
    require_once "../database/connect_db.php";
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Purchase History</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <link rel="stylesheet" href="customer_style.css">
        
        <!-- for Datatable -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

        <!-- font awesome v5 -->
        <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>
    </head>
    <body>
        <!-- navigation -->
        <?php include_once("topmenu.php"); ?>
        <section class="container m-5 p-3">
            <table class="table table-hover" id="table-list" style="width:100%" summary="">
                <thead>
                    <th style="display:none;">Order Id</th>
                    <th>Order ID</th>
                    <th>Total Amount (RM)</th>
                    <th>Order Date</th>
                    <th>Payment Method</th>
                    <th>Bank</th>
                    <th>Status</th>
                    <th>View products</th>
                </thead>
                <?php  
                    unset($rssp);
                    $ssp = "SELECT o.orderID,o.orderStatus,o.orderDate,o.paymentMethod,o.bank,"
                            ."cp.subtotal,cp.quantity,cp.productName, c.totalAmount, cp.cartID "
                            ."FROM `cart` c "
                            ."LEFT JOIN `cart_product` cp ON cp.cartID=c.id "
                            ."LEFT JOIN `order` o ON o.cartID=c.id "
                            ."WHERE c.customerID=".$_SESSION['id']
                            ." AND orderStatus != ''";
                    if($rssp = mysqli_query($conn,$ssp)):
                        while($row = mysqli_fetch_assoc($rssp)):
                ?>
                <tr> 
                    <td style="display:none;"><?php echo $row['orderID']; ?></td>
                    <td><?= $row['orderID']; ?></td>
                    <td><?= $row['totalAmount']; ?></td>
                    <td><?= $row['orderDate']; ?></td>
                    <td><?= $row['paymentMethod']; ?></td>
                    <td><?= $row['bank']; ?></td>
                    <td><?= $row['orderStatus']; ?></td>
                    <td><div class="btn viewcartbtn" data-bs-toggle='modal' data-bs-target='#admin_viewcart' data-id='<?= $row['cartID'] ?>'><i class="fas fa-eye fa-2x"></i></div></td>
                </tr>
                    <?php endwhile;?>
                <?php endif;?>
            </table>
        </section>

        <!-- ADMIN view inside cart -->
        <div class="modal modal-lg fade" id="admin_viewcart" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">    
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">View Order</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="viewcart-modal-body">
                    
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    </body>
</html>
<script type="text/javascript">
    $(document).ready(function(){
        $("#table-list").DataTable();
    });
    $("#table-list").on('click','.viewcartbtn',function(){
            var cartID = $(this).data('id');
            $.ajax({
                url: '../staff/cartitemview.php',
                type: 'post',
                data: { cartid:cartID },
                success: function(response){
                    $('#viewcart-modal-body').html(response);
                    $('#admin_viewcart').modal('show');
                }
            });
        });
</script>
