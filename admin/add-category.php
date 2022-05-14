<?php include('partials/header.php');?>

<?php

    if(isset($_POST['submit'])){

        $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);

        if(isset($_POST['featured'])){

            $featured = $_POST['featured'];
        }
        else{
            $featured = "No";
        }
    
        if(isset($_POST['active'])){

            $active = $_POST['active'];
        }
        else{
            $active = "No";
        }

        if(isset($_FILES['image']['name'])){

            $image_name = $_FILES['image']['name'];

            if($image_name!=""){

                $ext = end(explode('.', $image_name));

                $image_name = "A-Mart_Category_".rand(000, 999).'.'.$ext;
                
                $source_path = $_FILES['image']['tmp_name'];

                $destination_path = "../img/category/".$image_name;

                $upload = move_uploaded_file($source_path, $destination_path);

                if($upload==false){
                    $_SESSION['upload'] = "<div class='message-failed'>Upload Failed</div>";
                    header('location:'.SITEURL.'admin/add-category.php');
                    die();
                }
            }
            else{
                $image_name = "";
            }
        }
        else{
            $image_name = "";
        }

        $check = "SELECT * FROM tbl_category WHERE category_name='$category_name'";
        $result = mysqli_query($conn, $check);
        $count = mysqli_num_rows($result);

        if($count>0){   
            $reload = "<div><h4><a href='manage-products.php'>x</a></h4></div>";
            $_SESSION['category-exists']="<div class='message-failed'>Category already exists.".$reload."</div>";
            header('location:'.SITEURL.'admin/add-category.php');
        }

        if(!isset($_SESSION['category-exists'])){

            $sql = "INSERT INTO tbl_category SET
                category_name='$category_name',
                category_img='$image_name',
                featured='$featured',
                active='$active'
            ";

            $res = mysqli_query($conn, $sql);

            if($res==true){

                $reload = "<div><h4><a href='manage-category.php'>x</a></h4></div>";
                $_SESSION['category-added'] = "<div class='message-success'><div></div><h5>Category was added successfully!</h5>".$reload."</div>";
                header("location:".SITEURL."admin/manage-category.php");
            }
            else{
    
                header('location:'.SITEURL.'admin/add-category.php');
            }
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
                            <i class="fa-solid fa-cart-shopping current-item-i"></i>
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
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            <h5>Store</h5>
                        </li>
                    </a>
                </ul>
            </section>
            <section class="menu-footer">
            <div>
                    <i> # </i>
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
                    ?><h5><?php echo date("m-d-y").", ". date("l"); ?></h5><?php
              
                ?>       
                <h5><?php echo "Welcome ".$_SESSION['user']."!";?></h5><?php          
                ?>
            </div>
        </section>
        <div class="wrapper">
            <section id="main-section">
                <div class="title">
                    <a href="manage-category.php" class="btn-add">Back</a>
                </div>
            </section>
            <?php

                if(isset($_SESSION['category-exists'])){
                    echo $_SESSION['category-exists'];
                    unset($_SESSION['category-exists']);
                }
            ?>
            <section id="main-content">
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-head">
                        <h4 class="to-center">Add Category</h4>
                    </div>
                    <div class="form-body">
                        <div class="form-control">
                            <h5>Category Name</h5>
                            <input type="text" name="category_name" placeholder="Enter category name" class="custom-border" required>
                        </div>
                        <div class="form-control">
                            <h5>Featured</h5>
                            <div class="radios">
                                <div>
                                    <label for="radio">Yes</label>
                                    <input type="radio" name="featured" value="Yes">
                                </div>
                                <div>
                                    <label for="radio">No</label>
                                    <input type="radio" name="featured" value="No" checked>
                                </div>
                            </div>              
                        </div>
                        <div class="form-control">
                            <h5>Active</h5>
                            <div class="radios">
                                <div>
                                    <label for="radio">Yes</label>
                                    <input type="radio" name="active" value="Yes" checked>
                                </div>
                                <div>
                                    <label for="radio">No</label>
                                    <input type="radio" name="active" value="No">
                                </div>
                            </div>              
                        </div>
                        <div class="form-control">
                            <h5>Image</h5>
                            <div>
                                <input type="file" name="image" class="input-file" accept="img">
                            </div>
                        </div>
                        <div class="form-control">
                            <div></div>
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