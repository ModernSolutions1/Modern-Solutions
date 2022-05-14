<?php include('front-partials/header.php');
include('front-partials/login-check.php');
date_default_timezone_set('Asia/Manila');
;

if(isset($_SESSION['d_date'])){
    echo $_SESSION['d_date'];
    unset($_SESSION['d_date']   );
}

$c_email = $_SESSION['auth_user']['email'];
$grand = 0;
if (isset($_SESSION['cart-checkout']) or isset($_SESSION['authenticated'])) {
    $sqll = "SELECT * FROM tbl_order_item WHERE customer_email='$c_email'";
    $ress = mysqli_query($conn, $sqll);
    if (mysqli_num_rows($ress) > 0) {
        while ($fetchh = mysqli_fetch_assoc($ress)) {
            $grand = $grand + ($fetchh['item_qty'] * $fetchh['order_item_price']);
        }
    }
}

?>

<?php

if (isset($_POST['checkout_btn'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $fullname = $fname . ' ' . $lname;
    $phone = $_POST['phone'];
    $street = $_POST['street'];
    $barangay = $_POST['barangay'];
    $order_date = date('Y-m-d H:i:s');
    $delivery_date = $_POST['delivery_date'];
    $city = $_POST['city'];
    $payment = $_POST['payment'];
    $replacement = $_POST['replacement'];
    $instruction = mysqli_real_escape_string($conn, $_POST['instruction']);
    $date_today = date('Y-m-d');

    $date_diff = FALSE;

    if(intVal(date('d', strtotime($delivery_date))) < intVal(date('d', strtotime($date_today)))){
        $reload = "<div><h4><a href='checkout.php'>x</a></h4></div>";
        $_SESSION['d_date'] = "<div class='msg-failed'><div></div>Please set proper delivery time" . $reload . "</div>";
        header('location:'.SITEURL.'checkout.php');
    }else{

        if(preg_match('/^[0-9]{11}+$/', $phone) or preg_match('/^[0-9]{10}+$/', $phone) ){

            $c_email = $_SESSION['auth_user']['email'];
            $cart_query = mysqli_query($conn, "SELECT * FROM tbl_order_item WHERE customer_email='$c_email'");
            $price_total = 0;
            $j = 1;
            $_SESSION['failed-to-checkout'] = true;
            $_SESSION['inputs'] = [
                'fname' => $fname,
                'lname' => $lname,
                'phone' => $phone,
                'street' => $street,
                'barangay' => $barangay,
                'delivery_date' => $delivery_date,
                'city' => $city,
                'payment' => $payment,
                'replacement' => $replacement,
                'instruction' => $instruction,
            ];
        
            if (mysqli_num_rows($cart_query) > 0) {
                
                    while ($product_item = mysqli_fetch_assoc($cart_query)) {
                        $product_name[] = mysqli_real_escape_string($conn, $product_item['order_item_name']) . ' (' . $product_item['item_qty'] . ')';
                        $product_price = $product_item['order_item_price'] * $product_item['item_qty'];
                        $price_total += $product_price;
                        $j++;
                    };
            }
        
            $total_product = implode(', ', $product_name);
        
            $checkout_sql = "INSERT INTO tbl_order SET
                    customer_email = '$c_email',
                    fullname = '$fullname',
                    ordered_items = '$total_product',
                    phone = '$phone',
                    payment = '$payment',
                    to_street = '$street',
                    to_barangay = '$barangay',
                    to_city = '$city',
                    instruction = '$instruction',
                    placed_order_date = '$order_date',
                    target_order_date = '$delivery_date',
                    replacement = '$replacement',
                    delivery_fee = 50,
                    total_price = $price_total+50,
                    order_status = 'Pending'
                ";
            $run = mysqli_query($conn, $checkout_sql);
        
            if ($run) {
                $email = $_SESSION['auth_user']['email'];
                $del_all = mysqli_query($conn, "DELETE FROM tbl_order_item WHERE customer_email = '$email'");
                echo '<script>alert("Checkout Successful!")</script>';
                header('location:' . SITEURL . 'my-orders.php');
            } else {
                echo '<script>alert("Checkout Failed!")</script>';
            }
        }else{
            echo '<script>alert("Please input a valid phone number! Thanks")</script>';
        }
        
    }

}
?>

<!-- HEADER -->
<section id="main-header">
    <div class="container">
        <nav>
            <ul>
                <li><a href="<?php echo SITEURL ?>">Home</a></li>
                <li><a href="<?php echo SITEURL; ?>products.php">Products</a></li>
                <?php if(!isset($_SESSION['authenticated'])){ $hide = "hidden";}else{ $hide="";}?>
                <li $hide><a class="current" href="<?php echo SITEURL ?>cart.php">Cart</a></li>
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

<section class="title">
    <div class="container">
        <ul>
            <li><a href="cart.php">Cart</a></li>
            <li>&#155</li>
            <li>Checkout</li>
        </ul>
    </div>
</section>

<section class="order-summary">
    <div class="container">
        <div class="view-summary" id="btnshow" onclick="show()">
            <button  id="btnxx" style=" border:none; font-size: 14px; background-color: transparent;">Show Order Summary</button>
            <h3>P<?php echo $grand; ?></h3>
        </div>
        <div id="order-details" style="display:none;">
            <?php
            if (isset($_SESSION['cart-checkout']) or isset($_SESSION['authenticated'])) {
                $sql = "SELECT * FROM tbl_order_item WHERE customer_email='$c_email'";
                $res = mysqli_query($conn, $sql);
                if (mysqli_num_rows($res) > 0) {
                    while ($fetch = mysqli_fetch_assoc($res)) {
            ?>
                        <div style="display: flex; justify-content: space-between;">
                            <div class="flex">
                                <h5><?php echo $fetch['order_item_name']; ?></h5>
                                <h5><?php echo '( ' . $fetch['item_qty'] . ' )'; ?></h5>
                            </div>
                            <h5>P<?php echo $fetch['order_item_price']*$fetch['item_qty']; ?></h5>
                        </div>
            <?php
                    }
                } else {
                    echo "Cart is empty";
                }
            }

            ?>
        </div>
    </div>
</section>

<section>
    <div class="container" style="color:#555; font-size: 18px">
    <br>
        <h5>Delivery Fee: P50</h5>
        <h5 style="line-height:1.5em;">Total: <span style=" color: red"><?php echo 'P'.$grand+50?></span> </h5>
    </div>
</section>

<section id="checkout">
    <div class="container">
        <div>
            <h4><i class="fa-solid fa-location-dot" style="color:blue"></i> Delivery Address</h4>
            <div>
                <form action="" method="POST">
                    <div class="form-bg">
                        <div class="flex">
                            <input type="text" name="fname" id="" placeholder="First name" class="custom-border" value="<?php if(isset($_POST['checkout_btn'])){ echo $_POST['fname'];} else{ echo '';}?>" required>
                            <input type="text" name="lname" id="" placeholder="Last name" class="custom-border" value="<?php if(isset($_POST['checkout_btn'])){ echo $_POST['lname'];} else{ echo '';}?>"  required>
                        </div>
                        <div style="border:1px solid #ccc; padding: 10px; background-color: white; border-radius: 3px; color: #555">
                            <h5>Phone</h5>
                            <div style="display:flex; gap:10px; padding-top:5px">
                            <input type="text" disabled value="+63" style="background-color: transparent; width: 5%; color: #555; border: 1px solid #ccc; border-radius: 3px; margin-top: 5px; outline:none;">
                            <input id="phone" type="tel" name="phone" maxlength="11" class="custom-border" style="width: 100%; border: 1px solid #ccc; padding: 10px; margin-top: 5px; outline:none;" placeholder="example.9123456789" value="" required>
                            </div>
                        </div>
                        <input type="text" name="street" id="" placeholder="Street" class="custom-border" value="<?php if(isset($_POST['checkout_btn'])){ echo $_POST['street'];} else{ echo '';}?>"  required>
                        <div style="border:1px solid #ccc; padding: 10px; background-color: white; border-radius: 3px; color: #555">
                            <h5>Select your Barangay</h5>
                            <select name="barangay" id="" class="custom-border" style="border:none; margin-top:5px; background-color: transparent;" value="<?php if(isset($_POST['checkout_btn'])){ echo $_POST['barangay'];} else{ echo '';}?>"  required>
                                <?php
                                $sql_barangay = "SELECT * FROM tbl_barangay";
                                $run_barangay = mysqli_query($conn, $sql_barangay);

                                if (mysqli_num_rows($run_barangay) > 0) {
                                    while ($x = mysqli_fetch_assoc($run_barangay)) {
                                ?> <option value="<?php echo $x['barangay']; ?>"><?php echo $x['barangay']; ?></option> <?php
                                                                                                    }
                                                                                                }
                                                                                                        ?>
                            </select>
                        </div>
                        <div class="flex">
                            <input type="text" name="city" id="" placeholder="City" class="custom-border" value="<?php if(isset($_POST['checkout_btn'])){ echo $_POST['city'];} else{ echo '';}?>"  required>
                        </div>
                        <div style="border:1px solid #ccc; padding: 10px; background-color: white; border-radius: 3px; color: #555">
                            <h5>Delivery Date</h5>
                            <input id="datefield" type="date" name="delivery_date" class="custom-border" style="width: 100%; border: none; padding: 10px; margin-top: 5px; outline:none;" value="<?php if(isset($_POST['checkout_btn'])){ echo $_POST['delivery_date'];} else{ echo '';}?>" >
                        </div>
                        <div style="border:1px solid #ccc; padding: 10px; background-color: white; border-radius: 3px; color: #555">
                            <h5>Payment</h5>
                            <select name="payment" id="" class="custom-border" style="border:none; margin-top:5px; background-color: transparent;" value="<?php if(isset($_POST['checkout_btn'])){ echo $_POST['payment'];} else{ echo '';}?>" >
                                <option value="COD">Cash-on-Delivery (P50 Delivery Fee)</option>
                            </select>
                        </div>
                        <div>
                            <div style="width:100%; border:1px solid #ccc; padding: 10px; background-color: white; border-radius: 3px; color: #555">
                                <h5>If product is not available</h5>
                                <select name="replacement" id="" class="custom-border" style="border:none; margin-top:5px; background-color: transparent;" value="<?php if(isset($_POST['checkout_btn'])){ echo $_POST['replacement'];} else{ echo '';}?>" >
                                    <option value="Remove the product from my order">Remove the product from my order</option>
                                    <option value="Find similar product">Find similar product</option>
                                </select>
                            </div>
                            <br>
                            <textarea name="instruction" id=""cols="130%" rows="10" placeholder=" Additional Instruction (optional)" class="custom-border" value="<?php if(isset($_POST['checkout_btn'])){ echo $_POST['instruction'];} else{ echo '';}?>" ></textarea>
                        </div>
                    </div>
                    <br>
                    <div style="display: flex; justify-content: space-between">
                        <input onClick="javascript: return confirm('Are you sure you want to place this order? '); " type="submit" name="checkout_btn" id="" value="Place Order" class="checkoutbtn">
                    </div>
                    <br>
                </form>
            </div>
        </div>
    </div>
</section>
<script>
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1;
    var yyyy = today.getFullYear();

    if(dd < 10){
        dd = '0' + dd;
    }

    if(mm < 10){
        mm = '0' + mm;
    }

    today = yyyy + '-' + mm + '-' + dd;
    document.getElementById("datefield").setAttribute("min", today);
</script>
<script>

    clicked = 1;

    function show() {

        if (clicked == 1) {
            document.getElementById('order-details').style.display = "flex";
            document.getElementById('order-details').style.justifyContent = "space-between";
            document.getElementById('order-details').style.flexDirection = "column";
            document.getElementById('order-details').style.height = "100%";
            document.getElementById('btnshow').display = "block";
            document.getElementById('btnxx').textContent = "Order Summary";
            clicked = 0;
        } else {
            document.getElementById('order-details').style.display = "none";
            document.getElementById('btnxx').textContent = "Show Order Summary";
            clicked = 1;
        }
    }


</script>
<?php include('front-partials/footer.php') ?>