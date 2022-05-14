<?php include('config/constants.php') ?>

<?php

if (isset($_GET['id'])) {

    $id = $_GET['id'];
    $email = $_SESSION['auth_user']['email'];

    $del = "DELETE FROM tbl_order_item WHERE order_item_id = $id AND customer_email='$email'";

    $res = mysqli_query($conn, $del);

    if ($res) {
        $reload = "<div><h4><a href='cart.php'>x</a></h4></div>";
        $_SESSION['delete-on-cart'] = "<div class='message-success'><div></div>Removed Successfully." . $reload . "</div>";
        header('location:' . SITEURL . 'cart.php');
    }
}

if (isset($_GET['remove_all'])) {

    $del_all = mysqli_query($conn, "DELETE FROM tbl_order_item");
    header('location:' . SITEURL . 'cart.php');
}

?>