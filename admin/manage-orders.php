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
                        <?php $_SESSION['order-page'] = TRUE; ?>
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
        if (isset($_SESSION['order-msg'])) {
            echo $_SESSION['order-msg'];
            unset($_SESSION['order-msg']);
        }
        if (isset($_SESSION['deliver-msg'])) {
            echo $_SESSION['deliver-msg'];
            unset($_SESSION['deliver-msg']);
        }
        ?>
        <div class="wrapper">
            <section id="main-section">
                <div class="title">
                    <h4>Orders</h4>
                </div>
            </section>
            <?php
                if($_SESSION['usertype']=='Admin'){
                    //cut here
                    ?>
                    <section id="main-content">
                <div class="content-header">
                    <form action="" method="GET">
                        <div class="filtersort">
                            <div class="input-group input">
                                <select name="filter" id="">
                                    <option <?php if (isset($_GET['filter']) and $_GET['filter'] == "") {
                                                echo "selected";
                                            } ?>value="All Orders">All Orders</option>
                                    <option <?php if (isset($_GET['filter']) and $_GET['filter'] == "1") {
                                                echo "selected";
                                            } ?>value="Pending Orders">Pending Orders</option>
                                    <option <?php if (isset($_GET['filter']) and $_GET['filter'] == "2") {
                                                echo "selected";
                                            } ?>value="Preparing Orders">Preparing Orders</option>
                                    <option <?php if (isset($_GET['filter']) and $_GET['filter'] == "3") {
                                                echo "selected";
                                            } ?>value="On-Delivery">On-Delivery</option>
                                    <option <?php if (isset($_GET['filter']) and $_GET['filter'] == "4") {
                                                echo "selected";
                                            } ?>value="Delivered">Delivered</option>
                                </select>
                                <button type="status-btn"><i class="fa-solid fa-filter"></i></button>
                            </div>
                        </div>
                    </form>
                    <div class="btns">
                        <?php
                        $cr = 0;
                        $email = "";

                        $crsql = "SELECT * FROM tbl_order WHERE cancel_request='requesting' and order_status='Pending'";
                        $crrun = mysqli_query($conn, $crsql);

                        if (mysqli_num_rows($crrun) > 0) {
                            $cr = mysqli_num_rows($crrun);
                        }
                        ?>
                        <a href="cancel-requests.php?cr=true" style="background:#1000; color:black; text-decoration:underline;" class="btn-add">View Cancel Requests( <span style="color:red; font-weight:bold"><?php echo $cr; ?></span> )</a>
                        <?php
                        ?>
                    </div>
                </div>
                <section id="table-container">
                    <div class="table-header">
                        <div class="title">

                            <?php

                            if (isset($_GET['filter'])) {
                                if ($_GET['filter'] == "Pending Orders") {
                                    $sql = "SELECT * FROM tbl_order WHERE order_status='Pending' ORDER BY placed_order_date DESC";
                                    $sql_run = mysqli_query($conn, $sql);
                                    $x = "Pending Orders";
                                    $count = mysqli_num_rows($sql_run);
                                } elseif ($_GET['filter'] == "Preparing Orders") {
                                    $sql = "SELECT * FROM tbl_order WHERE order_status='Preparing' ORDER BY placed_order_date DESC";
                                    $sql_run = mysqli_query($conn, $sql);
                                    $x = "Preparing";
                                    $count = mysqli_num_rows($sql_run);
                                    
                                }
                                elseif ($_GET['filter'] == "On-Delivery") {
                                    $sql = "SELECT * FROM tbl_order WHERE order_status='On-Delivery' ORDER BY placed_order_date DESC";
                                    $sql_run = mysqli_query($conn, $sql);
                                    $x = "On-Delivery";
                                    $count = mysqli_num_rows($sql_run);
                                }
                                elseif ($_GET['filter'] == "Delivered") {
                                    $sql = "SELECT * FROM tbl_order WHERE order_status='Delivered' ORDER BY placed_order_date DESC";
                                    $sql_run = mysqli_query($conn, $sql);
                                    $x = "On-Delivery";
                                    $count = mysqli_num_rows($sql_run);
                                       
                                } elseif ($_GET['filter'] == "All Orders") {
                                    $sql = "SELECT * FROM tbl_order ORDER BY placed_order_date DESC";
                                    $sql_run = mysqli_query($conn, $sql);
                                    $x = "All Orders";
                                    $count = mysqli_num_rows($sql_run);
                                }
                            }
                            
                            if (!isset($_GET['filter'])) {
                                $sql = "SELECT * FROM tbl_order ORDER BY placed_order_date ASC";
                                $sql_run = mysqli_query($conn, $sql);
                                $x = "All Orders";
                                $count = mysqli_num_rows($sql_run);
                            }

                            ?>
                            <h4><?php echo $x; ?></h4>
                            <p><?php echo $count . " orders found"; ?></p>
                            <?php
                            ?>

                        </div>
                        <div class="input-group search-bar">
                            <form action="" method="GET" style="display:flex">
                                <input type="search" name="search_order" placeholder="Search here">
                                <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </form>
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
                                <?php
                                $x = "SELECT * FROM tbl_order WHERE cancel_request='requesting'";
                                $x_run = mysqli_query($conn, $x);
                                $num = mysqli_num_rows($x_run);
                                $hide = "hidden";
                                $cols = 3;
                                if ($num > 0) {
                                    $hide = "";
                                    $cols = 4;
                                }
                                ?><td width="5%" <?php echo $hide; ?>></td>
                                <td style="text-align: center" colspan="<?php echo $cols; ?>" width="10%"></td>
                                <?php
                                ?>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($_GET['filter']) and !isset($_GET['search_order'])) {
                                if ($_GET['filter'] == "Pending Orders") {
                                    $sql = "SELECT * FROM tbl_order WHERE order_status='Pending' ORDER BY placed_order_date DESC";
                                    $sql_run = mysqli_query($conn, $sql);
                                } elseif ($_GET['filter'] == "Preparing Orders") {
                                    $sql = "SELECT * FROM tbl_order WHERE order_status='Preparing' ORDER BY placed_order_date DESC";
                                    $sql_run = mysqli_query($conn, $sql);
                                } elseif ($_GET['filter'] == "All Orders") {
                                    $sql = "SELECT * FROM tbl_order ORDER BY placed_order_date DESC";
                                    $sql_run = mysqli_query($conn, $sql);
                                }
                                elseif ($_GET['filter'] == "On-Delivery") {
                                    $sql = "SELECT * FROM tbl_order WHERE order_status='On-Delivery' ORDER BY placed_order_date DESC";
                                    $sql_run = mysqli_query($conn, $sql);
                                }
                                elseif ($_GET['filter'] == "Delivered") {
                                    $sql = "SELECT * FROM tbl_order WHERE order_status='Delivered' ORDER BY placed_order_date DESC";
                                    $sql_run = mysqli_query($conn, $sql);
                                }
                                
                                
                            }

                            if (isset($_GET['search_order'])) {
                                $search_val = $_GET['search_order'];
                                $sql = "SELECT * FROM tbl_order WHERE CONCAT(order_id, order_status, placed_order_date, target_order_date, fullname, phone, to_city, to_barangay, to_street, instruction, customer_email) LIKE '%$search_val%'";
                                $sql_run = mysqli_query($conn, $sql);
                            }

                            // if (!isset($_GET['filter'])) {
                            //     $sql = "SELECT * FROM tbl_order WHERE order_status='Pending'";
                            //     $sql_run = mysqli_query($conn, $sql);
                            // }

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
                                            <h5>P<?php echo $fetch['total_price']?></h5>
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
                                        if ($fetch['cancel_request'] == 'requesting') {
                                        ?>
                                            <td style="text-align: center; width:7%">
                                                <button style="border:none; background-color:transparent">Requesting for cancelation</button>
                                            <td>
                                            <?php
                                        } elseif ($fetch['order_status'] == "Pending" and $fetch['cancel_request'] != 'requesting') {
                                            ?>
                                            <td style="text-align: center; width:7%">
                                                <button style="border:none; background-color:transparent"></button>
                                            <td>
                                            <?php
                                        }else{?>
                                            <td style="text-align: center; width:7%">
                                                <button style="border:none; background-color:transparent"></button>
                                            <td>
                                            <?php
                                            
                                        }


                                            ?>
                                            <?php
                                            if ($fetch['order_status'] == "Pending" and $fetch['cancel_request'] != 'requesting') {
                                            ?>
                                            <td style="text-align: center">
                                                <h5 style><a onClick="javascript: return confirm('Accept Order? ');" style="font-weight:bold; color:white; padding:2px;background-color:green; border-radius:3px;" href="prepare-order.php?order_id=<?php echo $fetch['order_id']; ?>">Accept</a></h5>
                                            <td>
                                            <td style="text-align: center">
                                                <h5><a onClick="javascript: return confirm('Cancel Order? ');" style="font-weight:bold; color:white; padding:2px;background-color:red; border-radius:3px;" href="cancel-order.php?order_id=<?php echo $fetch['order_id']; ?>">Cancel</a></h5>
                                            </td>
                                        <?php

                                            }elseif($fetch['order_status'] == "Preparing" and $fetch['cancel_request'] != 'requesting'){
                                                ?>
                                                <td style="text-align: center">
                                                <h5 style><a onClick="javascript: return confirm('Deliver Order? ');" style="font-weight:bold; color:white; padding:2px;background-color:blue; border-radius:3px;" href="deliver-order.php?order_id=<?php echo $fetch['order_id']; ?>">Deliver</a></h5>
                                                <td>
                                                
                                            <?php
                                            }elseif($fetch['order_status'] == "On-Delivery" and $fetch['cancel_request'] != 'requesting'){
                                                ?>
                                                <td style="text-align: center">
                                                <h5 style><a onClick="javascript: return confirm('Set status as Delivered? ');" style="font-weight:bold; color:white; padding:2px;background-color:purple; border-radius:3px;" href="delivered.php?order_id=<?php echo $fetch['order_id']; ?>">Delivered</a></h5>
                                                <td>
                                                
                                            <?php
                                            }
                                             elseif ($fetch['cancel_request'] == 'requesting') {
                                        ?>
                                            <td style="text-align: center">
                                                <h5 style><a onClick="javascript: return confirm('Grant Request? ');" style="font-weight:bold; color:white; padding:2px;background-color:green; border-radius:3px;" href="cancel-order.php?order_id=<?php echo $fetch['order_id']; ?>&grant=YES">Grant</a></h5>
                                            <td>
                                            <td style="text-align: center">
                                                <h5><a onClick="javascript: return confirm('Cancel Request? ');" style="font-weight:bold; color:white; padding:2px;background-color:red; border-radius:3px;" href="cancel-order.php?order_id=<?php echo $fetch['order_id']; ?>&grant=NO">Cancel</a></h5>
                                            </td>
                                        <?php
                                            }
                                            else{
                                                echo '<td></td>';
                                            }
                                        ?>
                                    </tr>
                            <?php
                                    $i++;
                                }
                            } else {
                                echo "<tr><td colspan='7'><div style='text-align:center'><h4>No orders found!</h4></div><td></tr>";
                            }
                            ?>

                        </tbody>
                    </table>
                </section>
            </section>
                    <?php
                    //cut here
                }elseif($_SESSION['usertype']=='Cashier'){
                    echo "<div id='main-content'><h3 style='text-align:center'>Access Denied. Please contact the administrator.</h3></div>";
                }
            ?>
            
        </div>

    </section>

    <!-- main section-->

</body>

</html>