<?php include('partials/header.php') ?>

<?php

if (isset($_POST['submit'])) {

    $id = $_POST['category_id'];
    $category_name = $_POST['category_name'];
    $current_image = $_POST['current_image'];
    $featured = $_POST['featured'];
    $active = $_POST['active'];

    if (isset($_FILES['image']['name'])) {
        $image_name = $_FILES['image']['name'];

        if ($image_name != "") {

            $ext = end(explode('.', $image_name));

            $image_name = "A-Mart_Category_" . rand(000, 999) . '.' . $ext;

            $source_path = $_FILES['image']['tmp_name'];

            $destination_path = "../img/category/" . $image_name;

            $upload = move_uploaded_file($source_path, $destination_path);

            if ($upload == false) {
                $_SESSION['upload'] = "<div class='message-failed'>Upload Failed</div>";
                header('location:' . SITEURL . 'admin/manage-category.php');
                die();
            }

            if ($current_image != "") {

                $remove_path = "../img/category/" . $current_image;
                $remove = unlink($remove_path);

                if ($remove == false) {
                    $_SESSION['remove-failed'] = "<div class='message-failed'>Failed to remove current image</div>";
                    header('location:' . SITEURL . 'admin/manage-category.php');
                    die();
                }
            }
        } else {
            $image_name = $current_image;
        }
    } else {
        $image_name = $current_image;
    }

    $sql2 = "UPDATE tbl_category SET
        category_name='$category_name',
        category_img='$image_name',
        featured='$featured',
        active='$active'
        WHERE category_id='$id'
    ";

    $res2 = mysqli_query($conn, $sql2);

    if ($res2) {
        $reload = "<div><h4><a href='manage-category.php'>x</a></h4></div>";
        $_SESSION['category-update'] = "<div class='message-success'><div></div>Category updated successfully!" . $reload . "</div>";
        header('location:' . SITEURL . 'admin/manage-category.php');
    } else {
        $reload = "<div><h4><a href='manage-category.php'>x</a></h4></div>";
        $_SESSION['category-update'] = "<div class='message-failed'><div></div>Category update failed." . $reload . "</div>";
        header('location:' . SITEURL . 'admin/manage-category.php');
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
                        <li class="current-item">
                            <i class="fa-solid fa-grip-vertical current-item-i"></i>
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
                    <a href="#"> Log Out</a>
                </div>
            </section>
        </div>
    </section>

    <!-- main header -->
    <section id="main">
        <section id="main-header">
            <div class="input-group search-bar">
                <input type="search" placeholder="Search here">
                <button><i>#</i></button>
            </div>
            <div class="profile">
            </div>
        </section>
        <div class="wrapper">
            <section id="main-section">
                <div class="title">
                    <a href="manage-category.php" class="btn-add">Back</a>
                </div>
            </section>
            <?php

            if (isset($_SESSION['category-exists'])) {
                echo $_SESSION['category-exists'];
                unset($_SESSION['category-exists']);
            }
            ?>
            <section id="main-content">

                <?php

                if (isset($_GET['id'])) {

                    $id = $_GET['id'];

                    $sql = "SELECT * FROM tbl_category WHERE category_id='$id'";

                    $res = mysqli_query($conn, $sql);

                    $count = mysqli_num_rows($res);

                    if ($count > 0) {

                        $row = mysqli_fetch_assoc($res);
                        $category_name = $row['category_name'];
                        $current_image = $row['category_img'];
                        $featured = $row['featured'];
                        $active = $row['active'];
                    } else {

                        $_SESSION['no-category'] = "<div class='message-failed'>Category not found.</div>";
                        header('location:' . SITEURL . 'admin/manage-category.php');
                    }
                } else {
                    header('location:' . SITEURL . 'admin/manage-category.php');
                }
                ?>
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-head">
                        <h4 class="to-center">Update Category</h4>
                    </div>
                    <div class="form-body">
                        <div class="form-control">
                            <h5>Category Name</h5>
                            <input type="text" name="category_name" placeholder="Enter category name" class="custom-border" value="<?php echo $category_name; ?>" required>
                        </div>
                        <div class="form-control">
                            <h5>Featured</h5>
                            <div class="radios">
                                <div>
                                    <label for="radio">Yes</label>
                                    <input <?php if ($featured == "Yes") {
                                                echo "checked";
                                            } ?> type="radio" name="featured" value="Yes">
                                </div>
                                <div>
                                    <label for="radio">No</label>
                                    <input <?php if ($featured == "No") {
                                                echo "checked";
                                            } ?> type="radio" name="featured" value="No">
                                </div>
                            </div>
                        </div>
                        <div class="form-control">
                            <h5>Active</h5>
                            <div class="radios">
                                <div>
                                    <label for="radio">Yes</label>
                                    <input <?php if ($active == "Yes") {
                                                echo "checked";
                                            } ?> type="radio" name="active" value="Yes">
                                </div>
                                <div>
                                    <label for="radio">No</label>
                                    <input <?php if ($active == "No") {
                                                echo "checked";
                                            } ?> type="radio" name="active" value="No">
                                </div>
                            </div>
                        </div>
                        <div class="form-control">
                            <h5>Current Image</h5>
                            <div style="margin-right: 26%">
                                <?php

                                if ($current_image != "") {

                                ?> <img src="<?php echo SITEURL; ?>img/category/<?php echo $current_image; ?>" width="120px" height="120px"> <?php
                                                                                                                                            } else {
                                                                                                                                                echo "<span class='highlight'>image not available.</span>";
                                                                                                                                            }
                                                                                                                                                ?>
                            </div>
                        </div>
                        <div class="form-control">
                            <h5>New Image</h5>
                            <div>
                                <input type="file" name="image" class="input-file" accept="img">
                            </div>
                        </div>
                        <div class="form-control">
                            <div></div>
                            <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                            <input type="hidden" name="category_id" value="<?php echo $id; ?>">
                            <input type="submit" name="submit" id="" value="Submit">
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </section>

    <!-- main section-->

</body>

</html>