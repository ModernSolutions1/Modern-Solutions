<?php include('front-partials/header.php');

if(!$_SESSION['authenticated']){
    header('location:'.SITEURL.'login.php');
}
?>

<?php

if (isset($_POST['update'])) {

    $p_qty =  $_POST['item_qty'];
    $p_update_id = $_POST['update_id'];

    $update_sql = "UPDATE tbl_order_item SET
        item_qty = $p_qty
        WHERE order_item_id=$p_update_id";
    $update_sql_exe = mysqli_query($conn, $update_sql);

    if ($update_sql_exe) {
        header('location:' . SITEURL . 'cart.php');
    }
}

if (isset($_POST['']))
?>

<div class="container">

    <?php

if (isset($_SESSION['delete-on-cart'])) {
    echo $_SESSION['delete-on-cart'];
    unset($_SESSION['delete-on-cart']);
}
    ?>

</div>


<!-- HEADER -->
<section id="main-header">
    <div class="container">
        <nav>
            <ul>
                <li><a href="<?php echo SITEURL; ?>">Home</a></li>
                <li><a href="<?php echo SITEURL ?>products.php">Products</a></li>
                <?php if(!isset($_SESSION['authenticated'])){ $hide = "hidden";}else{ $hide="";}?>
                <li <?php echo $hide;?>><a class="current" href="<?php echo SITEURL ?>cart.php">Cart</a></li>
                <?php
                if (isset($_SESSION['authenticated'])) {
                ?>
                    <li><a href="my-orders.php">My Order</a></li>
                <?php
                }
                ?>
            </ul>
        </nav>
        <?php
        if (!isset($_SESSION['authenticated'])) {
        ?><a href="login.php" class="btn-login">Login</a><?php
                                                                } else {
                                                                    ?><a onClick="javascript: return confirm('Are you sure you want to logout? '); " href="logout.php" class="btn-login">Log Out</a><?php
                                                                                                                                            }
                                                                                                                                                ?>
    </div>
</section>

<section id="my-cart">
    <div class="container">
        <h1>MY CART</h1>
        <div class="cart-tbl">
            <div class="tbl-head">
                <div class="tbl-row">
                    <div class="tbl-col-1">
                        <p>Item(s)</p>
                    </div>
                    <div class="tbl-col-2">
                        <h4></h4>
                    </div>
                    <div class="tbl-col-3">
                        <p>Quantity</p>
                    </div>
                    <div class="tbl-col-4">
                        <p>Subtotal</p>
                    </div>
                    <div class="tbl-col-5">
                        <p>Remove</p>
                    </div>
                </div>
            </div>

            <?php
            
            $email = $_SESSION['auth_user']['email'];

            $sql = "SELECT * FROM tbl_order_item WHERE customer_email='$email'";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);

            $stock_sql = "SELECT * FROM tbl_products";
            $stock_res = mysqli_query($conn, $stock_sql);

            $grand = 0;

            if ($count > 0) {

                while ($row = mysqli_fetch_assoc($res)) {

                    $item_id = $row['order_item_id'];
                    $item = $row['order_item_name'];
                    $item_price = $row['order_item_price'];
                    $image_name = $row['order_item_img'];
                    $item_qty = $row['item_qty'];

            ?>
                    <div class="tbl-body">
                        <div class="tbl-row">
                            <div class="tbl-col-1">

                                <?php

                                if ($image_name != "") {
                                ?>
                                    <img src="<?php echo SITEURL; ?>img/products/<?php echo $image_name; ?>" width="50px" height="50px" style="border-radius:5px">
                                <?php
                                } else {
                                ?><img src="" width="50px" height="50px"><?php
                                                                        }
                                                                            ?>


                            </div>
                            <div class="tbl-col-2">
                                <!-- <small>Stock: </small> -->
                                <p class="current"><?php echo $item; ?></p>
                                <p>P<?php echo $item_price ?></p>
                            </div>
                            <div class="tbl-col-3">
                                <form action="" method="POST" style="display:flex; justify-content: center; align-items: center; gap:1px">
                                    <input type="hidden" name="update_id" value="<?php echo $item_id ?>">
                                    <input type="number" min="1" name="item_qty" value="<?php echo $item_qty; ?>" style="padding:3px; font-size:14px; border-radius: 3px;">
                                    <input type="submit" value="Update" name="update" style="padding:3px; border-radius: 3px; font-size:12px; background-color: rgb(81, 206, 81); color: white; cursor:pointer;">
                                </form>
                            </div>
                            <div class="tbl-col-4">
                                <p>P<?php echo $item_price * $item_qty;
                                    $grand = $grand + ($item_price * $item_qty); ?></p>
                            </div>
                            <div class="tbl-col-5">
                                <a onClick="javascript: return confirm('Are you sure you want to remove this product? '); " href="<?php echo SITEURL; ?>delete-cart.php?id=<?php echo $item_id; ?>">x</a>
                            </div>
                        </div>
                    </div>
                <?php
                }
            } else {

                ?> <img src="img/empty_cart.png" alt="" width="100px" style="position:relative; left: 50%; margin-top:50px"><?php
                                                                                                                        }

                                                                                                                            ?>
            <div class="delete-all-row">
                <div></div>
                <a onClick="javascript: return confirm('Are you sure you want to remove all this product? '); "  href="<?php echo SITEURL; ?>delete-cart.php?remove_all"><button class="btn-cart-cont" <?php if ($count < 1) {
                                                                                                                echo "hidden";
                                                                                                            } ?>>Remove All</button></a>
            </div>
            <div style="display:flex; gap: 10px; align-items:center; justify-content: right; padding: 20px 0; color: #555;">

                <?php

                if ($count != 0) {

                ?>
                    <h4>Grand Total</h4>
                    <h4 class="current">P<?php echo $grand; ?></h4>
                <?php
                }
                ?>
            </div>
            <div class="tbl-foot">
                <div class="tbl-row">
                    <a href="all-products.php"><button class="btn-cart-cont"><i class="fa-solid fa-arrow-left-long"></i> Continue Shopping</button></a>
                    <div>
                        <div style="display:flex; gap: 20px">

                            <?php
                            if (isset($_SESSION['authenticated'])) {
                                $_SESSION['checkoutbtn'] = TRUE;
                                $x = "";
                                if ($count < 1) {
                                    $x = "hidden";
                                }
                                echo '<a href="checkout.php"><button class="btn-cart-checkout"' . $x . '>Proceed to Checkout <i class="fa-solid fa-arrow-right-long"></i></button></a>';
                            } else {
                                $_SESSION['checkoutbtn'] = TRUE;
                                $x = "";
                                if ($count < 1) {
                                    $x = "hidden";
                                }
                                echo '<a href="login.php"><button class="btn-cart-checkout"' . $x . '>Proceed to Checkout <i class="fa-solid fa-arrow-right-long"></i></button></a>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include('front-partials/footer.php') ?>