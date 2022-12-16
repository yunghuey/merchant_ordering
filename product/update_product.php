<?php
    /*
        purpose: backend process to update the edited product data into database
    */
    require_once "../database/connect_db.php";

    $productName = $productPrice = $productCurrentQty = 
    $productCat = $productDesc = $new_img_name = $product_img_name = 
    $img_upload_path = $picture_name = "";

    function delete_ori_prod_pic($conn,$id){
        $picture_name_sql = "SELECT productPicture FROM product WHERE productID = ".$id;
        $rssp = mysqli_query($conn,$picture_name_sql);
        $rwsp = mysqli_fetch_assoc($rssp);
        $picture_name = "product_images/".$rwsp['productPicture'];
        unlink($picture_name); 
    }

    if ($_SERVER['REQUEST_METHOD'] === "POST"){
        if(isset($_POST['updateproduct'])){
            $productName = trim($_POST['productName']);
            $productPrice = trim($_POST['productPrice']);
            $productCurrentQty = trim($_POST['productCurrentQty']);
            $productCat = trim($_POST['productCat']);
            $productDesc = trim($_POST['productDesc']);
            $id =  $_POST['id'];
            $condition = "WHERE productID = ".$id;

            $update_product = "UPDATE product SET productName = '".$productName."',productPrice = '"
                                .$productPrice."', productCurrentQty = '".$productCurrentQty."',productDesc = '"
                                .$productDesc."',productCategory = '".$productCat."'";
            
            if (isset($_FILES['prod_img'])){
                delete_ori_prod_pic($conn,$id);
                $product_img_name = $_FILES['prod_img']['name'];
                $tmp_name = $_FILES['prod_img']['tmp_name'];
                $img_ex = pathinfo($product_img_name, PATHINFO_EXTENSION);
                $img_new_filename = preg_replace('/\s+/', '_', $productName);                
                $new_img_name = uniqid("", true).'_'.$img_new_filename.'.'.$img_ex;
                $img_upload_path = 'product_images/'.$new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);
                $update_product .= ",productPicture = '".$new_img_name."'";
            }
            $update_product .= $condition;

            if(mysqli_query($conn,$update_product)){
                $_SESSION['product'] = "Product ".$productName." is updated successfully";
                header("location:productlist.php");
            }
        }

        if(isset($_POST['deleteproduct'])){
            $id = $_POST['delete_id'];
            delete_ori_prod_pic($conn,$id);
            $delete_sql = "DELETE FROM product WHERE productID = ".$id;
            if (mysqli_query($conn,$delete_sql)){
                header("location:productlist.php");
            }
        }
    }
?>