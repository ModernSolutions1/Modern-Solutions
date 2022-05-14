<?php include('front-partials/header.php') ?>

<div class="container">
    <?php

    if (isset($_SESSION['already-on-cart'])) {
        echo $_SESSION['already-on-cart'];
        unset($_SESSION['already-on-cart']);
    }
    if (isset($_SESSION['add-on-cart'])) {
        echo $_SESSION['add-on-cart'];
        unset($_SESSION['add-on-cart']);
    }
    if (isset($_SESSION['loggedin'])) {
        echo $_SESSION['loggedin'];
        unset($_SESSION['loggedin']);
    }
    

    // for cart counter
    $email = "";
    if(isset($_SESSION['authenticated'])){
        $email = $_SESSION['auth_user']['email'];
    }
    $counter = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tbl_order_item WHERE customer_email='$email'"));

    ?>
</div>

<!-- HEADER -->
<section id="main-header">
    <div class="container">
        <nav>
            <ul>
                <li><a class="current" href="<?php echo SITEURL ?>">Home</a></li>
                <li><a href="<?php echo SITEURL; ?>products.php">Products</a></li>
                <?php if(!isset($_SESSION['authenticated'])){ $hide = "hidden";}else{ $hide="";}?>
                <li <?php echo $hide;?>><a href="<?php echo SITEURL ?>cart.php">Cart <span class="cart-counter" <?php if ($counter < 1) {
                                                                                                        echo 'style="background-color:transparent"';
                                                                                                    } ?>><?php if ($counter > 0) {
                                                                                                                echo $counter;
                                                                                                            } ?></span></a></li>
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
            }
            else{
                ?><a onClick="javascript: return confirm('Are you sure you want to logout? '); "href="logout.php" class="btn-login">Log Out</a><?php
            }
        ?>       
    </div>
</section>

<section id="showcase">
    <div class="container">
        <div class="col-1">
            <h1>A-Mart<br><span class="current">Convenience </span>Store</h1>
            <h5>Get every product of your need!</h5>
            <div class="showcase-text">
                <p>Call to deliver! Stay at home and let us bring your needs to your doorstep</p>
                <p>Want to order via call or text instead? Reach us at 0912-123-1234 | Mon-Saturday Only</p>
                <p>or Visit us at Purok 4, Lot 1 Villa Teresa, Lunzuran Zamboanga City</p>
            </div>
            <a href="products.php"><button>Order Now</button></a>
        </div>
    </div>
</section>
</body>

</html>