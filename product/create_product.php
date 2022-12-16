<?php
    /*
        purpose: backend php to create new row in database product, including validation
    */
    require_once "../database/connect_db.php";
    $productName = $productPrice = $productCurrentQty = $productCat = 
    $productDesc = $new_img_name = $product_img_name = $img_upload_path = ""; 
    $error = [];

    if($_SERVER['REQUEST_METHOD'] === "POST"){
        if(isset($_POST['createprod'])){
            $productName = trim($_POST['productName']);
            $productPrice = trim($_POST['productPrice']);
            $productCurrentQty = $_POST['productCurrentQty'];
            $productCat = $_POST['prodCat'];
            $productDesc = $_POST['productDesc'];
            $product_img_name = $_FILES['prod_img']['name'];
            $tmp_name = $_FILES['prod_img']['tmp_name'];
            $img_ex = pathinfo($product_img_name, PATHINFO_EXTENSION);
            // create new name
            $img_new_filename = preg_replace('/\s+/', '_', $productName);                
            $new_img_name = uniqid("", true).'_'.$img_new_filename.'.'.$img_ex;
            $img_upload_path = 'product_images/'.$new_img_name;
            // keep into file
            move_uploaded_file($tmp_name, $img_upload_path);
                
            $insertSQL = "INSERT INTO product (productName,productPrice,productCurrentQty,productDesc,productCategory,productPicture) VALUES ('$productName','$productPrice','$productCurrentQty','$productDesc','$productCat','$new_img_name')";
            if (mysqli_query($conn,$insertSQL)){
                $_SESSION['message'] = "Product ".$productName." is added successfully";
                header("location:../staff/index.php");
            }            
        }
    }
?>