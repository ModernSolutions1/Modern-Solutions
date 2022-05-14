<?php include('partials/header.php');
$order_status = "";
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
                        <li>
                            <i>#</i>
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
                        <i>#</i>
                        <h5>Orders</h5>
                        <?php $_SESSION['order-page'] = true; ?>
                    </li>
                </a>
                <a href="manage-delivery.php">
                    <li class="current-item">
                        <i class="current-item-i">#</i>
                        <h5>Delivery</h5>
                        <?php $_SESSION['deliver-page'] = true; ?>
                    </li>
                </a>
                <a href="manage-user.php">
                    <li>
                        <i>#</i>
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
                            <i>#</i>
                            <h5>Overview</h5>
                        </li>
                    </a>
                    <a href="manage-products.php">
                        <li>
                            <i>#</i>
                            <h5>Products</h5>
                        </li>
                    </a>
                    <a href="manage-category.php">
                        <li>
                            <i>#</i>
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
                    <i> # </i>
                    <a onClick="javascript: return confirm('Are you sure you want to logout? ');" href="logout.php"> Log Out</a>
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
        <?php
        if (isset($_SESSION['deliver-msg'])) {
            echo $_SESSION['deliver-msg'];
            unset($_SESSION['deliver-msg']);
        }
        ?>
        <div class="wrapper">
            <section id="main-section">
                <div class="title">
                    <h4>Deliveries</h4>
                </div>
            </section>
            <section id="main-content">
                <div class="content-header">
                    <div style="display:flex; justify-content:space-between">
                        <form action="" method="GET">
                            <div class="filtersort">
                                <div class="input-group input">
                                    <select name="filter" id="">
                                        <option <?php if (isset($_GET['filter']) and $_GET['filter'] == "") {
                                                    echo "selected";
                                                } ?>value="Pending Deliveries">Pending Deliveries</option>
                                        <option <?php if (isset($_GET['filter']) and $_GET['filter'] == "1") {
                                                    echo "selected";
                                                } ?>value="On-Delivery">On-Delivery</option>
                                        <option <?php if (isset($_GET['filter']) and $_GET['filter'] == "2") {
                                                    echo "selected";
                                                } ?>value="Delivered">Delivered</option>
                                    </select>
                                    <button><i>#</i></button>
                                </div>
                            </div>
                        </form>
                        <form action="" method="GET">
                            <div class="btns">
                                <a href="manage-delivery.php?fd=this_month" class="btn-add">This Month</a>
                                <a href="manage-delivery.php?fd=today" class="btn-add">Today</a>
                            </div>
                        </form>

                    </div>

                </div>
                <section id="table-container">
                    <div class="table-header">
                        <div class="title">

                            <?php
                            if (isset($_GET['filter'])) {
                                if ($_GET['filter'] == "Pending Deliveries") {
                                    $sql = "SELECT * FROM tbl_order WHERE order_status='Preparing'";
                                    $sql_run = mysqli_query($conn, $sql);
                                    $x = "Pending Delivery";
                                    $count = mysqli_num_rows($sql_run);
                                } elseif ($_GET['filter'] == "On-Delivery") {
                                    $sql = "SELECT * FROM tbl_order WHERE order_status='On-Delivery'";
                                    $sql_run = mysqli_query($conn, $sql);
                                    $x = "On-Delivery";
                                    $count = mysqli_num_rows($sql_run);
                                } elseif ($_GET['filter'] == "Delivered") {
                                    $sql = "SELECT * FROM tbl_order WHERE order_status='Delivered'";
                                    $sql_run = mysqli_query($conn, $sql);
                                    $x = "Delivered";
                                    $count = mysqli_num_rows($sql_run);
                                }
                            } elseif (!isset($_GET['filter'])) {
                                $sql = "SELECT * FROM tbl_order WHERE order_status='Preparing'";
                                $sql_run = mysqli_query($conn, $sql);
                                $x = "Pending Delivery";
                                $count = mysqli_num_rows($sql_run);
                            }

                            ?>
                            <h4><?php echo $x; ?></h4>
                            <p><?php echo $count . " orders found"; ?></p>
                            <?php
                            ?>

                        </div>
                    </div>
                    <table id="tbl_orders">
                        <thead>
                            <tr width="100%">
                                <td width="2%">#</td>
                                <td width="5%">Status</td>
                                <td width="15%">Name</td>
                                <td width="10%">Contact</td>
                                <td width="40%">Address</td>
                                <td width="8%">Payment</td>
                                <td width="7%">Total</td>
                                <td width="4%">More</td>
                                <td style="text-align: center" colspan="3" width="10%">Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            if (isset($_GET['filter'])) {
                                if ($_GET['filter'] == "Pending Orders") {
                                    $sql = "SELECT * FROM tbl_order WHERE order_status='Preparing' ORDER BY placed_order_date";
                                    $sql_run = mysqli_query($conn, $sql);
                                } elseif ($_GET['filter'] == "On-Delivery") {
                                    $sql = "SELECT * FROM tbl_order WHERE order_status='On-Delivery' ORDER BY placed_order_date";
                                    $sql_run = mysqli_query($conn, $sql);
                                } elseif ($_GET['filter'] == "Delivered") {
                                    $sql = "SELECT * FROM tbl_order WHERE order_status='Delivered' ORDER BY placed_order_date DESC";
                                    $sql_run = mysqli_query($conn, $sql);
                                }
                            }

                            if(isset($_GET['fd'])){
                                $cdate = date('Y-m-d');
                                $month = date('m');
                                $day = date('d');
                                if($_GET['fd']=='today'){
                                        $sql = "SELECT * FROM tbl_order WHERE DAY(placed_order_date)='$day' and order_status = 'Preparing' ORDER BY confirmed_date";
                                        $sql_run = mysqli_query($conn, $sql);                                
                                }elseif($_GET['fd']=='this_month'){
                                    if($month == $month){
                                        $sql = "SELECT * FROM tbl_order WHERE MONTH(placed_order_date)='$month' and order_status = 'Preparing' ORDER BY placed_order_date";
                                        $sql_run = mysqli_query($conn, $sql);
                                    } 
                                }
                            }
                            
                            if (isset($_GET['search_order'])) {
                                $search_val = $_GET['search_order'];
                                $sql = "SELECT * FROM tbl_order WHERE CONCAT(order_id, fullname, phone, to_city, to_barangay, to_street, instruction, customer_email) LIKE '%$search_val%'";
                                $sql_run = mysqli_query($conn, $sql);
                            }


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
                                        <td width="2%">
                                            <h5><?php echo $i; ?></h5>
                                        </td>
                                        <td width="10%">
                                            <h5><span class="<?php echo $status; ?>"><?php echo $fetch['order_status'] ?></span></h5>
                                        </td>
                                        <td width="15%">
                                            <h5><?php echo $fetch['fullname'] ?></h5>
                                        </td>
                                        <td width="10%">
                                            <h5><?php echo $fetch['phone'] ?></h5>
                                        </td>
                                        <td width="40%">
                                            <h5><?php echo $fetch['to_street'] . ', ' . $fetch['to_barangay'] . ' ' . $fetch['to_city']; ?></h5>
                                        </td>
                                        <td width="8%">
                                            <h5><?php echo $fetch['payment'] ?></h5>
                                        </td>
                                        <td width="7%">
                                            <h5>P<?php echo $fetch['total_price'] ?></h5>
                                        </td>
                                        <?php
                                        if (isset($_SESSION['deliver-page'])) {
                                            unset($_SESSION['order-page']);
                                        ?><td width="10%">
                                                <h5><a href="order-info.php?order_id=<?php echo $fetch['order_id'] ?>&delivery_page=TRUE">More Details</a></h5>
                                            </td><?php
                                                }
                                                    ?>
                                        <?php
                                        if ($fetch['order_status'] == "Preparing") {
                                        ?>
                                            <td style="text-align: center">
                                                <h5 style><a onClick="javascript: return confirm('Deliver Order? ');" style="font-weight:bold; color:white; padding:2px;background-color:green; border-radius:3px;" href="deliver-order.php?order_id=<?php echo $fetch['order_id']; ?>">Deliver</a></h5>
                                            <td>
                                            <?php
                                        } elseif ($fetch['order_status'] == "On-Delivery") {
                                            ?>
                                            <td style="text-align: center">
                                                <h5 style><a onClick="javascript: return confirm('Set status as Delivered? ');" style="font-weight:bold; color:white; padding:2px;background-color:green; border-radius:3px;" href="delivered.php?order_id=<?php echo $fetch['order_id']; ?>">Delivered</a></h5>
                                            <td>
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