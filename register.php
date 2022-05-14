<?php include('front-partials/header.php');

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

<?php 
    if(isset($_SESSION['register-msg'])){
        echo $_SESSION['register-msg'];
        unset($_SESSION['register-msg']);
    }
?>

<section id="register">
    <form action="register-user.php" method="POST">
        <div class="register-side">
            <img src="img/logo.jpg" alt="">
        </div>
        <div class="register-right">
            <h4>A-Mart <span class="current">Convenience</span> Store</h4>
            <h5>Register Now</h5>
            <div class="inputs">
                <div class="fullname">
                    <input type="text" name="fname" placeholder="First Name" class="custom-border" value="<?php if(isset($_SESSION['fname'])){ echo $_SESSION['fname'];}?>" required>
                    <input type="text" name="lname" placeholder="Last Name" class="custom-border" value="<?php if(isset($_SESSION['lname'])){ echo $_SESSION['lname'];}?>" required>
                </div>
                <input type="tel" name="contact" placeholder="Phone Number" maxlength="11" value="<?php if(isset($_SESSION['contact'])){ echo $_SESSION['contact'];}?>" class="custom-border" required>
                <input type="email" name="email" placeholder="Email" class="custom-border" value="<?php if(isset($_SESSION['email'])){ echo $_SESSION['email'];}?>" required>
                <input type="password" name="password" id="password" placeholder="Password" class="custom-border" required>
                <input type="password" name="password2" id="password1" placeholder="Confirm Password" class="custom-border" required>
                <div>
                    <input type="checkbox" id="checkb" onclick="showpass()">
                    <small>Show Password</small>
                </div>
                <input type="submit" name="submity" value="Register">
            </div>
            <small class="login">Already have an account? <a href="login.php"> Login here</a></small>
        </div>
    </form>
</section>
<script>
    function showpass() {

        var checkb = document.getElementById('checkb');

        if (checkb.checked) {
            document.getElementById('password').type = "text";
            document.getElementById('password1').type = "text";
        } else {
            document.getElementById('password').type = "password";
            document.getElementById('password1').type = "password";
        }
    }
</script>

<?php include('front-partials/footer.php') ?>