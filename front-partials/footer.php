
<footer>
            <section class="footer1">
                <div class="container">
                    <div class="links">
                        <h5>Quick Links</h5>
                        <ul>
                            <li><a href="index.php">Home</a></li>
                            <li><a href="products.php">Products</a></li>
                            <?php
                                if(isset($_SESSION['authenticated'])){
                                    ?>
                                    <li><a href="cart.php">Cart</a></li>
                                    <li><a href="my-orders.php">My Order</a></li>
                                    <?php
                                }
                            ?>
                        </ul>
                    </div>
                    <div class="contact-info">
                        <h5>Contact Us</h5>
                        <ul>
                            <li><i class="fa-solid fa-phone" style="font-size:13px;"></i> 09062699686</li>
                            <li><i class="fa-solid fa-envelope" style="font-size:13px;"></i> amartconveniencestore2022@gmail.com</li>
                        </ul>
                    </div>
                    <div class="socials">
                        <h5>Follow Us</h5>
                        <ul style="display:flex; gap:10px">
                            <li><a href=""><i class="fa-brands fa-facebook"></i></a></li>
                        </ul>
                    </div>
                    </div>
            </section>
            <section class="footer2">
            <div class="container">
                <h5>Copyright 2022 - All Rights Reserved </h5>
                <h5>A-Mart Convenience Store</h5>
                <h5>Purok 4, Lot 1 Villa Teresa, Lunzuran Zamboanga City</h5>
                <div>
                    <h5>Powered By <a class="current" href="#">Modern Solutions</a></h5>
                </div>
            </section>
            </div>
    </footer>
</body>
</html>