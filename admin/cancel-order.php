<?php
include('../config/constants.php');
?>

<?php

if (isset($_GET['order_id']) and !isset($_GET['grant'])) {

    $order_id = $_GET['order_id'];

    $sql = "UPDATE tbl_order SET
            order_status = 'Cancelled'
            WHERE order_id=$order_id  
            ";
    $sql_run = mysqli_query($conn, $sql);

    $reload = "<div><h4><a href='manage-orders.php'>x</a></h4></div>";
    $_SESSION['order-msg'] = "<div class='message-success'>Success! The order has been cancelled." . $reload . "</div>";
    header('location:' . SITEURL . 'admin/manage-orders.php');
}

if (isset($_GET['order_id']) and isset($_GET['grant'])) {

    if ($_GET['grant'] == 'YES') {
        $order_id = $_GET['order_id'];

        $sql = "UPDATE tbl_order SET
            order_status = 'Cancelled',
            cancel_request = 'granted'
            WHERE order_id=$order_id  
            ";
        $sql_run = mysqli_query($conn, $sql);

        $reload = "<div><h4><a href='manage-orders.php'>x</a></h4></div>";
        $_SESSION['order-msg'] = "<div class='message-success'>Success! The order has been cancelled." . $reload . "</div>";
        header('location:' . SITEURL . 'admin/manage-orders.php');
    } elseif ($_GET['grant'] == 'NO') {

        $order_id = $_GET['order_id'];

        $sql = "UPDATE tbl_order SET
            cancel_request = 'not_granted'
            WHERE order_id=$order_id  
            ";
        $sql_run = mysqli_query($conn, $sql);

        $reload = "<div><h4><a href='manage-orders.php'>x</a></h4></div>";
        $_SESSION['order-msg'] = "<div class='message-success'>Success! Request has not been granted" . $reload . "</div>";
        header('location:' . SITEURL . 'admin/manage-orders.php');
    }
}
?>