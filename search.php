<?php include('front-partials/header.php');?>


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
    $cat = "";
    $email = "";
    if(isset($_SESSION['authenticated'])){
        $email = $_SESSION['auth_user']['email'];
    }
    $counter = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tbl_order_item WHERE customer_email='$email'"));
    $all_p_count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tbl_products WHERE active='Yes'"));

    if (isset($_GET['showcase_id'])) {
        $x = $_GET["showcase_id"];
        $fetch = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tbl_category WHERE category_id = $x AND active='Yes'"));
        $CATEGORY_NAME = $fetch['category_name'];
        $PRODUCT_COUNT = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tbl_products WHERE category_id = $x AND active='Yes'"));
    }
    if (isset($_GET['featured'])){
        $F_PRODUCT_COUNT = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tbl_products WHERE featured='Yes' AND active='Yes'"));
    }

    if (isset($_GET['filter_category']) && !($_GET['filter_category'] == 0)) {

        if ($_GET['filter_category'] != 0) {

            $x = $_GET["filter_category"];
            $fetch = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tbl_category WHERE category_id = $x AND active='Yes'"));
            $CATEGORY_NAME = $fetch['category_name'];
            $PRODUCT_COUNT = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tbl_products WHERE category_id = $x AND active='Yes'"));
        }
    } elseif (isset($_GET['filter_category']) && $_GET['filter_category'] == 0) {
        header('location:' . SITEURL . 'all-products.php');
    }
    ?>

</div>

<!-- HEADER -->
<section id="main-header">
    <div class="container">
        <nav>
            <ul>
                <li><a href="<?php echo SITEURL ?>">Home</a></li>
                <li><a class="current" href="<?php echo SITEURL; ?>products.php">Products</a></li>
                <?php if(!isset($_SESSION['authenticated'])){ $hide = "hidden";}else{ $hide="";}?>
                <li <?php echo $hide; ?>><a href="<?php echo SITEURL ?>cart.php">Cart <span class="cart-counter" <?php if ($counter < 1) {
                                                                                                    echo 'style="background-color:transparent"';
                                                                                                } ?>><?php if ($counter > 0) {
                                                                                                                                                                            echo $counter;
                                                                                                                                                                        } ?></span></a></li>
                <?php
                if (isset($_SESSION['authenticated'])) {
                ?>
                    <li><a href="myorder.php?tab=1">My Order</a></li>
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
                ?><a onClick="javascript: return confirm('Are you sure you want to logout? ');" href="logout.php" class="btn-login">Log Out</a><?php
            }
        ?>
    </div>
</section>

<section class="title">
    <div class="container">
        <ul>
            <li><a href="products.php">Products</a></li>
            <li>&#155</li>
            <?php
            if (isset($_GET['showcase_id']) and $_GET['showcase_id'] !=0 ) {
                if($cat==""){                     
                    echo "<li><a href='all-products.php'>All Products</a></li><li>&#155</li><li>" . $CATEGORY_NAME . "</li>";
                }
                else{
                    if(isset($_GET['featured'])){
                        echo "<li><a href='all-products.php'>Featured Products</a></li><li>&#155</li><li>";
                    }else{
                        echo "<li><a href='all-products.php'>All Products</a></li><li>&#155</li><li>";
                    }
                    
                }
            } else if (isset($_GET['filter_category'])) {
                $x = $cat;
                echo "<li><a href='all-products.php'>All Products</a></li><li>&#155</li><li>" . $CATEGORY_NAME . "</li>";
            } elseif(isset($_GET['filter_category']) and isset($_GET['featured'])){
                $x = $cat;
                echo "<li><a href='all-products.php'>All Products</a></li><li>&#155</li><li>Featured Products" . $CATEGORY_NAME . "</li>";
            }else if(isset($_GET['featured'])){
                echo "<li><a href='all-products.php'>All Products</a></li><li>&#155</li><li>Featured</li>";
            } else {
                echo "<li>All Products</li>";
            }
            ?>
        </ul>
    </div>
</section>


<div class="container">
    <section class="product-table">
        <div class="header">
            <h5><?php
                if (isset($_GET['showcase_id']) || isset($_GET['filter_category'])) {
                    echo $CATEGORY_NAME;
                }elseif(isset($_GET['featured']) ||isset($_GET['filter_category']) ){
                    echo "Featured Products";
                }else {
                    echo "All Products";
                }
                ?></h5>
            <h6><?php
                if (isset($_GET['showcase_id']) || isset($_GET['filter_category'])) {
                    echo $PRODUCT_COUNT;
                }elseif(isset($_GET['featured'])){
                    echo $F_PRODUCT_COUNT;
                }else {
                    echo $all_p_count;
                }
                ?> total products</h6>
        </div>
        <form action="" method="GET">
            <div class="sub-header">
                <div class="filter-sort">
                    <div class="div1">
                        <select name="filter_category" id="" class="custom-border" style="color:#555;">
                            <option value="0">--All Category--</option>
                            <?php
                            $filter_sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                            $filter_sql_res = mysqli_query($conn, $filter_sql);
                            if (mysqli_num_rows($filter_sql_res) > 0) {
                                while ($fetch2 = mysqli_fetch_assoc($filter_sql_res)) {

                            ?>
                                    <option value="<?php echo $fetch2['category_id'] ?>" <?php if (isset($_GET['filter_category']) && $_GET['filter_category'] == $fetch2['category_id']) {
                                                                                            echo "selected";
                                                                                        } ?>><?php echo $fetch2['category_name'] ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                        <button class="custom-border">Filter</button>
                    </div>
                    <div class="div1">
                        <?php
                        if (!isset($_GET['showcase_id']) and !isset($_GET['featured'])) {
                        ?>
                            <h6><a href="all-products.php?featured=Yes" class="hwp hwp-bg-blue">Featured Products</a></h6>
                        <?php
                        } elseif(isset($_GET['featured'])){
                            ?>
                            <h6><a href="all-products.php" class="hwp hwp-bg-blue">All Products</a></h6>
                        <?php
                        }else {
                        ?>
                            <h6><a href="all-products.php" class="hwp hwp-bg-blue">All Products</a></h6>
                        <?php
                        }
                        ?>
                        <h6><a href="categories.php" class="hwp hwp-bg-green">Shop by Category</a></h6>
                        <?php       
                        ?>
                    </div>
                </div>
                <!-- <form action="" method="POST">
                <div class="srch">
                  
                        <div class="search-group">
                                <input type="search" name="searchx" placeholder="Search here" class="custom-border">
                               <input type="submit" name="search" id="" value="searhc">
                                <button type="submit" name="search">#</button>
                        </div>
                   
                </div>
                </form> -->

                <div class="srch">
                        <div class="search-group">
                            <form action="" method="POST">
                                <input type="search" name="searchx" placeholder="Search here..." class="custom-border">
                                <input type="submit" name="btn-search" id="">
                            </form>
                        </div>
                </div>
            </div>


        <section class="all-products">

            <?php
            if (isset($_GET['showcase_id'])) {

                $_SESSION['showcase'] = $_GET['showcase_id'];
                $showcase_id = $_GET['showcase_id'];
                $mysql = "SELECT * FROM tbl_products WHERE category_id=$showcase_id and active='Yes' LIMIT 30";
                $mysql_res = mysqli_query($conn, $mysql);
                $_SESSION['show_count'] = mysqli_num_rows($mysql_res);
            }
            elseif(isset($_GET['featured'])){
                
                if (!isset($_GET['filter_category'])) {
                    $mysql = "SELECT * FROM tbl_products WHERE featured='Yes' and active='Yes' LIMIT 30";
                } else {
                if ($_GET['filter_category'] != 0) {
                    $selected_val = $_GET['filter_category'];
                    $mysql = "SELECT * FROM tbl_products WHERE category_id=$selected_val and active='Yes' LIMIT 30";
                } else {
                    if ($_GET['filter_category'] == 0) {
                        $mysql = "SELECT * FROM tbl_products WHERE featured='Yes' and active='Yes' LIMIT 30";
                $mysql_res = mysqli_query($conn, $mysql);
                $_SESSION['show_count'] = mysqli_num_rows($mysql_res);
                    }
                }
            }
            } else {

                if (!isset($_GET['filter_category'])) {
                    $mysql = "SELECT * FROM tbl_products WHERE active='Yes' LIMIT 30";
                } else {

                    $_SESSION['filtered'] = $_GET['filter_category'];
                    if ($_GET['filter_category'] != 0) {
                        $selected_val = $_GET['filter_category'];
                        $mysql = "SELECT * FROM tbl_products WHERE category_id=$selected_val and active='Yes' LIMIT 30";
                    } else {
                        if ($_GET['filter_category'] == 0) {
                            $mysql = "SELECT * FROM tbl_products WHERE active='Yes' LIMIT 30";
                        }
                    }
                }
            }

            $mysql_res = mysqli_query($conn, $mysql);
            $count = mysqli_num_rows($mysql_res);

            if ($count > 0) {

                while ($row = mysqli_fetch_assoc($mysql_res)) {

                    $categ_id = $row['category_id'];

                    $category_sql = "SELECT * FROM tbl_category WHERE category_id=$categ_id AND active='Yes'";
                    $category_sql_res = mysqli_query($conn, $category_sql);
                    $rows = mysqli_fetch_assoc($category_sql_res);

                    $category_name = $rows['category_name'];

                    $cat = $category_name;

                    $image = $row['product_img'];

            ?>
                    <div class="p_container">
                        <figure>
                            <img src="<?php echo SITEURL; ?>img/products/<?php echo $image; ?>" alt="" width="100px" height="100px">
                        </figure>
                        <div class="p_desc">
                            <h5><?php echo $row['product_name']; ?></h5>
                            <h6><?php echo $category_name ?></h6>
                        </div>
                        <form action="p-add-to-cart.php" method="POST">
                            <div class="p_foot">
                                <h5>P<?php echo $row['product_price'] ?></h5>
                                <input type="submit" name="p_add" id="" value="ADD +" class="p_add custom-border">
                            </div>
                            <input type="hidden" name="p_categ_name" value="<?php echo $category_name ?>">
                            <input type="hidden" name="p_id" value="<?php echo $row['product_id'] ?>">
                        </form>
                    </div>

                <?php
                }
            } else {
                ?>
                <div style="width:100%; display:flex; justify-content: center">
                    <h5>No Products Available.</h5>
                </div>
            <?php
            }
            ?>
        </section>
    </section>
</div>
<br>
<?php include('front-partials/footer.php') ?>