<?php include('partials/header.php');
$counter = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tbl_basket"));
?>

<?php

if (isset($_GET['add'])) {

    $id = $_GET['p_id'];
    $name = $_GET['p_name'];
    $price = $_GET['p_price'];
    $qty = $_GET['p_qty'];

    $check = "SELECT * FROM tbl_basket WHERE name = '$name'";
    $check_run = mysqli_query($conn, $check);

    if (mysqli_num_rows($check_run) > 0) {
        echo mysqli_num_rows($check_run);
        $fetch = mysqli_fetch_assoc($check_run);
        $x = $fetch['qty'];
        $qty = $qty + $x;
        $insert = "UPDATE tbl_basket SET
        qty = $qty
        WHERE name = '$name'
    ";
    } else {
        $insert = "INSERT INTO tbl_basket SET
        name = '$name',
        price = $price,
        qty = $qty
    ";
    }

    mysqli_query($conn, $insert);
    header('location:' . SITEURL . 'admin/store.php');
}
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
            <h4>Store</h4>
            <?php
                if($_SESSION['usertype']=='Admin'){
                    echo '<a href="records.php">View Records</a>';
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
            <?php if($counter>0){
                ?>
<div style="display: flex; justify-content: right"><button style="padding: 10px 10px; margin: 5px 0 20px 0; border: none; font-size: 14px; color: white; background-color: blue; border-radius: 4px; cursor: pointer" onclick="window.location.replace('cart.php')">Cart <span>(<?php echo $counter; ?>)</span></button></div>
                <?php
            }?>
            
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
                        <th style="padding-bottom: 15px">Item Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    if (!isset($_GET['search'])) {
                        $sql = "SELECT * FROM tbl_products ORDER BY product_name ASC LIMIT 20";
                    } else {
                        $search = $_GET['search'];
                        $sql = "SELECT * FROM tbl_products WHERE product_name LIKE '%$search%' AND active='Yes' LIMIT 20";
                    }

                    $sql_run = mysqli_query($conn, $sql);

                    while ($row = mysqli_fetch_assoc($sql_run)) {
                    ?>
                        <tr class="tbl-tr">
                            <form action="" method="GET">
                                <td name="name" style="padding:10px"><?= $row['product_name'] ?></td>
                                <td>P<?= $row['product_price'] ?></td>
                                <td><input type="number" name="p_qty" min="1" style="width:50px; border: 1px solid #ccc" value="1"></td>
                                <td><input type="hidden" id="" name="p_id" value="<?= $row['product_id'] ?>"></td>
                                <td><input type="hidden" id="" name="p_name" value="<?= $row['product_name'] ?>"></td>
                                <td><input type="hidden" id="" name="p_price" value="<?= $row['product_price'] ?>"></td>
                                <td><input name="add" type="submit" value="+ Add" style="color:white; background-color:blue; border:none; padding: 5px 10px; border-radius: 4px; cursor: pointer"></td>
                            </form>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </div>

</section>