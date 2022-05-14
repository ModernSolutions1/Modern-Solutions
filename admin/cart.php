<?php include('partials/header.php');
?>
<?php
    if(isset($_GET['remove'])){
        $id = $_GET['remove'];

        mysqli_query($conn, "DELETE FROM tbl_basket WHERE basket_id=$id");

        header('location:'.SITEURL.'admin/cart.php');
    }

    if(isset($_GET['update'])){

        $qty = $_GET['qty'];
        $id = $_GET['basket_id'];

        mysqli_query($conn, "UPDATE tbl_basket SET qty=$qty WHERE basket_id=$id");

        header('location:'.SITEURL.'admin/cart.php');
    }

    if(isset($_POST['checkout'])){

        $checkout = "SELECT * FROM tbl_basket";
        $checkout_run = mysqli_query($conn, $checkout);
        $price_total = 0;

        while ($product_item = mysqli_fetch_assoc($checkout_run)) {
            $product_name[] = $product_item['name'] . ' (' . $product_item['qty'] . ')';
            $product_price = number_format($product_item['price'] * $product_item['qty']);
            $price_total += $product_price;
        };

        $total_product = implode(', ', $product_name);
        $username = $_SESSION['user'];
        $date = date('Y-m-d h:i:s');

        $checkout_sql = "INSERT INTO tbl_storecheckout SET
            products = '$total_product',
            total_price = $price_total,
            username = '$username',
            date = '$date'  
        ";
        $run = mysqli_query($conn, $checkout_sql);

        if($run){
            mysqli_query($conn, "DELETE FROM tbl_basket");
            header('location:' . SITEURL . 'admin/store.php');
        }else{
            echo "Failed.";
        }
    }
?>

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
                <a href="#">
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
            <a href="#">
                <li>
                    <i class="fa-solid fa-cart-shopping"></i>
                    <h5>Orders</h5>
                </li>
            </a>
            <a href="#">
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
                <a href="#">
                    <li>
                        <i class="fa-solid fa-border-all"></i>
                        <h5>Overview</h5>
                    </li>
                </a>
                <a href="#">
                    <li>
                        <i class="fa-solid fa-list"></i>
                        <h5>Products</h5>
                    </li>
                </a>
                <a href="#">
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
<section id="main">
    <section id="main-header">
        <!-- <div class="input-group search-bar">
            <input type="search" placeholder="Search here">
            <button><i>#</i></button>
        </div> -->
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
                <a href="store.php" class="btn-add">Back</a>
            </div>
        </section>
        <?php

        if (isset($_SESSION['category-exists'])) {
            echo $_SESSION['category-exists'];
            unset($_SESSION['category-exists']);
        }
        ?>
        <section id="main-content">
            <h4>Cart</h4>
            <table style="width: 100%; text-align: left; margin-top: 30px; border-collapse:collapse">
                <thead style="border-bottom: 1px solid #ccc">
                    <tr>
                        <th style="padding:15px 0;">Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Sub-total</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $run = mysqli_query($conn, "SELECT * FROM tbl_basket");
                    $grand = 0;

                    if (mysqli_num_rows($run) > 0) {
                        while ($row = mysqli_fetch_assoc($run)) {
                    ?>
                            <tr>
                                <td style="padding: 10px 0; "><?= $row['name']?></td>
                                <td>P<?= $row['price'];?></td>
                                <td>
                                    <form action="" method="GET">
                                    <input type="hidden" name="basket_id" value="<?php echo $row['basket_id']?>">
                                    <input type="number" name="qty" min="1" value="<?= $row['qty']?>" style="width:50px; border: 1px solid #ccc">
                                    <input type="submit" name="update" value="Update" style="border: none; padding:3px 5px; color:white; background-color:green; border-radius:4px" >
                                    </form>
                                    
                                </td>
                                <td>P<?= $row['price']*$row['qty']?></td>
                                <td><a href="cart.php?remove=<?php echo $row['basket_id']?>">X</a></td>
                            </tr>
                    <?php
                    $grand = $grand + ($row['qty'] * $row['price']);
                        }
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>                
                        <td>
                        <br><br><h4>Total Price <span style="padding:5px; background-color:blue; color: white; border-radius: 5px">P<?php echo $grand;?></span></h4></td>
                    </tr>
                    <tr>
                    <td><br><br>
                        <form action="" method="POST">
                            <input type="hidden" name="" id="">
                            <input type="submit" name="checkout" id="" value="Submit" style="border:none; padding:5px 10px; color:white; background-color:red; border-radius: 4px; cursor:pointer"required></td>
                        </form>                   
                    </tr>
                </tfoot>
            </table>
        </section>
    </div>
</section>