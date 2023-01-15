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

    $overall_startdate = $overall_enddate = '';
    $productname = $sales =  $bgcolor = [];
    $date = $parcelNum = $bgcolor_parcel = [];
    $productname_sales = $subtotal = [];
    $top_productname = $top_qty = $last_productname = $last_qty = $rank_bgcolor = [];
    $product_category = $ranking_startdate = $product_ranking_enddate = '';
    $year_ringgit = $year_month = $bgcolor_year =[];
    date_default_timezone_set("Asia/Kuala_Lumpur");
    $year_end = date("Y/m/d");
    $year_start = date("Y/m/d",strtotime("-1 year", strtotime($year_end)));
    $totalstaff = 0;
    $role_list = $gender_label = $gender_list = $gender_bgcolor = $role_label = $role_data = $role_bgcolor = [];
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
    $get_category_last = "SELECT p.productName, SUM(cp.quantity) AS qty "
                        ."FROM `product` p "
                        ."LEFT JOIN `cart_product` cp ON cp.productID = p.productID "
                        ."GROUP BY p.productName "
                        ."ORDER BY SUM(cp.quantity) "
                        ."LIMIT 4";
    $get_category_top = "SELECT p.productName, SUM(cp.quantity) AS qty "
                       ."FROM `product` p "
                       ."LEFT JOIN `cart_product` cp ON cp.productID = p.productID "
                       ."GROUP BY p.productName HAVING SUM(cp.quantity) > 0 "
                       ."ORDER BY SUM(cp.quantity) desc "
                       ."LIMIT 4";    
    $get_year_sales = "SELECT DATE_FORMAT(orderDate, '%M %Y') AS month_name, SUM(cp.subtotal) AS ringgit "
                     ."FROM `order` o "
                     ."LEFT JOIN `cart_product` cp ON cp.cartID=o.cartID "
                     ."WHERE o.orderDate BETWEEN '".$year_start." 00:00:00' AND '".$year_end." 23:59:59' "
                     ."GROUP BY month_name "
                     ."ORDER BY year(orderDate),month(orderDate)";

    $get_staff_total = "SELECT COUNT(id) AS total FROM staff;";
    $get_dept_list = "SELECT DISTINCT role FROM `staff` WHERE 1;";
    $get_gender_list = "SELECT DISTINCT gender, COUNT(id) as total FROM `staff` GROUP BY gender;";
    $get_dept_staff = "SELECT role, COUNT(id) AS total FROM `staff` GROUP BY role;";
    if ($_SERVER['REQUEST_METHOD'] === "POST"){
        if(isset($_POST['get_date'])){
            $overall_startdate = $_POST['fromdate'];
            $overall_enddate = $_POST['todate'];
            $get_sales_sql .= "WHERE o.orderDate BETWEEN '".$overall_startdate." 00:00:00' AND '".$overall_enddate." 23:59:59' ";
            $get_amount_sql .= "WHERE o.orderDate BETWEEN '".$overall_startdate." 00:00:00' AND '".$overall_enddate." 23:59:59' ";
        } else if(isset($_POST['get_parcel'])){
            $overall_startdate = $_POST['fromdate'];
            $overall_enddate = $_POST['todate'];
            $get_parcel_sql .= "AND orderDate BETWEEN '".$overall_startdate." 00:00:00' AND '".$overall_enddate." 23:59:59' ";
        }
        if(isset($_POST['get_ranking'])){
            $product_category = $_POST['category'];
            $get_category_top = $get_category_last = 
                "SELECT p.productName, SUM(cp.quantity) AS qty "
                ."FROM `product` p "
                ."LEFT JOIN `cart_product` cp ON cp.productID = p.productID "
                ."LEFT JOIN `order`o ON o.cartID=cp.cartID ";
            
            if(!empty($product_category)){
                $get_category_last .= "WHERE p.productCategory='".$product_category."' ";
                $get_category_top .= "WHERE p.productCategory='".$product_category."' ";
            }

            if (!empty($_POST['todate_rank'])){
                $ranking_startdate = $_POST['fromdate_rank'];
                $ranking_enddate = $_POST['todate_rank'];
                // check if got other condition
                if(strpos($get_category_last,"WHERE")){
                    $get_category_top .= "AND ";
                    $get_category_last .="AND ";
                } else{
                    $get_category_top .= "WHERE ";
                    $get_category_last .="WHERE ";
                }
                $get_category_top .= " (o.orderDate BETWEEN '".$ranking_startdate." 00:00:00' AND '".$ranking_enddate." 23:59:59') ";
                $get_category_last .=" (o.orderDate BETWEEN '".$ranking_startdate." 00:00:00' AND '".$ranking_enddate." 23:59:59') ";
            }
            $get_category_top .= "GROUP BY p.productName HAVING SUM(cp.quantity) > 0 "
                        ."ORDER BY SUM(cp.quantity) desc "
                        ."LIMIT 4";
            $get_category_last .= "GROUP BY p.productName "
                                 ."ORDER BY SUM(cp.quantity) "
                                 ."LIMIT 4";       
        }
        // unset($_POST['get_date']);
        // unset($_POST['get_ranking']);
    }
    $get_sales_sql .= "GROUP BY p.productName";
    $get_parcel_sql .= "GROUP BY CAST(orderDate AS DATE)";
    $get_amount_sql .="GROUP BY purchaseDate ";

    if($rget = mysqli_query($conn,$get_sales_sql)){
        $rownum = mysqli_num_rows($rget);
        while($row = mysqli_fetch_assoc($rget)){
            $productname[] = $row['first'];
            $sales[] = $row['second'];
        }
        for($i = 0; $i < $rownum; $i++)
            $bgcolor[] = rndRGBColorCode();
    }

    if($rget = mysqli_query($conn,$get_parcel_sql)){
        $rownum = mysqli_num_rows($rget);
        while($row = mysqli_fetch_assoc($rget)){
            $date[] = $row['first'];
            $parcelNum[] = $row['second'];
        }
        for($i = 0; $i < $rownum; $i++)
            $bgcolor_parcel[] = rndRGBColorCode();
    }

    if($rget = mysqli_query($conn,$get_amount_sql)){
        while($row = mysqli_fetch_assoc($rget)){
            $productname_sales[] = $row['purchaseDate'];
            $subtotal[] = $row['subtotal'];
        }
    }
    // echo $get_category_top;
    if($rget = mysqli_query($conn,$get_category_top)){
        $rownum = mysqli_num_rows($rget);
        while($row = mysqli_fetch_assoc($rget)){
            $top_productname[] = $row['productName'];
            $top_qty[] = $row['qty'];
        }
        for($i = 0; $i < $rownum; $i++)
            $rank_bgcolor[] = rndRGBColorCode();
    }

    if($rget = mysqli_query($conn,$get_category_last)){
        $rownum = mysqli_num_rows($rget);
        while($row = mysqli_fetch_assoc($rget)){
            $last_productname[] = $row['productName'];
            $last_qty[] = $row['qty'];
        }
    }

    if($rget = mysqli_query($conn,$get_year_sales)){
        $rownum = mysqli_num_rows($rget);
        while($row = mysqli_fetch_assoc($rget)){
            $year_month[] = $row['month_name'];
            $year_ringgit[] = $row['ringgit'];
        }
        for($i = 0; $i < $rownum; $i++)
            $bgcolor_year[] = rndRGBColorCode();
    } 
    
    if($rget = mysqli_query($conn,$get_staff_total)){
        $row = mysqli_fetch_assoc($rget);
        $totalstaff = $row['total'];
    }

    if($rget = mysqli_query($conn,$get_dept_list)){
        while($row = mysqli_fetch_assoc($rget)){
            $role_list[] = $row['role'];
        }
    }

    if($rget = mysqli_query($conn,$get_gender_list)){
        while($row = mysqli_fetch_assoc($rget)){
            $gender_label[] = $row['gender'];
            $gender_list[] = $row['total'];
        }
        for($i = 0; $i < 2; $i++)
            $gender_bgcolor[] = rndRGBColorCode();
    }

    if($rget = mysqli_query($conn,$get_dept_staff)){
        $rownum = mysqli_num_rows($rget);
        while($row = mysqli_fetch_assoc($rget)){
            $role_label[] = $row['role'];
            $role_data[] = $row['total'];
        }
        for($i = 0; $i < $rownum; $i++)
            $role_bgcolor[] = rndRGBColorCode();
    }
?>