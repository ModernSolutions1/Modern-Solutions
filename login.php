<?php include('front-partials/header.php');

if(isset($_SESSION['authenticated'])){
    $reload = "<div><h4><a href='index.php'>x</a></h4></div>";
    $_SESSION['loggedin'] = "<div class='msg-failed'><div></div>You have already logged in. Log out first." . $reload . "</div>";
    header('location:'.SITEURL.'index.php');
}
?>

<?php
if (isset($_SESSION['login-msg'])) {
    echo $_SESSION['login-msg'];
    unset($_SESSION['login-msg']);
}
$counter = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tbl_order_item"));
?>

<!-- HEADER -->
<section id="main-header">
    <div class="container">
        <nav>
            <ul>
                <li><a href="<?php echo SITEURL; ?>">Home</a></li>
                <li><a href="<?php echo SITEURL ?>products.php">Products</a></li>
                <?php if(!isset($_SESSION['authenticated'])){ $hide = "hidden";}else{ $hide="";}?>
                <li <?php echo $hide;?>><a href="<?php echo SITEURL ?>cart.php">Cart <span class="cart-counter" <?php if ($counter < 1) {
                                                                                                        echo 'style="background-color:transparent"';
                                                                                                    } ?>><?php if ($counter > 0) {
                                                                                                                echo $counter;
                                                                                                            } ?></span></a></li>
            </ul>
        </nav>
    </div>
</section>

<section style="width:60%; margin: 0 auto">
<?php
    if(isset($_SESSION['register-msg'])){
        echo $_SESSION['register-msg'];
        unset($_SESSION['register-msg']);
    }
    if(isset($_SESSION['status'])){
        echo $_SESSION['status'];
        unset($_SESSION['status']);
    }
    if(isset($_SESSION['fname'])){
        unset($_SESSION['fname']);
    }
    if(isset($_SESSION['lname'])){
        unset($_SESSION['lname']);
    }
    if(isset($_SESSION['contact'])){
        unset($_SESSION['contact']);
    }
    if(isset($_SESSION['email'])){
        unset($_SESSION['email']);
    }
?></section>
<section id="login">
    <form action="login-auth.php" method="POST">
        <div class="login-side">
            <img src="img/logo.jpg" alt="">
        </div>
        <div class="login-right">
            <h4>A-Mart <span class="current">Convenience</span> Store</h4>
            <h5>Login Now</h5>
            <div class="inputs">
                <input type="text" name="email" placeholder="Enter your email" class="custom-border" required>
                <input type="password" name="password" id="password" placeholder="Enter your password" class="custom-border" required>
                <div>
                    <input type="checkbox" id="checkb" onclick="showpass()">
                    <small>Show Password</small>
                </div>
                <input type="submit" name="btnLogin" value="Login">
            </div>
            <small class="register">Don't have an account? <a href="register.php"> Register here</a></small>
        </div>
    </form>
</section>

<script>
    function showpass() {

        var checkb = document.getElementById('checkb');

        if (checkb.checked) {
            document.getElementById('password').type = "text";
        } else {
            document.getElementById('password').type = "password";
        }
    }
</script>

<?php include('front-partials/footer.php') ?>