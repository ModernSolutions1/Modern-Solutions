<?php include('partials/header.php');
$order_status = "";
?>

<?php

if (isset($_POST['btn-update'])) {

    echo $idx = $_POST['update_btn'];

    $username = $_POST['username'];
    $email = $_POST['user_email'];
    $phone = $_POST['user_phone'];
    $password = $_POST['user_pass'];
    $usertype = $_POST['usertype'];

    $sql3 = "UPDATE tbl_admin SET
    admin_username = '$username',
    admin_email = '$email',
    admin_phone = '$phone',
    admin_pass = '$password',
    usertype = '$usertype'
    WHERE admin_id = '$idx'
    ";

    $sql3_r = mysqli_query($conn, $sql3);

    if ($sql3_r) {
        $reload = "<div><h4><a href='manage-user.php'>x</a></h4></div>";
        $_SESSION['user-update'] = "<div class='message-success'><div></div>Updated successfully!" . $reload . "</div>";
        header('location:' . SITEURL . 'admin/manage-user.php');
    } else {
        echo "failed";
    }
}
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
                        <?php $_SESSION['order-page'] = TRUE; ?>
                    </li>
                </a>
                <a href="manage-user.php">
                    <li class="current-item">
                        <i class="current-item-i">#</i>
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
                        <i></i>
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
        <div class="wrapper">
            <section id="main-section">
                <br>
                <div class="flex flex-sb">
                    <a href="manage-user.php" class="btn-add">Back</a>
                </div>
            </section>
            <section id="main-content">
                <h1>Update User</h1>
                <div id="flex-container" class="flex">
                    <?php

                    if (isset($_GET['update'])) {

                        $id = $_GET['update'];
                        $sql1 = "SELECT * FROM tbl_admin WHERE admin_id = '$id'";
                        $sqli_r = mysqli_query($conn, $sql1);

                        if (mysqli_num_rows($sqli_r) > 0) {
                            while ($fetch = mysqli_fetch_assoc($sqli_r)) {
                    ?>
                                <div class="form">
                                    <form action="" method="POST" class="flex flex-col" style="width: 100%">
                                        <input type="text" name="username" id="" placeholder="Username" value="<?= $fetch['admin_username'] ?>">
                                        <input type="email" name="user_email" id="" placeholder="Email" value="<?= $fetch['admin_email'] ?>">
                                        <input type="tel" name="user_phone" id="" placeholder="Phone" value="<?= $fetch['admin_phone'] ?>">
                                        <input type="text" name="user_pass" id="" placeholder="Password" value="<?= $fetch['admin_pass'] ?>">
                                        <select name="usertype" id="" style="padding:10px; color:#555">
                                        <option value="">--User Type--</option>
                                            <option value="Admin" <?php if($fetch['usertype']=='Admin'){echo "selected";}?>>Admin</option>
                                            <option value="Cashier"<?php if($fetch['usertype']=='Cashier'){echo "selected";}?>>Cashier</option>
                                        </select>
                                        <br>
                                        <input type="hidden" name="update_btn" value="<?= $fetch['admin_id'] ?>" id="">
                                        <input type="submit" name="btn-update" id="" value="Update">
                                    </form>
                                </div>
                    <?php
                            }
                        }
                    }

                    ?>
                </div>
            </section>
        </div>
    </section>

    <!-- main section-->

</body>

</html>