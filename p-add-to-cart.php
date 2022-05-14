<?php include('front-partials/header.php');

?>

<?php

if (isset($_POST['submit-btn']) and isset($_SESSION['authenticated'])) {

    $p_id = $_POST['product_id'];
    $p_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $p_img = $_POST['product_image'];
    $p_price = $_POST['product_price'];
    $product_qty = 1;
    $email = $_SESSION['auth_user']['email'];

    // check if product already exists

    $mysql_check = "SELECT * FROM tbl_order_item WHERE order_item_name='$p_name' AND customer_email='$email'";
    $mysql_exe = mysqli_query($conn, $mysql_check);
    $counter = mysqli_num_rows($mysql_exe);


    if ($counter > 0) {

        // if exists
        $reload = "<div><h4><a href='products.php'>x</a></h4></div>";
        $_SESSION['already-on-cart'] = "<div class='message-failed'><div></div>Product already added to cart." . $reload . "</div>";
        header('location:' . SITEURL . 'products.php');
    } else {

        // if not exists

        // get and store data

        $insert_sql = "INSERT INTO tbl_order_item SET
                order_item_name = '$p_name',
                order_item_img = '$p_img',
                order_item_price = $p_price,
                item_qty = $product_qty,
                customer_email = '$email'
            ";
        $insert_exe = mysqli_query($conn, $insert_sql);

        if ($insert_exe) {
            $reload = "<div><h4><a href='products.php'>x</a></h4></div>";
            $_SESSION['add-on-cart'] = "<div class='message-success'><div></div>Added successfully!" . $reload . "</div>";
            $_SESSION['p-counter'] = $counter;
            header('location:' . SITEURL . 'products.php');
        } else {
            $reload = "<div><h4><a href='products.php'>x</a></h4></div>";
            $_SESSION['add-on-cart'] = "<div class='message-failed'>Failed" . $reload . "</div>";
            $_SESSION['p-counter'] = $counter;
            header('location:' . SITEURL . 'products.php');
        }
    }
}else{
    header('location:'.SITEURL.'login.php');
}
?>

<?php

if (isset($_POST['p_add']) and isset($_SESSION['authenticated'])) {

    $p_id = $_POST['p_id'];

    $sql = "SELECT * FROM tbl_products WHERE product_id = $p_id";
    $res = mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($res);
    $email = $_SESSION['auth_user']['email'];

    if (mysqli_num_rows($res) > 0) {

        $image_name = $result['product_img'];
        $p_name = mysqli_real_escape_string($conn, $result['product_name']);
        $p_price = $result['product_price'];
        $p_categ_name = mysqli_real_escape_string($conn, $_POST['p_categ_name']);
        $sql2 = "SELECT * FROM tbl_order_item WHERE order_item_name='$p_name' AND customer_email='$email'";
        $res2 = mysqli_query($conn, $sql2);
        $count = mysqli_num_rows($res2);

        if ($count > 0) {

                $reload = "<div><h4><a href='all-products.php'>x</a></h4></div>";
                $_SESSION['add-on-cart'] = "<div class='message-failed'><div></div>Product already added to cart" . $reload . "</div>";
                header('location:' . SITEURL . 'all-products.php');
        } else {

            $sql3 = "INSERT INTO tbl_order_item SET
                    order_item_img = '$image_name',
                    order_item_name = '$p_name',
                    order_item_price = $p_price,
                    customer_email = '$email',
                    item_qty = 1
                ";

            $res3 = mysqli_query($conn, $sql3);
                $reload = "<div><h4><a href='all-products.php'>x</a></h4></div>";
                $_SESSION['add-on-cart'] = "<div class='message-success'><div></div>Product Added Successfully!" . $reload . "</div>";
                header('location:' . SITEURL . 'all-products.php');
            
        }
    }
}
?>

<?php

if (isset($_POST['p_add2']) and isset($_SESSION['authenticated'])) {

    $p_id = $_POST['p_id'];

    $sql = "SELECT * FROM tbl_products WHERE product_id = $p_id";
    $res = mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($res);
    $email = $_SESSION['auth_user']['email'];

    if (mysqli_num_rows($res) > 0) {

        $image_name = $result['product_img'];
        $p_name = mysqli_real_escape_string($conn, $result['product_name']);
        $p_price = $result['product_price'];
        $p_categ_name =  mysqli_real_escape_string($conn, $_POST['p_categ_name']);
        $sql2 = "SELECT * FROM tbl_order_item WHERE order_item_name='$p_name' AND customer_email='$email'";
        $res2 = mysqli_query($conn, $sql2);
        $count = mysqli_num_rows($res2);

        if ($count > 0) {
            $reload = "<div><h4><a href='categories.php'>x</a></h4></div>";
            $_SESSION['add-on-cart'] = "<div class='message-failed'><div></div>Product already added to cart" . $reload . "</div>";
            header('location:' . SITEURL . 'categories.php');
        } else {

            $sql3 = "INSERT INTO tbl_order_item SET
                    order_item_img = '$image_name',
                    order_item_name = '$p_name',
                    order_item_price = $p_price,
                    customer_email = '$email',
                    item_qty = 1
                ";

            $res3 = mysqli_query($conn, $sql3);

            if ($res3) {
                $reload = "<div><h4><a href='categories.php'>x</a></h4></div>";
                $_SESSION['add-on-cart'] = "<div class='message-success'><div></div>Added to Cart!" . $reload . "</div>";
                header('location:' . SITEURL . 'categories.php');
            }
        }
    }
}
?>

<?php

if (isset($_POST['p_add3']) and isset($_SESSION['authenticated'])) {

    $p_id = $_POST['p_id'];

    $sql = "SELECT * FROM tbl_products WHERE product_id = $p_id";
    $res = mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($res);
    $email = $_SESSION['auth_user']['email'];

    if (mysqli_num_rows($res) > 0) {

        $image_name = $result['product_img'];
        $p_name = mysqli_real_escape_string($conn, $result['product_name']);
        $p_price = $result['product_price'];
        $p_categ_name = mysqli_real_escape_string($conn, $_POST['p_categ_name']);
        $sql2 = "SELECT * FROM tbl_order_item WHERE order_item_name='$p_name' AND customer_email='$email'";
        $res2 = mysqli_query($conn, $sql2);
        $count = mysqli_num_rows($res2);

        if ($count > 0) {

                $reload = "<div><h4><a href='featured-products.php'>x</a></h4></div>";
                $_SESSION['add-on-cart'] = "<div class='message-failed'><div></div>Product already added to cart" . $reload . "</div>";
                header('location:' . SITEURL . 'featured-products.php');
        } else {

            $sql3 = "INSERT INTO tbl_order_item SET
                    order_item_img = '$image_name',
                    order_item_name = '$p_name',
                    order_item_price = $p_price,
                    customer_email = '$email',
                    item_qty = 1
                ";

            $res3 = mysqli_query($conn, $sql3);

                $reload = "<div><h4><a href='featured-products.php'>x</a></h4></div>";
                $_SESSION['add-on-cart'] = "<div class='message-success'><div></div>Product Added Successfully!" . $reload . "</div>";
                header('location:' . SITEURL . 'featured-products.php');
        }
    }
}
?>