<?php include('partials/header.php');
$x = 0;
?>

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
                        <li class="current-item">
                            <i class="fa-solid fa-cubes current-item-i"></i>
                            <h5>Dashboard</h5>
                        </li>
                    </a>
            </section>
            <div class="inventory-box">
                <h5>Manage</h5>
            </div>
            <section class="item1">
                <a href="manage-orders.php">
                    <li>
                        <i class="fa-solid fa-cart-shopping"></i>
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

    <!-- main header -->
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
                <div class="title">
                    <h4>Dashboard</h4>
                </div>
            </section>
            <?php
            if ($_SESSION['usertype'] == 'Admin') {
                // usertype admin cut here
            ?>
                <section id="main-content">
                    <div class="boxes">

                        <?php

                        $sql1 = "SELECT * FROM tbl_order WHERE order_status='Pending'";
                        $run1 = mysqli_query($conn, $sql1);
                        $count1 = mysqli_num_rows($run1);

                        $sql2 = "SELECT * FROM tbl_order WHERE order_status='Preparing'";
                        $run2 = mysqli_query($conn, $sql2);
                        $count2 = mysqli_num_rows($run2);

                        $sql3 = "SELECT * FROM tbl_order WHERE order_status='Pending' and cancel_request='Cancel Request'";
                        $run3 = mysqli_query($conn, $sql3);
                        $count3 = mysqli_num_rows($run3);


                        $datesql = "SELECT * FROM tbl_order";
                        $runx = mysqli_query($conn, $datesql);
                        $xdate = date('Y-m-d');
                        $t_count = 0;

                        while ($fetchy = mysqli_fetch_assoc($runx)) {
                            if ((date('Y', strtotime($fetchy['placed_order_date'])) . '-' . date('m', strtotime($fetchy['placed_order_date'])) . '-' . date('d', strtotime($fetchy['placed_order_date']))) == $xdate) {
                                $t_count++;
                            }
                        }

                        ?>
                        <div class="box">
                            <i class="fa-solid fa-calendar-day"></i>
                            <div>
                                <h4><?php echo $t_count; ?></h4>
                                <a href="manage-orders.php">
                                    <p>Today's Order</p>
                                </a>
                            </div>
                        </div>
                        <!-- <div class="box">
                    <i class="fa-solid fa-truck"></i> 
                        <div>
                            <h4><?php echo $count2; ?></h4>
                            <a href=""></a><p>Pending Delivery</p>
                        </div>
                    </div> -->
                        <div class="box">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <div>
                                <h4><?php echo $count1; ?></h4>
                                <p><a href="manage-orders.php">Pending Order</a></p>
                            </div>
                        </div>
                        <div class="box">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            <div>
                                <h4><?php echo $count3; ?></h4>
                                <p><a href="cancel-requests.php">Cancel Request</a></p>
                            </div>
                        </div>
                        <?php

                        ?>
                    </div>
                    <section id="table-container">
                        <div class="table-header">
                            <h1><i class="fa-solid fa-calendar-day"></i> Todays Order</h1>
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

                                $cdate = date('Y-m-d');

                                $sql = "SELECT * FROM tbl_order";
                                $sql_run = mysqli_query($conn, $sql);

                                $i = 1;

                                if (mysqli_num_rows($sql_run) > 0) {

                                    while ($fetch = mysqli_fetch_assoc($sql_run)) {

                                        if ((date('Y', strtotime($fetch['placed_order_date'])) . '-' . date('m', strtotime($fetch['placed_order_date'])) . '-' . date('d', strtotime($fetch['placed_order_date']))) == $cdate) {

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
                                            <h5>P<?php echo $fetch['total_price'] ?></h5>
                                        </td>
                                                <?php
                                                ?><td width="10%">
                                                    <h5><a class="view" href="order-info.php?order_id=<?php echo $fetch['order_id'] ?>&dashboard=TRUE">View</a></h5>
                                                </td><?php

                                                        ?>
                                            </tr>
                                <?php
                                        }
                                    }
                                } else {
                                    echo "<tr><td colspan='7'><div style='text-align:center'><h4>No orders found!</h4></div><td></tr>";
                                }
                                ?>

                            </tbody>
                        </table>
                    </section>
                <?php
                // usertype admincut here
            } else {

                echo "<div id='main-content'><h3 style='text-align:center'>Access Denied. Please contact the administrator.</h3></div>";
            }
                ?>

        </div>

    </section>

    <!-- main section-->

</body>

</html>