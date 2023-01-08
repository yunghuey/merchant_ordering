<?php
    /*
        purpose: to generate barchart report
        get duration from user and create data based on it
    */
    require_once "../database/connect_db.php";

    function rndRGBColorCode()
    {
        return 'rgb(' . rand(0, 255) . ',' . rand(0, 255) . ',' . rand(0, 255) . ')'; #using the inbuilt random function
    }

    $startdate = $enddate = '';
    $productname = $sales =  $bgcolor = [];
    $date = $parcelNum = $bgcolor_parcel = [];
    $productname_sales = $subtotal = [];
    $get_sales_sql = "SELECT p.productName AS `first`, SUM(cp.quantity) AS `second` "
                    ."FROM `product` p "
                    ."LEFT JOIN  `cart_product` cp ON cp.productID=p.productID "
                    ."LEFT JOIN `order` o ON o.cartID=cp.cartID ";
    $get_parcel_sql = "SELECT CAST(orderDate AS DATE) AS `first`, COUNT(orderID) AS `second` "
                     ."FROM `order` "
                     ."WHERE orderStatus='delivered' ";
    $get_amount_sql = "SELECT CAST(o.orderDate AS DATE) AS purchaseDate, SUM(cp.subtotal) AS subtotal "
                     ."FROM `product` p "
                     ."LEFT JOIN `cart_product` cp ON cp.productID=p.productID "
                     ."LEFT JOIN `order` o ON o.cartID=cp.cartID ";


    if ($_SERVER['REQUEST_METHOD'] === "POST"){
        $startdate = $_POST['fromdate'];
        $enddate = $_POST['todate'];
        if(isset($_POST['get_date'])){
            $get_sales_sql .= "WHERE o.orderDate BETWEEN '".$startdate." 00:00:00' AND '".$enddate." 23:59:59' ";
            $get_amount_sql .= "WHERE o.orderDate BETWEEN '".$startdate." 00:00:00' AND '".$enddate." 23:59:59' ";
        } else if(isset($_POST['get_parcel'])){
            $get_parcel_sql .= "AND orderDate BETWEEN '".$startdate." 00:00:00' AND '".$enddate." 23:59:59' ";
        }
        unset($_POST['get_date']);
    }
    $get_sales_sql .= "GROUP BY p.productName";
    $get_parcel_sql .= "GROUP BY CAST(orderDate AS DATE)";
    $get_amount_sql .="GROUP BY purchaseDate ";

    // echo $get_amount_sql;
    if($rget = mysqli_query($conn,$get_sales_sql)){
        $rownum = mysqli_num_rows($rget);
        while($row = mysqli_fetch_assoc($rget)){
            $productname[] = $row['first'];
            $sales[] = $row['second'];
        }
        // background color: 
        for($i = 0; $i < $rownum; $i++){
            $bgcolor[] = rndRGBColorCode();
        }
    }

    if($rget = mysqli_query($conn,$get_parcel_sql)){
        $rownum = mysqli_num_rows($rget);
        while($row = mysqli_fetch_assoc($rget)){
            $date[] = $row['first'];
            $parcelNum[] = $row['second'];
        }
        // background color: 
        for($i = 0; $i < $rownum; $i++){
            $bgcolor_parcel[] = rndRGBColorCode();
        }
    }

    if($rget = mysqli_query($conn,$get_amount_sql)){
        while($row = mysqli_fetch_assoc($rget)){
            $productname_sales[] = $row['purchaseDate'];
            $subtotal[] = $row['subtotal'];
        }
    }
?>