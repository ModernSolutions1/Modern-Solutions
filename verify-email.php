<?php

include('front-partials/header.php');
?>

<?php

    if(isset($_GET['token'])){

        $token = $_GET['token'];
        $verify_token = "SELECT * FROM tbl_customer WHERE verify_token = '$token' LIMIT 1";

        $verify_query = mysqli_query($conn, $verify_token);

        if(mysqli_num_rows($verify_query)>0){
            $row = mysqli_fetch_assoc($verify_query);

            if($row['verified'] == "0"){

                $clicked_token = $row['verify_token'];
                $update_query = "UPDATE tbl_customer SET verified='1' WHERE verify_token='$clicked_token'";
                $update_query_run = mysqli_query($conn, $update_query);

                if($update_query_run){
                    $reload = "<div><h4><a href='login.php'>x</a></h4></div>";
                    $_SESSION['status'] = "<div class='message-success'><div></div>E-mail Address Verification Successful! Please login!" . $reload . "</div>"; 
                    header('location:' . SITEURL . 'login.php');
                    exit(0);
                }else{
                    $reload = "<div><h4><a href='login.php'>x</a></h4></div>";
                    $_SESSION['login-msg'] = "<div class='message-failed'><div></div>Verification Failed" . $reload . "</div>";
                    header('location:' . SITEURL . 'login.php');
                    exit(0);
                }
                
            }else{
                $reload = "<div><h4><a href='login.php'>x</a></h4></div>";
                $_SESSION['login-msg'] = "<div class='message-failed'><div></div>Your email address was already verified!" . $reload . "</div>";
                header('location:' . SITEURL . 'login.php');
                exit(0);
            }
        }
    }
    else{

        $_SESSION['verification-msg'] = "Access denied.";
        header('location:'.SITEURL.'login.php');
    }
?>