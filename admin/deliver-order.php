<?php
    include('../config/constants.php');
?>

<?php

    if(isset($_GET['order_id'])){
        $order_id = $_GET['order_id'];

        $sql = "UPDATE tbl_order SET
        order_status = 'On-Delivery'
        WHERE order_id='$order_id'   
        ";
        $sql_run = mysqli_query($conn, $sql);

        $reload = "<div><h4><a href='manage-orders.php'>x</a></h4></div>";
        $_SESSION['deliver-msg']="<div class='message-success'>Success! Please deliver the order now!".$reload."</div>";
        header('location:'.SITEURL.'admin/manage-orders.php');
    }
?>