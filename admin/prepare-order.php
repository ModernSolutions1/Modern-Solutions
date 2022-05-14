<?php
    include('../config/constants.php');
?>

<?php

    if(isset($_GET['order_id'])){
        $order_id = $_GET['order_id'];
        $d = strtotime("tomorrow");
        $x = date('Y-m-d');

        $sql = "UPDATE tbl_order SET
        order_status = 'Preparing'
        WHERE order_id=$order_id  
        ";
        $sql_run = mysqli_query($conn, $sql);

        $reload = "<div><h4><a href='manage-orders.php'>x</a></h4></div>";
        $_SESSION['order-msg']="<div class='message-success'>Success! Please prepare the order now.".$reload."</div>";
        header('location:'.SITEURL.'admin/manage-orders.php');
    }
?>