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
                        <li class="current-item">
                            <i class="fa-solid fa-list current-item-i"></i>
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
                            <i><i class="fa-solid fa-store"></i></i>
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
        <?php

        if (isset($_SESSION['product-added'])) {
            echo $_SESSION['product-added'];
            unset($_SESSION['product-added']);
        }
        if (isset($_SESSION['product-delete'])) {
            echo $_SESSION['product-delete'];
            unset($_SESSION['product-delete']);
        }
        if (isset($_SESSION['product_upload'])) {
            echo $_SESSION['product_upload'];
            unset($_SESSION['product_upload']);
        }
        if (isset($_SESSION['deletion'])) {
            echo $_SESSION['deletion'];
            unset($_SESSION['deletion']);
        }
        if (isset($_SESSION['product-update'])) {
            echo $_SESSION['product-update'];
            unset($_SESSION['product-update']);
        }
        ?>
        <div class="wrapper">
            <section id="main-section">
                <div class="title">
                    <h4>Products</h4>
                </div>
            </section>
            <section id="main-content">
                <div class="content-header">
                    <form action="" method="GET">
                        <div class="filtersort">
                            <div class="input-group input">
                                <select name="sort" id="">
                                    <option value="">-Select Option-</option>
                                    <option value="a-z" <?php if (isset($_GET['sort']) && $_GET['sort'] == "a-z") {
                                                            echo "selected";
                                                        } ?>> Name (ASC)</option>
                                    <option value="z-a" <?php if (isset($_GET['sort']) && $_GET['sort'] == "z-a") {
                                                            echo "selected";
                                                        } ?>> Name (DESC)</option>
                                    <option value="0-9" <?php if (isset($_GET['sort']) && $_GET['sort'] == "0-9") {
                                                            echo "selected";
                                                        } ?>> Price (ASC)</option>
                                    <option value="9-0" <?php if (isset($_GET['sort']) && $_GET['sort'] == "9-0") {
                                                            echo "selected";
                                                        } ?>> Price (DESC)</option>
                                    <option value="0" <?php if (isset($_GET['sort']) && $_GET['sort'] == "0") {
                                                            echo "selected";
                                                        } ?>> Quantity (ASC)</option>
                                    <option value="1" <?php if (isset($_GET['sort']) && $_GET['sort'] == "1") {
                                                            echo "selected";
                                                        } ?>> Quantity (DESC)</option>
                                </select>
                                <button type="submit"><i class="fa-solid fa-sort"></i></button>
                            </div>
                        </div>
                    </form>
                    <?php
                        if($_SESSION['usertype']=='Admin'){
                            echo '<a href="add-product.php" class="btn-add">+ Add New</a>';
                        }
                    ?>
                    
                </div>
                <section id="table-container">

                    <?php
                    // get columns of the table
                    $show_col = 'SHOW COLUMNS FROM tbl_products';
                    $show_col_res = mysqli_query($conn, $show_col);
                    $show_col_count = mysqli_num_rows($show_col_res);

                    $columns = array();

                    while ($rows = mysqli_fetch_assoc($show_col_res)) {
                        $columns[] = $rows['Field'];
                    }

                    // assign value of the gotten column
                    $col_product_name = $columns[2];
                    $col_product_price = $columns[3];
                    $col_product_qty = $columns[5];

                    $sort_option = "";
                    $col_name = "";

                    if (isset($_GET['sort'])) {
                        $sorting = $_GET['sort'];
                    } else {
                        $sorting = "";
                    }
                    if (isset($_GET['search'])) {
                        $search = $_GET['search'];
                    } else {
                        $search = "";
                    }

                    // for the query
                    if (isset($_GET['sort'])) {
                        if ($_GET['sort'] == 'a-z') {
                            $sort_option = "ASC";
                            $col_name = $col_product_name;
                        } elseif ($_GET['sort'] == 'z-a') {
                            $sort_option = "DESC";
                            $col_name = $col_product_name;
                        } elseif ($_GET['sort'] == '0-9') {
                            $sort_option = "ASC";
                            $col_name = $col_product_price . "+0";
                        } elseif ($_GET['sort'] == '9-0') {
                            $sort_option = "DESC";
                            $col_name = $col_product_price . "+0";
                        } elseif ($_GET['sort'] == '0') {
                            $sort_option = "ASC";
                            $col_name = $col_product_qty;
                        } elseif ($_GET['sort'] == '1') {
                            $sort_option = "DESC";
                            $col_name = $col_product_qty;
                        } else {
                            $sort_option = " ";
                            $col_name = $col_product_name;
                        }
                    }

                    if (isset($_GET['search'])) {
                        $searchval = $_GET['search'];
                        $query = "SELECT * FROM tbl_products WHERE CONCAT(product_name, product_price, product_qty, active, featured) LIKE '%$searchval%' ";
                    }

                    $results_per_page = 5;

                    $sql = "SELECT * FROM tbl_products";
                    $res = mysqli_query($conn, $sql);
                    $count = mysqli_num_rows($res);
                    $i = 1;

                    $number_of_pages = ceil($count / $results_per_page);

                    if (!isset($_GET['page'])) {
                        $page = 1;
                    } else {
                        $page = $_GET['page'];
                    }

                    $this_page_first_result = ($page - 1) * $results_per_page;

                    if (isset($_GET['sort']) or isset($_SESSION['default'])) {
                        $sql = "SELECT * FROM tbl_products ORDER BY $col_name $sort_option LIMIT " . $this_page_first_result . "," . $results_per_page;
                    } elseif (isset($_GET['search'])) {
                        $sql = "SELECT * FROM tbl_products WHERE CONCAT(product_name, product_price, product_qty, featured, active) LIKE '%$searchval%'  LIMIT " . $this_page_first_result . "," . $results_per_page;
                    } else {
                        $sql = "SELECT * FROM tbl_products ORDER BY product_name LIMIT " . $this_page_first_result . "," . $results_per_page;
                    }

                    $result = mysqli_query($conn, $sql);

                    ?>

                    <div class="table-header">
                        <div class="title">
                            <h4>All Products</h4>
                            <p><?php echo $count; ?> products found.</p>
                        </div>
                        <form action="" method="GET" class="search-form">
                            <div class="input-group search-bar">
                                <input type="search" name="search" <?php if (isset($GET['search'])) {
                                                                        echo $GET['search'];
                                                                    } ?>placeholder="Search here">
                                <button class="" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                        </form>
                    </div>
                    <table id="tbl_p">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>
                                    <h5></h5>
                                </th>
                                <th>
                                    <h5>Name</h5>
                                </th>
                                <th>
                                    <h5>Category</h5>
                                </th>
                                <th>
                                    <h5>Price</h5>
                                </th>
                                <!-- <th><h5>Qty</h5></th> -->
                                <th width="100">
                                    <h5>Featured</h5>
                                </th>
                                <th width="100">
                                    <h5>Active</h5>
                                </th>
                                <?php
                                if ($_SESSION['usertype'] == 'Admin') {
                                    echo '<th colspan="2"><h5>Action</h5></th>';
                                }
                                ?>

                            </tr>
                        </thead>
                        <tbody>

                            <?php

                            if ($count > 0) {

                                while ($row = mysqli_fetch_assoc($result)) {

                                    $id = $row['product_id'];
                                    $product_name = $row['product_name'];
                                    $image_name = $row['product_img'];
                                    $product_category = $row['category_id'];
                                    $product_price = $row['product_price'];
                                    $product_qty = $row['product_qty'];
                                    $featured = $row['featured'];
                                    $active = $row['active'];


                            ?>

                                    <tr>
                                        <td>
                                            <h6><?php echo $i++; ?></h6>
                                        </td>
                                        <td>

                                            <?php

                                            if ($image_name != "") {
                                            ?>
                                                <img src="<?php echo SITEURL; ?>img/products/<?php echo $image_name; ?>" width="50px" height="50px">
                                            <?php
                                            } else {
                                                echo "Image not available";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <h5><?php echo $product_name; ?></h5>
                                        </td>

                                        <?php

                                        $check = "SELECT * FROM tbl_category WHERE category_id='$product_category'";

                                        $check_res = mysqli_query($conn, $check);

                                        $check_row = mysqli_fetch_assoc($check_res);

                                        $current = $check_row['category_name'];
                                        ?>
                                        <td>
                                            <h5><?php echo $current; ?></h5>
                                        </td>
                                        <td>
                                            <h5>P<?php echo $product_price; ?></h5>
                                        </td>
                                        <!-- <td><h5><?php if ($product_qty <= 10) {
                                                            echo "<span class='highlight'>$product_qty</span>";
                                                        } else {
                                                            echo $product_qty;
                                                        } ?></h5></td> -->
                                        <td>
                                            <h5><?php echo $featured; ?></h5>
                                        </td>
                                        <td>
                                            <h5><?php echo $active; ?> </h5>
                                        </td>
                                        <?php
                                        if ($_SESSION['usertype'] == 'Admin') {
                                        ?>
                                            <td><a href="<?php echo SITEURL; ?>admin/update-product.php?id=<?php echo $id; ?>"> <button class="btn-update"> <i class="fa-solid fa-pen-to-square"></i>Update</button></a>
                                            <td><a onClick="javascript: return confirm('Are you sure you want to delete this product? '); " href="<?php echo SITEURL; ?>admin/delete-product.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>"><button class="btn-delete"> <i class="fa-solid fa-trash"></i> Delete</button></a>
                                            <?php
                                        }
                                            ?>

                                    </tr>

                            <?php
                                }
                            }

                            ?>
                        </tbody>
                    </table>
                    <div class="page">
                        <h6>Page</h6>
                        <?php

                        ?>
                        <div class="paging">
                            <h6 class="custom-border custom-bg">Show page <?php echo $page ?> of <?php if ($page == 1) {
                                                                                                    echo $number_of_pages;
                                                                                                } else {
                                                                                                    echo $number_of_pages;
                                                                                                } ?></h6>
                            <div class="arrows">
                                <?php

                                if (isset($_GET['sort']) or isset($_GET['search'])) {

                                    if (isset($_GET['search'])) {

                                        if (isset($_GET['sort'])) {
                                            if ($page > 1) {
                                                echo '<a class="pagination custom-border" href="?search=' . $search . '&sort=' . $sorting . '&page=' . $page - 1 . '">' . '<h6 class="">&#139 Previous</h6>' . '</a>';
                                            }
                                        } else {
                                            if ($page > 1) {
                                                echo '<a class="pagination custom-border" href="?search=' . $search . '&page=' . $page - 1 . '">' . '<h6 class="">&#139 Previous</h6>' . '</a>';
                                            }
                                        }
                                    } else {

                                        if (isset($_GET['search'])) {
                                            if ($page > 1) {
                                                echo '<a class="pagination custom-border" href="?search=' . $search . '&sort=' . $sorting . '&page=' . $page - 1 . '">' . '<h6 class="">&#139 Previous</h6>' . '</a>';
                                            }
                                        } else {
                                            if ($page > 1) {
                                                echo '<a class="pagination custom-border" href="?sort=' . $sorting . '&page=' . $page - 1 . '">' . '<h6 class="">&#139 Previous</h6>' . '</a>';
                                            }
                                        }
                                    }
                                } else {
                                    if ($page > 1) {
                                        echo '<a class="pagination custom-border" href="?page=' . $page - 1 . '">' . '<h6 class="">&#139 Previous</h6>' . '</a>';
                                    }
                                }

                                ?>
                                <?php

                                if (isset($_GET['sort']) or isset($_GET['search'])) {

                                    if (isset($_GET['search'])) {

                                        if (isset($_GET['sort'])) {

                                            if ($page < $number_of_pages) {
                                                echo '<a class="pagination custom-border" href="?search=' . $search . '&sort=' . $sorting . '&page=' . $page + 1 . '">' . '<h6 class="">Next &#155</h6>' . '</a>';
                                            }
                                        } else {

                                            if ($page < $number_of_pages) {
                                                echo '<a class="pagination custom-border" href="?search=' . $search . '&page=' . $page + 1 . '">' . '<h6 class="">Next &#155</h6>' . '</a>';
                                            }
                                        }
                                    } else {
                                        if ($page < $number_of_pages) {
                                            echo '<a class="pagination custom-border" href="?sort=' . $sorting . '&page=' . $page + 1 . '">' . '<h6 class="">Next &#155</h6>' . '</a>';
                                        }
                                    }
                                } else {
                                    if ($page < $number_of_pages) {
                                        echo '<a class="pagination custom-border" href="?page=' . $page + 1 . '">' . '<h6 class="">Next &#155</h6>' . '</a>';
                                    }
                                }

                                ?>
                            </div>
                        </div>


                        <?php

                        ?>



                    </div>
                </section>
            </section>
        </div>

    </section>

    <!-- main section-->

</body>

</html>