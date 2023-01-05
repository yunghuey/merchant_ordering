<?php
    /*
        purpose: frontend php to show order (orderstatus based on role) 
        
        orderStatus: paid, processing, packing, shipping, delivered
    */
    session_start();
    if (empty($_SESSION["username"])){
        header("location:index.php");
        exit;
    }
    require_once "../database/connect_db.php";
    if($_SERVER['REQUEST_METHOD'] === "POST"){
        if (isset($_POST['approve_order'])){
            $sql = "UPDATE `order` SET orderStatus='processing',orderByStaff=".$_SESSION['id'];
        }
        else if (isset($_POST['pack_order'])){
            $parcelNum = "parcel".$_POST['orderID'];
            date_default_timezone_set("Asia/Kuala_Lumpur");
            $dateTime = date("Y/m/d H:i:s");
            $sql = "UPDATE `order` "
                ."SET orderStatus='shipping',parcelNumber='$parcelNum',preparedDate='$dateTime',preparedByStaff=".$_SESSION['id'];
        }
        else if (isset($_POST['deliver_order'])){
            $sql = "UPDATE `order` SET orderStatus='delivered'";
        }
        $sql .=" WHERE orderID=".$_POST['orderID'];
        mysqli_query($conn, $sql);
        header("location:vieworder.php");
        die();
    }
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Order Record</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

        <!-- for Datatable -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

        <!-- custom -->
        <link href="leftmenu.css" rel="stylesheet">
        <link rel="stylesheet" href="template_style.css">

        <!-- font awesome v5 -->
        <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>
    </head>
    <body>
        <!-- navigation -->
        <?php 
            include("leftmenu.php"); 
        ?>
        <div class="content">
            <header><h2>Order to settle</h2></header>
            <section class="container-fluid">
            <table class="table table-hover" id="table-list" style="width:100%">
            <?php
            $_SESSION['role'] = "Admin";
                unset($rget_order);
                // header of table for each role
                echo "<thead>";
                echo "    <th>Order ID</th>";
                if ($_SESSION['role'] == "Admin"){
                    echo "<th>Order Date</th>";
                    echo "<th>Cart ID</th>";
                    echo "<th>View cart</th>";
                    echo "<th>Approve</th>";
                    $get_order_sql = "SELECT o.orderID, o.orderDate, o.cartID "
                                    ."FROM `order` o "
                                    ."WHERE o.orderStatus='paid'";
                } else if ($_SESSION['role'] == "Stock"){
                    echo "    <th>Customer Name</th>";
                    echo "    <th>Address</th>";
                    echo "    <th>Phone Number</th>";
                    echo "    <th>Cart ID</th>";
                    echo "    <th>View cart</th>";
                    echo "    <th>Packed</th>";
                    $get_order_sql = "SELECT cust.fullname, cust.shippingAddress, cust.phoneNumber, o.orderID,o.cartID "
                                    ."FROM `customer` cust "
                                    ."LEFT JOIN `cart` c ON c.customerID=cust.id "
                                    ."LEFT JOIN `order` o ON o.cartID=c.id "
                                    ."WHERE o.orderStatus='processing'";
                } else if ($_SESSION['role'] == "Courier"){
                    echo "    <th>Parcel Number</th>";
                    echo "    <th>Delivered</th>";
                    $get_order_sql = "SELECT orderID, parcelNumber "
                                    ."FROM `order` WHERE orderStatus='shipping'";
                } else if ($_SESSION['role'] == "Management"){
                    echo "    <th>Order Date</th>";
                    echo "    <th>Order by staff</th>";
                    echo "    <th>Pack by staff</th>";
                    echo "    <th>Prepared Date</th>";
                    echo "    <th>Order Status</th>";
                    echo "    <th>Parcel Number</th>";
                    $get_order_sql = "SELECT o.orderID,o.orderDate, o.preparedDate, o.orderStatus,o.parcelNumber,so.fullname AS staffOrder, sp.fullname AS staffPrepare "
                                    ."FROM `order` o "
                                    ."LEFT JOIN `staff` so ON so.id=o.orderByStaff "
                                    ."LEFT JOIN `staff` sp ON sp.id=o.preparedByStaff "
                                    ."WHERE orderStatus='delivered'";
                }
                echo "</thead>";
                if($rssp = mysqli_query($conn,$get_order_sql)):
                    while($row = mysqli_fetch_assoc($rssp)):
                        echo "<tr>"; 
                        echo "    <td>".$row['orderID']."</td>";
                        if ($_SESSION['role'] == "Admin"){
                            echo "<td>".$row['orderDate']."</td>";
                            echo "<td>".$row['cartID']."</td>";
                            echo "<td><div class='btn viewcartbtn' data-bs-toggle='modal' data-bs-target='#admin_viewcart' data-id='".$row['cartID']."'><i class='fas fa-eye fa-2x'></i></td>";
                            echo "<td><div class='btn approvebtn' data-bs-toggle='modal' data-bs-target='#admin_approve'><i class='fas fa-check-circle fa-2x'></i></div></td>";
                        } else if ($_SESSION['role'] == "Stock"){
                            echo "<td>".$row['fullname']."</td>";
                            echo "<td>".$row['shippingAddress']."</td>";
                            echo "<td>".$row['phoneNumber']."</td>";
                            echo "<td>".$row['cartID']."</td>";
                            echo "<td><div class='btn viewcartbtn' data-bs-toggle='modal' data-bs-target='#admin_viewcart' data-id='".$row['cartID']."'><i class='fas fa-eye fa-2x'></i></td>";
                            echo "<td><div class='btn packbtn' data-bs-toggle='modal' data-bs-target='#stock_pack'><i class='fas fa-check-circle fa-2x'></i></div></td>";
                        } else if ($_SESSION['role'] == "Courier"){
                            echo "<td>".$row['parcelNumber']."</td>";
                            echo "<td><div class='btn deliverbtn' data-bs-toggle='modal' data-bs-target='#courier_deliver'><i class='fas fa-check-circle fa-2x'></i></div></td>";
                        } else if ($_SESSION['role'] == "Management"){
                            echo "<td>".$row['orderDate']."</td>";
                            echo "<td>".$row['staffOrder']."</td>";
                            echo "<td>".$row['staffPrepare']."</td>";
                            echo "<td>".$row['preparedDate']."</td>";
                            echo "<td>".$row['orderStatus']."</td>";
                            echo "<td>".$row['parcelNumber']."</td>";
                        }
                        echo "</tr>";
                    endwhile;
                endif;
                ?>
            </table>
        </section>
        </div>
        
        <!-- ADMIN approve order -->
        <div class="modal fade" id="admin_approve" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Approve request</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="approve-modal-body"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <form action="" method="post">
                        <input type="text" name="orderID" id="orderID" hidden>
                        <button type="submit" class="btn btn-primary" name="approve_order">Approve</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- ADMIN view inside cart fail -->
        <div class="modal modal-lg fade" id="admin_viewcart" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">    
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">View Cart</h1>
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

        <!-- STOCK pack order -->
        <div class="modal fade" id="stock_pack" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Parcel Packed</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="stock-modal-body"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <form action="" method="post">
                        <input type="text" name="orderID" id="orderID_stock" hidden>
                        <button type="submit" class="btn btn-primary" name="pack_order">Confirm</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- COURIER deliver order -->
        <div class="modal fade" id="courier_deliver" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Parcel Delivered</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="courier-modal-body"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <form action="" method="post">
                        <input type="text" name="orderID" id="orderID_courier" hidden>
                        <button type="submit" class="btn btn-primary" name="deliver_order">Yes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    </body>
</html>
<script type="text/javascript">
    $(document).ready(function(){
        $("#table-list").on('click','.approvebtn',function(){
            var currentRow = $(this).closest("tr");
            var orderID = currentRow.find("td:eq(0)").text();
            var str = "Are you sure to approve this order "+orderID+"?";
            $("#approve-modal-body").html(str);
            $("#orderID").val(orderID);
        });
        $("#table-list").on('click','.packbtn',function(){
            var currentRow = $(this).closest("tr");
            var orderID = currentRow.find("td:eq(0)").text();
            var str = "Are you sure to confirm this order "+orderID+"?";
            $("#stock-modal-body").html(str);
            $("#orderID_stock").val(orderID);
        });

        $("#table-list").on('click','.deliverbtn',function(){
            var currentRow = $(this).closest("tr");
            var orderID = currentRow.find("td:eq(0)").text();
            var str = "Is this order "+orderID+" has been delivered?";
            $("#courier-modal-body").html(str);
            $("#orderID_courier").val(orderID);
        });
        $("#table-list").on('click','.viewcartbtn',function(){
            var cartID = $(this).data('id');
            $.ajax({
                url: 'cartitemview.php',
                type: 'post',
                data: { cartid:cartID },
                success: function(response){
                    $('#viewcart-modal-body').html(response);
                    $('#admin_viewcart').modal('show');
                }
            });
        });

        $("#table-list").DataTable();
    });
</script>