<?php
    /*
        purpose: frontend php modal content for order handling, related php to refer: VIEWORDER.php
    */
    require_once "../database/connect_db.php";
    $sql = "SELECT p.productPicture,p.productName,cp.quantity,cp.subtotal "
          ."FROM `product` p "
          ."LEFT JOIN `cart_product` cp ON p.productID=cp.productID "
          ."WHERE cp.cartID=".$_POST['cartid'];

    $result = mysqli_query($conn,$sql);
    $response = "<table class='table' width='100%'>"
               ."   <thead>"
               ."      <th>Product Image</th>"
               ."      <th>Order product details</th>"
               ."   </thead>";
    while($row = mysqli_fetch_array($result)){
        $img_src = "http://localhost/merchant_ordering/product/product_images/".$row['productPicture'];
        $response .= "<tr>"
                  ."    <td rowspan='4'><img  style='width: 180px; height 180px;' src='".$img_src."'></td>"
                  ."</tr>";
        $response .="<tr>"
                  ."    <td>".$row['productName']."</td>"
                  ."</tr>";
        $response .="<tr>"
                  ."    <td>Quantity: ".$row['quantity']."</td>"
                  ."</tr>";
        $response .="<tr>"
                  ."    <td>RM ".number_format($row['subtotal'],2)."</td>"
                  ."</tr>";
   }
   $response .= "</table>";
   echo $response;
   exit;
?>