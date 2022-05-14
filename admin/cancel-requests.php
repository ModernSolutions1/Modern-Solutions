<?php include('partials/header.php') ?>

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
                        <li>
                            <i class="fa-solid fa-cubes"></i>
                            <h5>Dashboard</h5>
                        </li>
                    </a>
            </section>
            <div class="inventory-box">
                <h5>Manage</h5>
            </div>
            <section class="item1">
                <a href="manage-orders.php">
                    <li class="current-item">
                        <i class="fa-solid fa-cart-shopping current-item-i"></i>
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
                        <i class="fa-solid fa-border-all"></i>
                            <h5>Store</h5>
                        </li>
                    </a>
                </ul>
            </section>
            <section class="menu-footer">
                <div>
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    <a href="#"> Log Out</a>
                </div>
            </section>
        </div>
    </section>
    <section id="main">
        <section id="main-header">
            <div class="profile">
                <?php
                ?><h5><?php echo date("m-d-y") . ", " . date("l"); ?></h5><?php

                                                                            ?>
                <h5><?php echo "Welcome " . $_SESSION['user'] . "!"; ?></h5><?php
                                                                            ?>
            </div>
        </section>
        <div class="wrapper">
            <section id="main-section">
                <section id="main-section">
                    <div class="title">
                        <?php
                            if(isset($_GET['cr'])){
                                echo '<a href="manage-orders.php" class="btn-add">Back</a>';
                            }
                            else{
                                echo '<a href="manage-orders.php" class="btn-add">Back</a>';
                            }
                        ?>
                        
                    </div>
                </section>
            </section>
            <section id="main-content">
                
                <section id="table-container">
                    <div class="table-header">
                        <div class="title">
                            <h4>Cancel Requests</h4>
                        </div>
                    </div>
                    <table id="tbl_orders">
                        <thead>
                            <tr width="100%">
                            <td width="8%">ID</td>              
                                <td width="20%">Order Date</td>
                                <td width="10%">Status</td>
                                <td width="20%">Name</td>
                                <td width="20%">Delivery Date</td>
                                <td width="10%">Total</td>
                                <td width="4%"></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql = "SELECT * FROM tbl_order WHERE cancel_request='requesting' and order_status='Pending'";
                                $sql_run = mysqli_query($conn, $sql);

                            $i = 1;

                            if (mysqli_num_rows($sql_run) > 0) {

                                while ($fetch = mysqli_fetch_assoc($sql_run)) {
                                    if ($fetch['order_status'] == 'Preparing') {
                                        $status = "status-confirm";
                                    } elseif ($fetch['order_status'] == 'Pending') {
                                        $status = "status-warning";
                                    } elseif ($fetch['order_status'] == 'Cancelled') {
                                        $status = "status-danger";
                                    } elseif ($fetch['order_status'] == 'On-Delivery') {
                                        $status = "status-violet";
                                    } elseif ($fetch['order_status'] == 'Delivered') {
                                        $status = "status-success";
                                    }

                            ?>
                                    <tr width="100%">
                                    <td width="8%">
                                            <h5><span><?php echo $fetch['order_id'] ?></span></h5>
                                        </td>             
                                        <td width="20%">
                                            <h5><?php echo $fetch['placed_order_date']?></h5>
                                        </td>
                                        <td width="15%">
                                            <h5><span class="<?php echo $status; ?>"><?php echo $fetch['order_status'] ?></span></h5>
                                        </td>
                                        <td width="20%">
                                            <h5><?php echo $fetch['fullname'] ?></h5>
                                        </td>
                                        <td width="20%">
                                            <h5><?php echo $fetch['target_order_date']?></h5>
                                        </td>
                                        <td width="7%">
                                            <h5>P<?php echo $fetch['total_price']+50 ?></h5>
                                        </td>
                                        <?php
                                        if (isset($_SESSION['order-page'])) {
                                            unset($_SESSION['deliver-page']);
                                        ?><td width="10%">
                                                <h5><a class="view" href="order-info.php?order_id=<?php echo $fetch['order_id'] ?>&order_page=TRUE">View</a></h5>
                                            </td><?php
                                                }
                                                    ?>
                                        <?php
                                        if ($fetch['order_status'] == "Pending") {
                                        ?>
                                            <td style="text-align: center">
                                                <h5 style><a onClick="javascript: return confirm('Grant Request? ');" style="font-weight:bold; color:white; padding:2px;background-color:green; border-radius:3px;" href="cancel-order.php?order_id=<?php echo $fetch['order_id']; ?>&grant=YES">Grant</a></h5>
                                            <td>
                                            <td style="text-align: center">
                                                <h5><a onClick="javascript: return confirm('Cancel Request? ');" style="font-weight:bold; color:white; padding:2px;background-color:red; border-radius:3px;" href="cancel-order.php?order_id=<?php echo $fetch['order_id']; ?>&grant=NO">Cancel</a></h5>
                                            </td>
                                        <?php
                                        }
                                        ?>
                                    </tr>
                            <?php
                                    $i++;
                                }
                            } else {
                                echo "<tr><div style='text-align:center'>No orders found!</div></tr>";
                            }
                            ?>

                        </tbody>
                    </table>
                </section>
            </section>
        </div>

    </section>

    <!-- main section-->

</body>

</html>