<?php 
    include('config/constants.php');

    if(isset($_GET['id'])){
        $id = $_GET['id'];

        $sql = "UPDATE tbl_order SET
        cancel_request='Cancel Request'
        WHERE order_id = $id";
        $sql_run = mysqli_query($conn, $sql);

        $reload = "<div><h4><a href='myorder.php'>x</a></h4></div>";
        $_SESSION['cancel'] = "<div class='msg-success'><div></div>Cancel Request sent!" . $reload . "</div>";
        header('location:'.SITEURL.'myorder.php');   
    }
?>