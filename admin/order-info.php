<?php include('partials/header.php')?>

<body>
    <section id="menu">
        <div class="logo">
            <img src="../img/logo.jpg" alt="" width="45px" height="45px">
            <div class="title">
                <h5>A-Mart <br><span>Convenience</span><br>Store</h5>
            </div>
        </div>
        <div class="items">
        <section class="item1">
                <ul>
                    <a href="index.php">
                        <li class="<?php if(isset($_GET['dashboard'])){echo "current-item";}?>">
                            <i class="fa-solid fa-cubes <?php if(isset($_GET['dashboard'])){echo "current-item-i";}?>"></i>
                            <h5>Dashboard</h5>
                        </li>
                    </a>
            </section>
            <div class="inventory-box">
                <h5>Manage</h5>
            </div>
            <section class="item1">
                    <a href="manage-orders.php">
                    <li class="<?php 
                    if(isset($_GET['order_page'])){
                        echo "current-item";
                    }
                    ?>">
                            <i class="fa-solid fa-cart-shopping <?php if(isset($_GET['order_page'])){echo "current-item-i";}?>"></i>
                            <h5>Orders</h5>
                        </li>
                    </a>
                    <a href="manage-user.php">
                        <li>
                            <i class="fa-solid fa-users"></i>
                            <h5>User</h5>
                        </li>
                    </a>
                </ul>
            </section>
            <div class="inventory-box">
                <h5>Inventory</h5>
            </div>
            <section class="item1">
                <ul>
                    <a href="overview.php">
                        <li>
                            <i class="fa-solid fa-border-all"></i>
                            <h5>Overview</h5>
                        </li>
                    </a>
                    <a href="manage-products.php">
                        <li>
                            <i class="fa-solid fa-list"></i>
                            <h5>Products</h5>
                        </li>
                    </a>
                    <a href="manage-category.php">
                        <li>
                            <i class="fa-solid fa-grip-vertical"></i>
                            <h5>Category</h5>
                        </li>
                    </a>
                </ul>
            </section>
            <div class="inventory-box">
            <h5>Store</h5>
        </div>
        <section class="item1">
        <ul>
                    <a href="store.php">
                        <li>
                            <i class="fa-solid fa-store"></i>
                            <h5>Store</h5>
                        </li>
                    </a>
                </ul>
        </section>
            <section class="menu-footer">
            <div>
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    <a onClick="javascript: return confirm('Are you sure you want to log out? ');" href="logout.php"> Log Out</a>
                </div>
            </section>
        </div>
    </section>
    <section id="main">
        <section id="main-header">
            <div class="profile">
                <?php
                    ?><h5><?php echo date("m-d-y").", ". date("l"); ?></h5><?php
              
                ?>       
                <h5><?php echo "Welcome ".$_SESSION['user']."!";?></h5><?php          
                ?>
            </div>
        </section>
        <div class="wrapper">
            <section id="main-section">
            <section id="main-section">
                <div class="title" style="display: flex; justify-content:space-between; align-items:center;">
                    <?php
                        if(isset($_GET['order_page'])){
                            ?><a href="manage-orders.php" class="btn-add">Back</a><?php
                        }
                        elseif(isset($_GET['delivery_page'])){
                            ?><a href="manage-delivery.php" class="btn-add">Back</a><?php
                        }
                        elseif(isset($_GET['cancel_request_page'])){
                            ?><a href="cancel-requests.php" class="btn-add">Back</a><?php
                        }
                        elseif(isset($_GET['dashboard'])){
                            ?><a href="index.php" class="btn-add">Back</a><?php
                        }
                    ?>
                    <?php
                        if(isset($_GET['order_id'])){
                            $to_print = $_GET['order_id'];
                        }
                        ?>
                        <a href="invoice.php?print=<?php echo $to_print; ?>"><i class="fa-solid fa-print" style="padding: 20px 20px 0 0"></i></a>
                        <?php
                    ?>
                    
                    
                </div>
            </section>
            </section>
            <section id="main-content">

            <?php

                if(isset($_GET['order_id'])){   
                    $order_id =  $_GET['order_id'];

                    $sql = "SELECT * FROM tbl_order WHERE order_id=$order_id LIMIT 1";
                    $sql_run = mysqli_query($conn, $sql);
                    $fetch = mysqli_fetch_assoc($sql_run);

                    if($fetch['order_status'] == 'Preparing'){
                        $color = "blue";
                    }
                    elseif($fetch['order_status'] == 'Pending'){
                        $color = "orangered";
                    }
                    elseif($fetch['order_status'] == 'Cancelled'){
                        $color = "red";
                    }
                    elseif($fetch['order_status'] == 'On-Delivery'){
                        $color = "purple";
                    }
                    elseif($fetch['order_status'] == 'Delivered'){
                        $color = "green";
                    }

                    if(mysqli_num_rows($sql_run)>0){
                        ?>
                            <h5>Order ID: <span style="font-size:20px;">#<?php echo $fetch['order_id'];?></span></h5>
                            <br>          
                            <h5>Status: <span style="color:<?php echo $color;?>"><?php echo $fetch['order_status'];?></span></h5>
                            <h5>Order Date: <span><?php echo $fetch['placed_order_date'];?></span></h5>
                            <h5>Set Delivery Date: <span><?php echo $fetch['target_order_date'];?></span></h5>
                            <br>
                            <h5>Name: <span><?php echo $fetch['fullname'];?></span></h5>
                            <h5>Address: <span><?php echo $fetch['to_street'].', '.$fetch['to_barangay'].' '.$fetch['to_city'];?></span></h5>
                            <h5>Phone: <span><?php echo $fetch['phone'];?></span></h5>
                            <br>
                            <div style="width:50%">
                                <div style="display:flex; width:100%; justify-content: space-between; margin-top:20px; align-items:center">
                                    <div><h5>Products</h5></div>
                                    <h6>If a product is not available <span style="color:red">**<?=$fetch['replacement'];?>**</span></h6>
                                </div>
                                <div style="border: 1px solid #ccc; padding: 5px; margin-top:10px">
                                    <?php
                                        $items = $fetch['ordered_items'];
                                        $items = explode(',', $fetch['ordered_items']);

                                        $i = 0;
                                        $count = count($items);

                                        while($count>0){
                                            ?>
                                            <h5 style="text-transform: uppercase;"><?= $items[$i];?></h5>
                                            <?php 

                                            $i++;
                                            $count--;
                                        }
                                    ?>
                                </div>
                                <div style="padding:10px 0 0 0; display:flex; justify-content: space-between;">
                                    <h5>Total</h5>
                                    <h3><span style="color:red;"><?php echo 'P '.$fetch['total_price']?> </span><span style="font-size:12px;">(with <?php echo $fetch['delivery_fee']; ?> delivery fee)</span></h3>
                                </div>
                            </div>
                            <br>
                            <div>
                            </div>
                            <h6>Message</h6>
                            <textarea name="" id="" cols="50%" rows="5" disabled><?php echo $fetch['instruction'];?></textarea>
                            <br>
                            <br>
                            <?php

                            
                            ?>
                            
                        <?php
                    }
                }
            ?>
            </section>
        </div>
        
    </section>

    <!-- main section-->

</body>
</html>