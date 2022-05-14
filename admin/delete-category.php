<?php

    include('../config/constants.php');

    if(isset($_GET['id']) AND isset($_GET['image_name'])){

        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        if($image_name != ""){
            
            $path = "../img/category/".$image_name;
            $remove = unlink($path);

            if($remove==false){

                $_SESSION['img_remove'] = "<div class='message-failed'>Failed to remove category image.</div>";

                header('location:'.SITEURL.'admin/manage-category.php');
                die();
            }
        }

        $sql = "DELETE FROM tbl_category WHERE category_id='$id'";

        $res = mysqli_query($conn, $sql);

        if($res){
            $reload = "<div><h4><a href='manage-category.php'>x</a></h4></div>";
            $_SESSION['delete'] = "<div class='message-success'><div></div>Delete Success".$reload."</div>";
            header('location:'.SITEURL.'admin/manage-category.php');
        }
        else{
            $reload = "<div><h4><a href='manage-category.php'>x</a></h4></div>";
            $_SESSION['delete'] = "<div class='message-failed'><div></div>Delete Failed".$reload."</div>";
            header('location:'.SITEURL.'admin/manage-category.php');
        }
    }
    else{
        header('location:'.SITEURL.'admin/manage-category.php');
    }
?>