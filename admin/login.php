<?php include('../config/constants.php') ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Login</title>
</head>

<?php

if (isset($_POST['submit'])) {

    $username = $_POST['uname'];
    $password = $_POST['pass'];

    if (!empty(trim($username) && !empty(trim($password)))) {

        $sql = "SELECT * FROM tbl_admin WHERE admin_username='$username' AND admin_pass='$password'";

        $res = mysqli_query($conn, $sql);

        $count = mysqli_num_rows($res);

        if ($count > 0) {
            $_SESSION['login'] = "<script>alert('Login Successful')</script>";
            $_SESSION['user'] = $username;
            $fetch = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tbl_admin WHERE admin_username = '$username' AND admin_pass='$password'"));
            $_SESSION['usertype'] = $fetch['usertype'];

            if($_SESSION['usertype']=='Admin'){
                header('location:'.SITEURL.'admin/');
            }elseif($_SESSION['usertype']=='Cashier'){
                header('location:'.SITEURL.'admin/store.php');
            }
            
        } else {
            $_SESSION['login'] = "<div class='message-failed'>Login Failed</div>";
            header('location:' . SITEURL . 'admin/login.php');
        }
    }
}
?>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: arial, sans-serif, helvetica;
        background-color: #f4f4f4;
    }

    #login-container {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        width: 25%;
        margin: 5% 38% auto 38%;
    }

    form {
        border: 1px solid #ccc;
        width: 100%;
        background-color: white;
        border-radius: 5px;
        box-shadow: 0px 0px 10px 0px #ccc;
    }

    h5,
    h6 {
        text-transform: uppercase;
    }

    .to-center {
        text-align: center;
    }

    .form-control {
        width: 100%;
        margin: 10px 0 20px 0;
    }

    input {
        padding: 10px;
        width: 100%;
        border: 1px solid #ccc;
        outline: 0;
    }

    input[type='submit'] {
        background-color: green;
        border: none;
        color: white;
        border-radius: 3px;
        cursor: pointer;
        margin-top: 10px;
    }

    input[type='submit']:hover {
        color: white;
        background-color: red;
    }

    .title {
        padding: 20px;
        border-bottom: 1px solid red;
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 10px;
    }

    .box {
        padding: 20px;
    }

    .form-footer {
        border-top: 1px solid #ccc;
        color: black;
        padding: 10px 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px;
    }

    .form-footer .powered {
        background-color: red;
        color: white;
        padding: 3px 5px;
        border-radius: 10px;
        border: none;
    }

    span {
        color: red;
        align-items: center;
    }

    .company {
        color: blue
    }

    .back {
        display: flex;
        justify-content: flex-end;
        text-align: right;
        width: 100%;
        padding-top: 20px;
    }

    .back a {
        text-decoration: none;
        color: #555;
    }

    .to-right {
        text-align: right;
    }

    .message-success {
        width: 100%;
        padding: 2px 5px;
        background-color: rgb(0, 255, 0, 0.1);
        border: 1px solid green;
        color: green;
        font-size: 12px;
    }

    .message-failed {
        width: 100%;
        padding: 10px;
        background-color: rgba(255, 166, 0, 0.212);
        color: rgba(255, 68, 0, 0.897);
        font-size: 12px;
        text-align: center;
    }
</style>

<body>

    <section id="login-container">
        <img src="../img/amart-logo.png" alt=""  style="padding:20px; width:100px">
        <form method="POST">
            <div class="title">

                <h5 class="to-center">Admin Login</h5>
            </div>
            <?php
            if (isset($_SESSION['login'])) {
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }
            if (isset($_SESSION['not-logged-in'])) {
                echo $_SESSION['not-logged-in'];
                unset($_SESSION['not-logged-in']);
            }
            ?>
            <section class="box">
                <div class="form-control">
                    <input type="text" name="uname" placeholder="Username" required>
                </div>
                <div class="form-control">
                    <input type="password" name="pass" placeholder="Password" required>
                </div>
                <div class="form-control">
                    <input type="submit" name="submit" value="Login">
                </div>
            </section>
            <div class="form-footer">
                <h5 class="to-center">A-Mart <span>Convenience</span> Store</h5>

            </div>
        </form>
        <div class="back to-right">
            <div>
                <h6 class="powered">Powered by</h6>
                <h6><span class="company">Modern Solutions</span></h6>
            </div>
        </div>
        <div class="back">
        <a href="<?php echo SITEURL; ?>index.php">Go back to store</a>
        </div>       
    </section>
</body>

</html>