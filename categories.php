<?php include('front-partials/header.php') ?>

<?php

if (isset($_SESSION['already-on-cart'])) {
    echo $_SESSION['already-on-cart'];
    unset($_SESSION['already-on-cart']);
}
if (isset($_SESSION['add-on-cart'])) {
    echo $_SESSION['add-on-cart'];
    unset($_SESSION['add-on-cart']);
}
$email = "";
if (isset($_SESSION['authenticated'])) {
    $email = $_SESSION['auth_user']['email'];
}
$counter = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tbl_order_item WHERE customer_email='$email'"));
$cat = "";
?>

<!-- HEADER -->
<section id="main-header">
    <div class="container">
        <nav>
            <ul>
                <li><a href="<?php echo SITEURL ?>">Home</a></li>
                <li><a class="current" href="<?php echo SITEURL; ?>products.php">Products</a></li>
                <?php if (!isset($_SESSION['authenticated'])) {
                    $hide = "hidden";
                } else {
                    $hide = "";
                } ?>
                <li <?php echo $hide; ?>><a href="<?php echo SITEURL ?>cart.php">Cart <span class="cart-counter" <?php if ($counter < 1) {
                                                                                                                    echo 'style="background-color:transparent"';
                                                                                                                } ?>><?php if ($counter > 0) {
                                                                                                        echo $counter;
                                                                                                    } ?></span></a></li>
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
                                                                } else {
                                                                    ?><a onClick="javascript: return confirm('Are you sure you want to logout? '); " href="logout.php" class="btn-login">Log Out</a><?php
                                                                                                                                            }
                                                                                                                                                ?>
    </div>
</section>

<section class="title">
    <div class="container">
        <ul>
            <li><a href="products.php">Products</a></li>
            <li>&#155</li>
            <li>Category</li>
            <?php
            if ((isset($_GET['id']) and $_GET['id'] != "") || (isset($_GET['categ_id']) and $_GET['categ_id'] != "")) {

                if (isset($_GET['id']) and $_GET['id'] != "") {
                    $id2 =  $_GET['id'];
                    $sql3 = "SELECT * FROM tbl_category WHERE category_id = $id2";
                    $run3 = mysqli_query($conn, $sql3);
                    $fetch = mysqli_fetch_assoc($run3);
                    $c_name = $fetch['category_name'];
                    $cat = $fetch['category_name'];
                    echo "<li>&#155</li>" . $c_name;
                } elseif (isset($_GET['categ_id']) and $_GET['categ_id'] != "") {
                    $id2 =  $_GET['categ_id'];
                    $sql3 = "SELECT * FROM tbl_category WHERE category_id = $id2";
                    $run3 = mysqli_query($conn, $sql3);
                    $fetch = mysqli_fetch_assoc($run3);
                    $cat = $fetch['category_name'];
                    echo "<li>&#155</li>" . $cat;
                }
            } else {
                echo "";
            }
            ?>
        </ul>
    </div>
</section>

<section id="category-list">
    <div class="container">
        <div class="category-left">
            <div class="head">
                <h4>Categories</h4>
            </div>
            <div class="categ_list">
                <a href="categories.php?categ_id=<?php echo ""; ?>">
                    <li id="list">All Categories</li>
                </a>
                <?php
                $sql = "SELECT * FROM tbl_category WHERE active='Yes' ORDER BY category_name ASC";
                $run = mysqli_query($conn, $sql);

                if (mysqli_num_rows($run) > 0) {
                    while ($row = mysqli_fetch_assoc($run)) {
                        $categ_id = $row['category_id'];
                ?>
                        <ul>
                            <a href="categories.php?categ_id=<?php echo $row['category_id']; ?>">
                                <li id="list"><?php echo $row['category_name'] ?></li>
                            </a>
                        </ul>
                <?php
                    }
                }
                ?>
            </div>
        </div>
        <div class="category-right">
            <div class="srch">
                <h6><a href="all-products.php" class="hwp hwp-bg-blue all-p">All Products</a></h6>
                <form action="" method="GET">
                    <div class="search-group">
                        <input type="search" name="search" id="" class="custom-border" placeholder="Search here">
                        <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </form>             
            </div>
            <div class="pproducts">
            <h4 style="text-align: center; padding: 10px;"><?= $cat; ?></h4>
            <div style="width:100%; border-bottom: 1px solid #ccc; margin-bottom:10px;"></div>
                <div class="cont">


                    <?php

                    if (isset($_GET['id']) and $_GET['id'] != "") {
                        $id =  $_GET['id'];
                        $sql2 = "SELECT * FROM tbl_products WHERE category_id = $id and active='Yes' ORDER BY product_name ASC";
                        $run2 = mysqli_query($conn, $sql2);
                    }
                    elseif(isset($_GET['search'])){
                        
                        if(isset($_GET['id']) and $_GET['id']!=""){
                            $id =  $_GET['id'];
                            $search_val = $_GET['search'];
                            $sql2 = "SELECT * FROM tbl_products WHERE (product_name LIKE '%$search_val%' and category_id='$id') and active='Yes' ORDER BY product_name ASC";
                            $run2 = mysqli_query($conn, $sql2);
                        }else{
                            $search_val = $_GET['search'];
                            $sql2 = "SELECT * FROM tbl_products WHERE product_name LIKE '%$search_val%' and active='Yes' ORDER BY product_name ASC";
                            $run2 = mysqli_query($conn, $sql2);
                        }
                        
                    } else {
                        if (!isset($_GET['categ_id'])) {

                            $sql2 = "SELECT * FROM tbl_products WHERE active='Yes' ORDER BY product_name ASC";
                            $run2 = mysqli_query($conn, $sql2);
                            $_GET['categ_id'] = "";
                        } else {

                            if ($_GET['categ_id'] == "") {

                                $sql2 = "SELECT * FROM tbl_products WHERE active='Yes' ORDER BY product_name ASC";
                                $run2 = mysqli_query($conn, $sql2);
                            } else {
                                $id = $_GET['categ_id'];
                                $sql2 = "SELECT * FROM tbl_products WHERE category_id = $id AND active='Yes' ORDER BY product_name ASC";
                                $run2 = mysqli_query($conn, $sql2);

                                $category_sql = "SELECT * FROM tbl_category WHERE category_id = $id";
                                $category_run = mysqli_query($conn, $category_sql);
                                $category_fetch = mysqli_fetch_assoc($category_run);
                                $cat = $category_fetch['category_name'];
                            }
                        }
                    }



                    if (mysqli_num_rows($run2) > 0) {
                        while ($rows = mysqli_fetch_assoc($run2)) {
                            $categ = $rows['category_id'];
                            $categ_sql = "SELECT * FROM tbl_category WHERE category_id = '$categ'";
                            $categ_run = mysqli_query($conn, $categ_sql);
                            $categ_fetch = mysqli_fetch_assoc($categ_run);
                            $categname = $categ_fetch['category_name']
                    ?>
                            <div class="p_container">
                                <figure>
                                    <img src="img/products/<?php echo $rows['product_img']; ?>" alt="" width="100px" height="100px">
                                </figure>
                                <div class="p_desc">
                                    <h6><?php echo $rows['product_name'] ?></h6>
                                    <?php

                                    if (!isset($_GET['categ_id'])) {
                                        echo "<h6>$cat</h6>";
                                    } else {
                                        echo "<h6>$categname</h6>";
                                    }
                                    ?>
                                </div>
                                <form action="p-add-to-cart.php" method="POST">
                                    <div class="p_foot">
                                        <small>P<?php echo $rows['product_price'] ?></small>
                                        <input type="submit" name="p_add2" id="" value="ADD +" class="p_add custom-border" style="padding: 5px !important">
                                    </div>
                                    <input type="hidden" name="p_categ_name" value="<?php echo $rows['category_id']; ?>">
                                    <input type="hidden" name="p_id" value="<?php echo $rows['product_id']; ?>">
                                </form>
                            </div>
                    <?php
                        }
                    } else {
                        echo "<h5>No Products Available</h5>";
                    }
                    ?>


                </div>
            </div>
        </div>
    </div>
</section>

<?php include('front-partials/footer.php') ?>