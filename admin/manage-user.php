<?php include('partials/header.php');
$order_status = "";
?>

<?php

if (isset($_POST['btn-submit'])) {
    $username = $_POST['uname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['pass'];
    $usertype = $_POST['usertype'];

    $check = "SELECT * FROM tbl_admin WHERE (admin_username = '$username' and admin_email = '$email') or admin_email = '$email'";
    $check_run = mysqli_query($conn, $check);

    if (mysqli_num_rows($check_run) > 0 and !preg_match('/^[0-9]{10}+$/', $phone) and $password < 3) {
        echo "Email already exists";
    } else {
        $sql2 = "INSERT INTO tbl_admin SET
            admin_username = '$username',
            admin_email = '$email',
            admin_phone = $phone,
            admin_pass = '$password',
            usertype = '$usertype'
            ";
        $sql2_r = mysqli_query($conn, $sql2);
        if ($sql2_r) {
            $reload = "<div><h4><a href='manage-user.php'>x</a></h4></div>";
            $_SESSION['user-add'] = "<div class='message-success'><div></div>Added Successfully!" . $reload . "</div>";
            header('location:' . SITEURL . 'admin/manage-user.php');
        } else {
            echo "Failed";
        }
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete = "DELETE FROM tbl_admin WHERE admin_id = '$id'";
    $delete_r = mysqli_query($conn, $delete);

    if ($delete_r) {
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
                        <?php $_SESSION['order-page'] = TRUE; ?>
                    </li>
                </a>
                <a href="manage-user.php">
                    <li class="current-item">
                        <i class="fa-solid fa-users current-item-i"></i>
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
        if (isset($_SESSION['user-update'])) {
            echo $_SESSION['user-update'];
            unset($_SESSION['user-update']);
        }
        if (isset($_SESSION['user-add'])) {
            echo $_SESSION['user-add'];
            unset($_SESSION['user-add']);
        }
        ?>
        <div class="wrapper">
            <section id="main-section">
                <div class="title">
                    <h4>User</h4>
                </div>
            </section>
            <?php
            if ($_SESSION['usertype'] == 'Admin') {
                //cut here
            ?>
                <section id="main-content">
                    <div class="flex flex-sb">
                        <h1><i class="fa-solid fa-user"></i> User</h1>
                        <!-- <form action="" method="GET" class="search-form">
                        <div class="input-group search-bar">
                            <input type="search" name="search" <?php if (isset($GET['search'])) {
                                                                    echo $GET['search'];
                                                                } ?>placeholder="Search here">
                            <button class="" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </form> -->
                    </div>

                    <div id="flex-container" class="flex">
                        <div class="form">
                            <form action="" method="POST" class="flex flex-col" style="width: 100%" required>
                                <input type="text" name="uname" id="" placeholder="Username" required>
                                <input type="email" name="email" id="" placeholder="Email" required>
                                <input type="tel" name="phone" maxlength="11" id="" placeholder="Phone" required>
                                <input type="password" name="pass" id="" placeholder="Password" required>
                                <select name="usertype" id="" style="padding:10px; color:#555" required>
                                    <option value="">--User Type--</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Cashier">Cashier</option>
                                </select>
                                <br>
                                <input type="submit" name="btn-submit" value="Add" id="">
                            </form>
                        </div>
                        <div class="table-data">
                            <table id="tbl_orders">
                                <thead>
                                    <tr>
                                        <td width="10%">ID</td>
                                        <td width="25%">Username</td>
                                        <td width="25%">Email</td>
                                        <td width="25%">User Type</td>
                                        <td width="15%" colspan="2" class="to-center">Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql1 = "SELECT * FROM tbl_admin";
                                    $sql1_r = mysqli_query($conn, $sql1);

                                    if (mysqli_num_rows($sql1_r) > 0) {
                                        while ($fetch1 = mysqli_fetch_assoc($sql1_r)) {
                                    ?>
                                            <tr>
                                                <td width="10%"><?= $fetch1['admin_id'] ?></td>
                                                <td width="25%"><?= $fetch1['admin_username'] ?></td>
                                                <td width="25%"><?= $fetch1['admin_email'] ?></td>
                                                <td width="25%"><?= $fetch1['usertype'] ?></td>
                                                <td width="7.5%"><a href="update-user.php?update=<?= $fetch1['admin_id'] ?>" style="padding:3px; border-radius:5px; color:white; background-color:green">Update</a></td>
                                                <td width="7.5%"><a onClick="javascript: return confirm('Are you sure you want to delete this user? ');" href="manage-user.php?delete=<?= $fetch1['admin_id'] ?>" style="padding:3px; border-radius:5px; color:white; background-color:red">Delete</a></td>



                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            <?php
                //cut here
            } elseif ($_SESSION['usertype'] == 'Cashier') {
                echo "<div id='main-content'><h3 style='text-align:center'>Access Denied. Please contact the administrator.</h3></div>";
            }
            ?>

        </div>

    </section>

    <!-- main section-->

</body>

</html>