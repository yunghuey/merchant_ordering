<?php
    /*
        purpose: frontend to view sales
    */
    session_start();
    if (empty($_SESSION["username"]) || $_SESSION['role'] == "Management"){
        header("location:index.php");
        exit;
    }
    require_once "../database/connect_db.php";
?>
<!doctype html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bootstrap demo</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

        <!-- custom -->
        <link href="leftmenu.css" rel="stylesheet">
        <link rel="stylesheet" href="template_style.css">

        <!-- font awesome v5 -->
        <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>
    </head>
    <body>
        <!-- navigation -->
        <?php include("leftmenu.php"); ?>

        <div class="content">
            <header><h2>Product Sales</h2></header>
            <table class="table table-sm">
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Total sold quantity</th>
                </tr>
                <?php 
                    $get_sales_sql = "SELECT p.productPicture, p.productName, SUM(cp.quantity) AS totalqty "
                                    ."FROM `product` p "
                                    ."LEFT JOIN  `cart_product` cp ON cp.productID=p.productID "
                                    ."LEFT JOIN `order` o ON o.cartID=cp.cartID "
                                    ."WHERE o.orderStatus='delivered' "
                                    ."GROUP BY p.productName";
                    if ($rsales = mysqli_query($conn,$get_sales_sql)):
                        while($row = mysqli_fetch_assoc($rsales)):
                            $img_src = "http://localhost/merchant_ordering/product/product_images/".$row['productPicture'];
                ?>
                <tr>
                    <td><img src="<?= $img_src ?>" alt="" style="height:80px;"></td>
                    <td><?= $row['productName']?></td>
                    <td><?= $row['totalqty']?></td>
                </tr>
                <?php
                        endwhile;
                    endif;                
                ?>
            </table>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    </body>
</html>