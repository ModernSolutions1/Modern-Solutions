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
                <h5><?php echo "Welcome ".$_SESSION['user']."!"; ?></h5><?php      
                ?>
            </div>
        </section>
        <?php

            if(isset($_SESSION['category-added'])){
                echo $_SESSION['category-added'];
                unset($_SESSION['category-added']);
            }
            if(isset($_SESSION['upload'])){
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
            if(isset($_SESSION['img_remove'])){
                echo $_SESSION['img_remove'];
                unset($_SESSION['img_remove']);
            }
            if(isset($_SESSION['delete'])){
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
            }
            if(isset($_SESSION['no-category'])){
                echo $_SESSION['no-category'];
                unset($_SESSION['no-category']);
            }
            if(isset($_SESSION['category-update'])){
                echo $_SESSION['category-update'];
                unset($_SESSION['category-update']);
            }
        ?>
        <div class="wrapper">
            <section id="main-section">
                <div class="title">
                    <h4>Category</h4>
                </div>
            </section>
            <section id="main-content">
                    <div class="content-header">
                        <form action="" method="GET">
                            <div class="filtersort">
                                <div class="input-group input">
                                    <select name="sort" id="">
                                        <option value="">-Select Option-</option>
                                        <option value="a-z"<?php if(isset($_GET['sort']) && $_GET['sort'] == "a-z"){ echo "selected"; }?>>  Name (ASC)</option>
                                        <option value="z-a"<?php if(isset($_GET['sort']) && $_GET['sort'] == "z-a"){ echo "selected"; }?>>  Name (DESC)</option>                         
                                    </select>
                                    <button type="submit"><i class="fa-solid fa-sort"></i></button>
                                </div>
                            </div>
                        </form>
                        <?php
                            if($_SESSION['usertype']=='Admin'){
                                echo '<a href="add-category.php" class="btn-add">+ Add New</a>';
                            }
                        ?>    
                    </div>
                    <section id="table-container">
                        
                    <?php

                        $sort_option = "";

                        if(isset($_GET['sort'])){
                            if($_GET['sort'] == 'a-z'){
                                $sort_option = "ASC";
                            }
                            elseif($_GET['sort'] == 'z-a'){
                                $sort_option = "DESC";
                            }
                        }

                        if(isset($_GET['sort'])){
                            $sorting = $_GET['sort'];
                        }
                        else{
                            $sorting = "";
                        }
                        
                        if(isset($_GET['search'])){
                            $search = $_GET['search'];
                        }
                        else{
                            $search = "";
                        }

                        if(isset($_GET['search'])){
                            $searchval = $_GET['search'];
                        }

                        $results_per_page = 5;

                        $sql = "SELECT * FROM tbl_category";
                        $res = mysqli_query($conn, $sql);
                        $count = mysqli_num_rows($res);
                        $i = 1;

                        $number_of_pages = ceil($count/$results_per_page);

                        if(!isset($_GET['page'])){
                            $page = 1;
                        }
                        else{
                            $page = $_GET['page'];
                        }

                        $this_page_first_result = ($page-1)*$results_per_page;

                        if(isset($_GET['sort']) or isset($_SESSION['default'])){
                            $sql = "SELECT * FROM tbl_category ORDER BY category_name $sort_option LIMIT " . $this_page_first_result . "," . $results_per_page;
                        }
                        elseif(isset($_GET['search'])){
                            $sql = "SELECT * FROM tbl_category WHERE CONCAT(category_name, featured, active) LIKE '%$searchval%'  LIMIT " . $this_page_first_result . "," . $results_per_page;
                        }
                        else{
                            $sql = "SELECT * FROM tbl_category ORDER BY category_name LIMIT " . $this_page_first_result . "," . $results_per_page;   
                           
                        }

                        $result = mysqli_query($conn, $sql);

                    ?>
                        <div class="table-header">
                            <div class="title">
                                <h4>All Category</h4>
                                <p><?php echo $count?> categories found.</p>
                            </div>
                            <form action="" method="GET" class="search-form">
                                <div class="input-group search-bar">
                                    <input type="search" name="search" <?php if(isset($GET['search'])){echo $GET['search'];}?>placeholder="Search here">
                                    <button class=""type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                            </form>
                        </div>
                        <table id="tbl_p">
                        <thead>
                            <tr>
                                <th width= "50px">#</th>
                                <th width= "100px"><h5></h5></th>
                                <th width= "300px"><h5>Name</h5></th>
                                <th width= "100px"><h5>Featured</h5></th>
                                <th width= "100px"><h5>Active</h5></th>
                                <?php
                                    if($_SESSION['usertype']=='Admin'){
                                        echo '<th colspan="2" width="100px"><h5>Action</h5></th>';
                                    }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                                if($count>0){

                                    while($row=mysqli_fetch_assoc($result)){

                                        $id = $row['category_id'];
                                        $category_name = $row['category_name'];
                                        $image_name = $row['category_img'];
                                        $featured = $row['featured'];
                                        $active = $row['active'];

                                        ?>

                                            <tr>
                                                <td><h6><?php echo $i++; ?></h6></td>
                                                <td>

                                                    <?php

                                                        if($image_name!=""){
                                                            ?>
                                                            <img src="<?php echo SITEURL; ?>img/category/<?php echo $image_name; ?>" width="50px" height="50px">
                                                            <?php
                                                        }
                                                        else{
                                                            echo "Image not available";
                                                        }
                                                    ?>
                                                </td>
                                                <td><h5><?php echo $category_name?></h5></td>
                                                <td><h5><?php echo $featured; ?></h5></td>
                                                <td><h5><?php echo $active; ?> </h5></td>

                                                <?php
                                                    if($_SESSION['usertype']=='Admin'){
                                                        ?>
                                                        <td width="100px"><a href="<?php echo SITEURL;?>admin/update-category.php?id=<?php echo $id; ?>"><button class="btn-update"><i class="fa-solid fa-pen-to-square"></i>Update</button></a>
                                                <td width="100px"><a onClick="javascript: return confirm('Are you sure you want to delete this category? ');" href="<?php echo SITEURL; ?>admin/delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>"><button class="btn-delete"><i class="fa-solid fa-trash"></i> Delete</button></a>
                                                        <?php
                                                    }
                                                ?>
                                                
                                            </tr>

                                        <?php
                                    }
                                }
                                else{

                                    ?>
                                        <tr>
                                            <td colspan="6"><h6>No Category found.</h6></td>
                                        </tr>
                                    <?php
                                }
                            ?>                                              
                    </table>
                    <div class="page">
                        <h6>Page</h6>
                        <?php

                            ?>  
                            <div class="paging">
                            <h6 class="custom-border custom-bg">Show page <?php echo $page?> of <?php if($page==1){echo $number_of_pages;}else{ echo $number_of_pages; }?></h6>
                            <div class="arrows">
                                    <?php 

                                            if(isset($_GET['sort']) or isset($_GET['search'])){

                                                if(isset($_GET['search'])){
                                                    
                                                    if(isset($_GET['sort'])){
                                                        if($page>1){
                                                            echo '<a class="pagination custom-border" href="?search='. $search . '&sort='. $sorting .'&page=' . $page-1 . '">' . '<h6 class="">&#139 Previous</h6>' . '</a>';
                                                        }

                                                    }
                                                    else{
                                                        if($page>1){
                                                            echo '<a class="pagination custom-border" href="?search='. $search .'&page=' . $page-1 . '">' . '<h6 class="">&#139 Previous</h6>' . '</a>';
                                                        }
                                                    }
                                                    
                                                }
                                                else{

                                                    if(isset($_GET['search'])){
                                                        if($page>1){
                                                            echo '<a class="pagination custom-border" href="?search='. $search . '&sort='. $sorting .'&page=' . $page-1 . '">' . '<h6 class="">&#139 Previous</h6>' . '</a>';
                                                        }
                                                    }
                                                    else{
                                                        if($page>1){
                                                            echo '<a class="pagination custom-border" href="?sort='. $sorting .'&page=' . $page-1 . '">' . '<h6 class="">&#139 Previous</h6>' . '</a>';
                                                        }
                                                    }                                             
                                                }
                                            }
                                            else{
                                                    if($page>1){
                                                        echo '<a class="pagination custom-border" href="?page=' . $page-1 . '">' . '<h6 class="">&#139 Previous</h6>' . '</a>';
                                                }
                                            }

                                        ?>
                                    <?php 

                                        if(isset($_GET['sort']) or isset($_GET['search'])){

                                            if(isset($_GET['search'])){

                                                if(isset($_GET['sort'])){

                                                    if($page<$number_of_pages){
                                                        echo '<a class="pagination custom-border" href="?search='. $search .'&sort='. $sorting .'&page=' . $page+1 . '">' . '<h6 class="">Next &#155</h6>' . '</a>';
                                                    }
                                                }
                                                else{

                                                    if($page<$number_of_pages){
                                                        echo '<a class="pagination custom-border" href="?search='. $search .'&page=' . $page+1 . '">' . '<h6 class="">Next &#155</h6>' . '</a>';
                                                    }
                                                }
                                                
                                            }
                                            else{
                                                if($page<$number_of_pages){
                                                    echo '<a class="pagination custom-border" href="?sort='. $sorting .'&page=' . $page+1 . '">' . '<h6 class="">Next &#155</h6>' . '</a>';
                                                }
                                            }
                                            
                                        }
                                        else{
                                                if($page<$number_of_pages){
                                                    echo '<a class="pagination custom-border" href="?page=' . $page+1 . '">' . '<h6 class="">Next &#155</h6>' . '</a>';
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