<?php
include('config/constants.php');
?>

<?php

if (isset($_POST['btnLogin'])) {

    if(!empty(trim($_POST['email']) && !empty(trim($_POST['password'])))){

        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        $login = "SELECT * FROM tbl_customer WHERE customer_email='$email' AND customer_pass='$password' LIMIT 1";
        $login_run = mysqli_query($conn, $login);

        if(mysqli_num_rows($login_run)){

            $row = mysqli_fetch_array($login_run);

            if($row['verified']==1){
                $_SESSION['authenticated'] = TRUE;
                $_SESSION['auth_user'] = [
                    'username' => $row['customer_fname'].' '.$row['customer_lname'],
                    'phone' => $row['customer_phone'],
                    'email' => $row['customer_email'],
                ];
                if($_SESSION['checkoutbtn']){
                    header('location:'.SITEURL.'checkout.php');
                }else{
                    header('location:'.SITEURL.'index.php');
                }
                
            }else{
                $reload = "<div><h4><a href='login.php'>x</a></h4></div>";
                $_SESSION['status'] = "<div class='msg-failed'><div></div>Please verify your email first." . $reload . "</div>";
                header('location:'.SITEURL.'login.php');
            }

        }else{
            $reload = "<div><h4><a href='login.php'>x</a></h4></div>";
                $_SESSION['status'] = "<div class='msg-failed'><div></div>Invalid email or password." . $reload . "</div>";
                header('location:'.SITEURL.'login.php');
        }

    }else{

        echo "Fill up properly.";
        header('location:'.SITEURL.'login.php');
    }
}
?>