<?php include('front-partials/header.php');
include('front-partials/login-check.php');
$email = "";
if (isset($_SESSION['authenticated'])) {
    $email = $_SESSION['auth_user']['email'];
}
$counter = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tbl_order_item WHERE customer_email='$email'"));
?>

<!-- HEADER -->
<section id="main-header">
    <div class="container">
        <nav>
            <ul>
                <li><a href="<?php echo SITEURL ?>">Home</a></li>
                <li><a href="<?php echo SITEURL; ?>products.php">Products</a></li>
                <?php if (!isset($_SESSION['authenticated'])) {
                    $hide = "hidden";
                } else {
                    $hide = "";
                } ?>
                <li $hide;><a href="<?php echo SITEURL ?>cart.php">Cart <span class="cart-counter" <?php if ($counter < 1) {
                                                                                                        echo 'style="background-color:transparent"';
                                                                                                    } ?>><?php if ($counter > 0) {
                                                                                                                echo $counter;
                                                                                                            } ?></span></a></li>
                <?php
                if (isset($_SESSION['authenticated'])) {
                ?>
                    <li><a class="current" href="my-orders.php">My Order</a></li>
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

<section id="my-orders">
    <div class="container">
        <div id="my-order-header">
            <h1>My Orders</h1>
            <?php
                $c1_email = $_SESSION['auth_user']['email'];

                $f1etch = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tbl_customer WHERE customer_email = '$c1_email'"));
                $x1_email = $f1etch['customer_email'];

                $s1ql = "SELECT * FROM tbl_order WHERE customer_email = '$x1_email' ORDER BY placed_order_date DESC";
                $r1un = mysqli_query($conn, $s1ql);

                if(mysqli_num_rows($r1un)>10){
                    echo '<a href="my-orders.php?view_all=true">View All Orders</a>';
                }
                else{
                    echo '<a hidden href="my-orders.php?view_all=true">View All Orders</a>';
                }
            ?>
            
        </div>
        <div style="overflow:auto">
        <table id="my-order-tbl">
            
            <tbody>

            <?php
            if(isset($_GET['cancel'])){
                $xx = $_GET['cancel'];
                $x = "UPDATE tbl_order SET
                cancel_request = 'requesting'
                 WHERE order_id = $xx ";

                $y = mysqli_query($conn, $x);
                header('location:'.SITEURL.'my-orders.php');
            }
                if(!isset($_GET['id'])){
                    // table header
                    ?>
                    <thead>
                        <tr>
                            <td>Order ID</td>
                            <td>Order Date</td>
                            <td>Status</td>
                            <td>Total</td>
                            <td>Delivery Date</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </thead>
                    <?php

                    
                    $c_email = $_SESSION['auth_user']['email'];

                    $fetch = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tbl_customer WHERE customer_email = '$c_email'"));
                    $x_email = $fetch['customer_email'];

                    if(isset($_GET['view_all'])){
                        $sql = "SELECT * FROM tbl_order WHERE customer_email = '$x_email' ORDER BY placed_order_date DESC";
                        $run = mysqli_query($conn, $sql);
                    }else{
                        $sql = "SELECT * FROM tbl_order WHERE customer_email = '$x_email' ORDER BY placed_order_date DESC LIMIT 10";
                        $run = mysqli_query($conn, $sql);
                    }

                    
    
                    if(mysqli_num_rows($run) > 0){
    
                        while ($tab = mysqli_fetch_assoc($run)) {  

                            if($tab['order_status'] != 'Pending'){
                                $hide = "hidden";
                            }else{$hide = "";} 

                            if($tab['order_status'] == 'Pending'){
                                $color = "Orange";
                            }elseif($tab['order_status'] == 'Cancelled'){
                                $color = "Red";
                            }
                            elseif($tab['order_status'] == 'Preparing'){
                                $color = "blue";
                            }
                            elseif($tab['order_status'] == 'On-Delivery'){
                                $color = "purple";
                            }
                            elseif($tab['order_status'] == 'Delivered'){
                                $color = "green";
                            }

                            ?>
                            <tr>
                                <td><?= $tab['order_id']; ?></td>
                                <td><?= $tab['placed_order_date']; ?></td>
                                <td><span style="color:<?=$color;?>"><?= $tab['order_status']; ?></span></td>
                                <td>P<?= $tab['total_price']; ?></td>
                                <td><?= $tab['target_order_date']; ?></td>
                                <td><a href="my-orders.php?id=<?= $tab['order_id']; ?>">View</a></td>
                                <?php 
                                if($tab['cancel_request'] == ''){
                                    ?><td <?=$hide; ?>><a  onClick="javascript: return confirm('Are you sure you want to cancel this order? Cancelling of order might not be granted by the owner. '); " href="my-orders.php?cancel=<?= $tab['order_id']; ?>">Cancel</a></td><?php
                                }
                                if($tab['cancel_request'] != ''){
                                    $msg = "";
                                    if($tab['cancel_request'] == 'not_granted'){
                                        $msg = "Request was not granted";
                                    }
                                    elseif($tab['cancel_request'] == 'requesting'){
                                        $msg = "Waiting for confirmation";
                                    }
                                    ?><td <?=$hide; ?>><input disabled type="text" value="<?=$msg;?>" style="border:none; padding: 5px 3px; width:150; text-align:center; color:#555"></td><?php
                                }
                                ?>
                                
                            </tr>
                            <?php         
                            
                        }
    
                    }else{
                        ?><tr><td><p>No orders found.</p></td></tr><?php
                    }
                }else{
                    ?>
                    <br>
                        <a href="my-orders.php" style="padding:5px 15px; background-color: red;  color:white">Back</a></span>
                    <br>
                    <br>
                    <hr><br><br>

                    <?php
                    $c_email = $_SESSION['auth_user']['email'];

                    $fetch = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tbl_customer WHERE customer_email = '$c_email'"));
                    $x_email = $fetch['customer_email'];

                    $order_id = $_GET['id'];
    
                    $sql = "SELECT * FROM tbl_order WHERE customer_email = '$x_email' AND order_id = $order_id ORDER BY placed_order_date DESC";
                    $run = mysqli_query($conn, $sql);

                    $fetch = mysqli_fetch_assoc($run);
                    ?>
                    <h5>Order id: <span class="order-details"><?=$fetch['order_id']?></span></h5><br>
                    <h5>Status: <span><?=$fetch['order_status']?></span></h5>
                    <h5>Order Date: <span><?=$fetch['placed_order_date']?></span></h5>
                    <h5>Delivery Date: <span><?=$fetch['target_order_date']?></span></h5><br>
                    <div>
                        <!-- <h5>Products</h5>   -->
                        <div>
                            <table id="tbl2">
                                <thead>
                                    <tr>
                                        <td></td>
                                        <td>Product</td>
                                        <td>Price</td>
                                        <td>Qty</td>
                                        <td>Sub-total</td>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                        <?php

                                        $grand = 0;
                                        $items = explode(',', $fetch['ordered_items']);
                                        $total_item = count($items);

                                        $i = 0;

                                        while($total_item>0){


                                            // $qty = (int)filter_var($items[$i], FILTER_SANITIZE_NUMBER_INT);
                                            if($items[$i][strlen($items[$i])-3] != '('){
                                                $concat = $items[$i][strlen($items[$i])-3];
                                                $found = 4;
                                            }elseif($items[$i][strlen($items[$i])-4] != '('){
                                                $concat = $items[$i][strlen($items[$i])-3].$items[$i][strlen($items[$i])-2];
                                                $found = 5;
                                            }else{
                                                $found = 3;
                                                $concat = 0;
                                            }

                                            $qty =  (int)$items[$i][strlen($items[$i])-2];
                                            $qty = abs($qty);
                                            $pname = str_replace(')', '', $items[$i]);
                                            $pname = str_replace('(', '', $pname);
                                            // $final = trim(preg_replace('/[^a-zA-Z0-9]+/', '', $pname));
                                            $final = mysqli_real_escape_string($conn, trim(substr($items[$i], 0, strlen($items[$i])-$found+2)));

                                            $find = "SELECT * FROM tbl_products WHERE product_name = '$final'";
                                            $find1 = mysqli_query($conn, $find);
                                            $data = mysqli_fetch_assoc($find1);

                                            if($find1){
                                                ?>
                                                <tr>
                                                    <td><img src="<?php echo SITEURL; ?>img/products/<?=$data['product_img'];?>" width="50px" height="50px"></td>
                                                    <td><?=mysqli_real_escape_string($conn, $data['product_name']);?></td>
                                                    <td>P<?=$data['product_price'];?></td>
                                                    <td><?=$qty;?></td>
                                                    <td>P<?=$data['product_price']*$qty;?></td>
                                                    
                                                </tr>
                                                <?php
                                                $grand = $grand + ($data['product_price']*$qty);
                                                $total_item--;
                                                $i++;
                                            }

                                            
                                        }

                                        ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td style="padding-top:20px"; colspan="6">Grand Total P<?= $grand+50;?> <span style="color:red">(with P50 delivery fee)</span></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <?php                 
                }
            ?>
            </tbody>
        </table>
        </div>
        
    </div>
</section>
<?php include('front-partials/footer.php') ?>