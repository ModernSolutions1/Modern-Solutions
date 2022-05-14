<?php include('partials/header.php');
$counter = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tbl_basket"));
?>

<style>
    .tbl-tr:nth-child(even) {
        background-color: #f4f4f4;
    }
</style>
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
                    <li class="current-item">
                        <i class="fa-solid fa-store current-item-i"></i>
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
        <section id="main-section" style="display:flex; justify-content:space-between; padding-top:30px">
            <!-- <div class="title">
                <a href="manage-category.php" class="btn-add">Back</a>
            </div> -->
            <?php
                if(isset($_GET['record'])){
                    echo '<a href="records.php" class="btn-add">Back</a>';
                }else{
                    echo '<a href="store.php" class="btn-add">Back</a>';
                }
            ?>
            
        </section>
        <?php

        if (isset($_SESSION['category-exists'])) {
            echo $_SESSION['category-exists'];
            unset($_SESSION['category-exists']);
        }
        ?>
        <section id="main-content">
            <?php if ($counter > 0) {
            ?>
                <div style="display: flex; justify-content: right"><button style="padding: 5px 10px; margin: 5px 0; border: none; color: white; background-color: blue; border-radius: 4px; cursor: pointer" onclick="window.location.replace('cart.php')">Cart <span>(<?php echo $counter; ?>)</span></button></div>
            <?php
            } ?>

            <?php
            if (!isset($_GET['record'])) {
            ?>

                <form action="" action="get" style="width: 100%;">
                    <div class="input-group search-bar">
                        <input style="width:100%" type="search" name="search" <?php if (isset($GET['search'])) {
                                                                                    echo $GET['search'];
                                                                                } ?>placeholder="Search here">
                        <button class="" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </form>
                <table style="margin-top: 30px; width: 100%; text-align:left; border-collapse: collapse">
                    <thead style="border-bottom: 1px solid #ccc; ">
                        <tr>
                            <th style="padding-bottom: 15px">Date</th>
                            <th style="padding-bottom: 15px">User</th>
                            <th style="padding-bottom: 15px">Total</th>
                            <th style="padding-bottom: 15px">View</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        if (!isset($_GET['search'])) {
                            $sql = "SELECT * FROM tbl_storecheckout ORDER BY date ASC LIMIT 20";
                        } else {
                            $search = $_GET['search'];
                            $sql = "SELECT * FROM tbl_storecheckout WHERE CONCAT(date, username) LIKE '%$search%' LIMIT 20";
                        }

                        $sql_run = mysqli_query($conn, $sql);

                        while ($row = mysqli_fetch_assoc($sql_run)) {
                        ?>
                            <tr class="tbl-tr">
                                <td style="padding:10px 0"><?php echo $row['date']; ?></td>
                                <td style="padding:10px 0"><?php echo $row['username']; ?></td>
                                <td style="padding:10px 0">P<?php echo $row['total_price']; ?></td>
                                <td style="padding:10px 0"><a href="records.php?record=<?= $row['id']; ?>" style="border: 1px solid red; padding: 5px 10px; border-radius:4px; color: black">View</a></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            <?php
            } else {

                $id = $_GET['record'];

                $sql = "SELECT * FROM tbl_storecheckout WHERE id = $id";
                $sql_run = mysqli_query($conn, $sql);

                $fet = mysqli_fetch_assoc($sql_run);

            ?>
                <h3>Date: <?php echo $fet['date']; ?></h3>
                <br>
                <h3>User: <?php echo $fet['username']; ?></h3>
                <br>
                <h3>Products</h3>
                <br>
                        <?php

                        $items = explode(',',  $fet['products']);
                        $count = count($items);
                        $i = 0;

                        while ($count != 0) {
                        ?>
                            <h4><?php echo $items[$i]; ?></h4>
                            <?php
                            $i++;
                            $count--;
                        }
                            ?>
                <br>
                <h3>Total: <span style="color:red">P<?php echo $fet['total_price'];?></span></h3>
            <?php

            }
            ?>

        </section>
    </div>

</section>