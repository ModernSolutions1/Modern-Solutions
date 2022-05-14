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
                        <li class="current-item">
                            <i class="fa-solid fa-border-all current-item-i"></i>
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
    <section id="main" class="main">
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
                <div class="title">
                    <h4>Overview</h4>
                </div>
            </section>
            <section id="main-content">

            <?php

                $sql = "SELECT * FROM tbl_products";
                $res = mysqli_query($conn, $sql);
                $total_product = mysqli_num_rows($res);
                $counter = 0;

                while($row = mysqli_fetch_assoc($res)){
                    if($row['product_qty'] <= 10){
                        $counter++;
                    }
                }

                $sql2 = "SELECT * FROM tbl_category";
                $res2 = mysqli_query($conn, $sql2);
                $total_category = mysqli_num_rows($res2);

            ?>
            <div class="boxes">
                    <div class="box">
                    <i class="fa-solid fa-box-open"></i>
                        <div>
                            <h4><?php echo $total_product; ?></h4>
                            <p><a href="manage-products.php">Total Products</a></p>
                        </div>        
                    </div>
                    <div class="box">
                    <i class="fa-solid fa-grip-vertical"></i>
                        <div>
                            <h4><?php echo $total_category; ?></h4>
                            <p><a href="manage-category.php">Total Categories</a></p>
                        </div>        
                    </div>
                    <!-- <div class="box">
                        <i>#</i>
                        <div>
                            <h4><?php echo $counter; ?></h4>
                            <p>Low Qty Products</p>
                        </div>        
                    </div> -->
                </div>
            </section>
        </div>
        <br>
        <p class="to-center"><span class="highlight">*</span>Nothing Follows<span class="highlight">*</span></p>
</section>

    <!-- main section-->

</body>
</html>