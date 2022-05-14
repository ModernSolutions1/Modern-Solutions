<?php

    include('../config/constants.php');
    
    if(isset($_GET['id']) AND isset($_GET['image_name'])){

        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        if($image_name != ""){

            $path = "../img/products/".$image_name;

            $remove = unlink($path);

            if($remove==false){
                $_SESSION['product_upload'] = "<div class='message-failed'> Failed to remove.</div>";
                header('location:'.SITEURL.'admin/manage-products.php');
                die();
            }
        }

        $sql = "DELETE FROM tbl_products WHERE product_id='$id'";

        $res = mysqli_query($conn, $sql);

        if($res){
            $reload = "<div><h4><a href='manage-products.php'>x</a></h4></div>";
            $_SESSION['deletion'] = "<div class='message-success'><div></div>Product Deleted Successfully!".$reload."</div>";
            header('location:'.SITEURL.'admin/manage-products.php');
        }
        else{
            $reload = "<div><h4><a href='manage-products.php'>x</a></h4></div>";
            $_SESSION['deletion'] = "<div class='message-failed'><div></div>Product Deletion Failed.".$reload."</div>";
            header('location:'.SITEURL.'admin/manage-products.php');
        }

    }
    else{

        $_SESSION['product-delete'] = "<div class='message-failed'>Unauthorized Access".$reload."</div>";
        header('location:'.SITEURL.'admin/manage-products.php');
    }
?>