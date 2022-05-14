<?php include('front-partials/header.php') ?>


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

    // for cart counter
    $email = "";
    if (isset($_SESSION['authenticated'])) {
        $email = $_SESSION['auth_user']['email'];
    }
    $counter = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tbl_order_item WHERE customer_email='$email'"));

    ?>
</div>


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

<!-- SLIDESHOW -->

<section>
    <div class="container">
        <div class="mySlides fade">
            <img src="img/person.png" alt="" width="50%" height="80%" style="position:absolute; bottom:0;">
            <div widtd="40%">
                <h4>Stay Home - We'll Deliver <br> for Free</h4>
                <p>Get your groceries delivered less than 24 hours</p>
            </div>
        </div>
        <div class="mySlides fade">
            <img src="img/1.png" alt="" width="50%" height="80%" style="position:absolute; bottom:0;">
            <div widtd="40%">
                <h4>Stay Home - We'll Deliver <br> for Free</h4>
                <p>Get your groceries delivered less than 24 hours</p>
            </div>
        </div>
    </div>
    </div>
</section>

<!-- CATEGORY -->
<section id="category-section">
    <div class="container">
        <div class="title-between">
            <h5>Shop By Categories</h5>
            <a href="categories.php">
                <h6>View All Categories</h6>
            </a>
        </div>
        <div class="categories">
            <?php

            $sql = "SELECT * FROM tbl_category WHERE active='Yes' and featured = 'Yes' LIMIT 8";

            $res = mysqli_query($conn, $sql);

            $count = mysqli_num_rows($res);

            if ($count > 0) {

                while ($rows = mysqli_fetch_assoc($res)) {

                    $category_id = $rows['category_id'];
                    $category_name = $rows['category_name'];
                    $image_name = $rows['category_img'];

            ?>
                    <div class="category">
                        <a href="categories.php?id=<?php echo $category_id; ?>">
                            <img src="<?php echo SITEURL; ?>img/category/<?php echo $image_name; ?>">
                            <h6 class="to-center"><?php echo $category_name ?></h6>
                        </a>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>
</section>

<!-- BIG 2 PICS-->

<section id="big-pics">
    <div class="container">
        <div class="big-pic" style="position:relative;">
            <div class="big-pic1">
                <h1>Baked and <br>Other Products <br>For Your Need</h1>
                <a href="<?php echo SITEURL; ?>all-products.php?showcase_id=174"><button>Shop Now <i class="fa-solid fa-arrow-right-long"></i> </button></a>
            </div>
            <img src="img/julies.webp" alt="" width="70px" style="position:absolute; bottom:10%; left: 60%">
            <img src="img/gardenia.webp" alt="" width="100px" style="position:absolute; bottom:10%; left: 66%">
            <img src="img/gardenia.webp" alt="" width="150px" style="position:absolute; bottom:10%; left: 68%">
            <img src="img/kokocrunch.webp" alt="" width="70px" style="position:absolute; bottom:10%; left: 82%">
        </div>
        <div class="big-pic" style="position:relative;">
            <div class="big-pic2">
                <h1>Make your Breakfast<br>Healthy and<br>Easy</h1>
                <a href="<?php echo SITEURL; ?>all-products.php?showcase_id=179"><button>Shop Now <i class="fa-solid fa-arrow-right-long"></i> </button></a>
                <img src="img/anchor.webp" alt="" width="70px" style="position:absolute; bottom:10%; left: 57%">
                <img src="img/pic1.webp" alt="" width="100px" style="position:absolute; bottom:10%; left: 60%">
                <img src="img/kokocrunch.webp" alt="" width="150px" style="position:absolute; bottom:10%; left: 68%">
                <img src="img/nesquick.webp" alt="" width="70px" style="position:absolute; bottom:10%; left: 82%">
            </div>
        </div>
    </div>
</section>

<section id="featured-section">
    <div class="container">
        <div class="title-between">
            <h5>Featured Products</h5>
            <a href="all-products.php?featured=true">
                <h6>View All</h6>
            </a>
        </div>
        <div class="products">

            <?php

            $sql2 = "SELECT * FROM tbl_products WHERE active='Yes' AND featured='Yes' LIMIT 15";
            $res2 = mysqli_query($conn, $sql2);
            $count2 = mysqli_num_rows($res2);

            if ($count2 > 0) {

                while ($row = mysqli_fetch_assoc($res2)) {

                    $product_id = $row['product_id'];
                    $product_name = $row['product_name'];
                    $p_category_id = $row['category_id'];
                    $product_price = $row['product_price'];
                    $product_qty = $row['product_qty'];
                    $product_image = $row['product_img'];

            ?>

                    <div class="product-container" style="padding-bottom: 5px !important;">
                        <form action="p-add-to-cart.php" method="POST"  style="height: 100%; position:relative">
                            <figure>
                                <img src="<?php echo SITEURL; ?>img/products/<?php echo $product_image; ?>" width="50px" height="100px">
                            </figure>
                            <div class="product-name" style="color:#555">
                                <h5><?php echo $product_name; ?></h5>
                            </div>

                            <?php

                            $sql3 = "SELECT * FROM tbl_category WHERE category_id='$p_category_id'";
                            $res3 = mysqli_query($conn, $sql3);
                            $row2 = mysqli_fetch_assoc($res3);

                            $p_category_name = $row2['category_name'];

                            ?>

                            <div class="category-name" style="margin-bottom: 30%">
                                <h6><?php echo $p_category_name; ?></h6>
                            </div>
                            <div class="p-foot" style="position:absolute; bottom:0; width: 100%;">
                                <div class="price">
                                    <h4><?php echo "P" . $product_price; ?></h4>
                                </div>
                                <div class="btn">
                                    <input type="hidden" name="product_id" value="<?php echo $product_id ?>">
                                    <input type="hidden" name="product_image" value="<?php echo $product_image ?>">
                                    <input type="hidden" name="product_name" value="<?php echo $product_name ?>">
                                    <input type="hidden" name="product_price" value="<?php echo $product_price ?>">
                                    <input type="hidden" name="product_qty" value="<?php echo $product_qty ?>">
                                    <input type="submit" name="submit-btn" value="ADD +">
                                </div>
                            </div>
                        </form>
                    </div>
            <?php
                }
            }
            ?>

        </div>
    </div>
</section>


<section id="school">
    <div class="container">
        <div class="big-box">
            <h3>Back to School</h3>
            <a href="<?php echo SITEURL; ?>all-products.php?showcase_id=165"><button>Shop Now <i class="fa-solid fa-arrow-right-long"></i> </button></a>
        </div>
    </div>
</section>

<section id="big-pics" style="margin-bottom: 30px">
    <div class="container">
        <div class="big-pic">
            <div class="big-pic3" style="position:relative; display:flex;">
                <h1>Nescafe <br>Original <br>Flavored</h1>
                <div style="position: absolute; width: 200px; left: 50%; bottom: 10px">
                    <img src="img/pic1.webp" alt="" width="100%">
                </div>
            </div>
        </div>
        <div class="big-pic">
            <div class="big-pic4" style="position:relative; display:flex;">
                <h1>Gatorade <br>Energy <br>Drink</h1>
                <div style="position: absolute; width: 200px; left: 50%; bottom: 10px">
                    <img src="img/pic2.webp" alt="" width="100%">
                </div>
            </div>
        </div>
    </div>
</section>

<section id="some-msg">
    <div class="container">
        <div class="bx">
            <h5><i class="fa-solid fa-hand-holding-dollar"></i> Fairly Priced Items</h5>
            <br>
            <p>Shop groceries at an affordable price and dry goods at no mark-up store rate</p>
        </div>
        <div class="bx">
            <h5><i class="fa-solid fa-truck"></i> Fast Delivery</h5>
            <br>
            <p style="font-size:14px">Get your groceries delivered less than 24 hours</p>
        </div>
        <div class="bx">
            <h5><i class="fa-solid fa-martini-glass-empty"></i> Unavailable grocery item?</h5>
            <br>
            <p style="font-size:14px">We'll find a similar product that'll satisfy you</p>
        </div>
    </div>
    <div class="aboutx container">
        <div>
            <h5 style="padding: 30px 0 20px 0">ABOUT US</h5>
            <p style="font-size:14px; line-height:1.6em"> A-Mart Convenience Store is an E-Commerce website that enables individuals to purchase
                their nees from the comfort of their home. We aim to provide excellent service and product at the best price, in order
                to make shopping an ease & life more convenient</p>
        </div>
        <div>
            <h5 style="padding: 30px 0 20px 0">ISAIAH 40:28 <i class="fa-solid fa-book-bible"></i></h5>
            <p style="font-size:14px; line-height:1.6em"> Do you know? Have you not heard? The Lord is the everlasting God, the Creator of the ends of the earth.
                He will not grow tired or weary, and his understanding no one can fathom.</p>
        </div>
    </div>


</section>

<script type="text/javascript">
    let slideIndex = 0;
    showSlides();

    function showSlides() {
        let i;
        let slides = document.getElementsByClassName("mySlides");
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        slideIndex++;
        if (slideIndex > slides.length) {
            slideIndex = 1
        }
        slides[slideIndex - 1].style.display = "block";
        setTimeout(showSlides, 10000); // Change image every 2 seconds
    }
</script>

<?php include('front-partials/footer.php') ?>