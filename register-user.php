<?php include('front-partials/header.php');

include('smtp/PHPMailerAutoload.php');

function smtp_mailer($to,$subject, $msg){
	$mail = new PHPMailer(true);
	//$mail->SMTPDebug = 1;
	$mail->IsSMTP();
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = 'tls';
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 587;
	$mail->isHTML(true);
	$mail->CharSet = 'UTF-8';
	$mail->Username = "amartconveniencestore2022@gmail.com"; 
	$mail->Password = "amart123cstore";
	$mail->SetFrom("amartconveniencestore2022@gmail.com");
	$mail->Subject = $subject;
	$mail->Body = $msg;
	$mail->AddAddress($to);
	$mail->SMTPOptions=array('ssl'=>array(
		'verify_peer'=>false,
		'verify_peer_name'=>false,
		'allow_self_signed'=>false
	));
	if(!$mail->Send()){
		return 0;
	}else{
		return 1;
	}
}

    //register
    if(isset($_POST['submity'])){

        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $fullname = $fname.' '.$lname;
        $email = $_POST['email'];
        $contact = $_POST['contact'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        $verify_token = md5(rand());

        $_SESSION['fname'] = $fname;
        $_SESSION['lname'] = $lname;

        $sql = "SELECT * FROM tbl_customer WHERE customer_email='$email' LIMIT 1";
        $res = mysqli_query($conn, $sql);

        if(mysqli_num_rows($res)>0){
            $_SESSION['contact'] = $contact;
            $reload = "<div><h4><a href='register.php'>x</a></h4></div>";
            $_SESSION['register-msg'] = "<div class='msg-failed'><div></div>Email address already exist." . $reload . "</div>";
            header('location:'.SITEURL.'register.php');
        }
        else{

            if(($password != $password2) and $password2){

                $reload = "<div><h4><a href='register.php'>x</a></h4></div>";
                $_SESSION['register-msg'] = "<div class='msg-failed'><div></div>Password doesn't match" . $reload . "</div>";
                header('location:'.SITEURL.'register.php');

            }else{

                if(preg_match('/^[0-9]{11}+$/', $contact)){

                    $sql2 = "INSERT INTO tbl_customer SET
                    customer_fname = '$fname',
                    customer_lname = '$lname',
                    customer_email = '$email',
                    customer_phone = $contact,
                    customer_pass = '$password',
                    verify_token = '$verify_token'
                ";

                $res2 = mysqli_query($conn, $sql2);

                if($res2){
                    $message = "
                    
                    <h2>You have registered with A-Mart Convenience Store</h2>
                    <h3>Verify your email address to login with the below given link</h3>
                    <a href='http://localhost/Product-Ordering-System/verify-email.php?token=$verify_token'>Click Here</a>

                    ";
                    smtp_mailer($email, 'Email Verification', $message); 
                    $reload = "<div><h4><a href='login.php'>x</a></h4></div>";
                    $_SESSION['register-msg'] = "<div class='msg-success'><div></div>Registration Successful! Please verify your e-mail address to Login." . $reload . "</div>";
                    header('location:'.SITEURL.'login.php');
                }
                else{
                    $reload = "<div><h4><a href='register.php'>x</a></h4></div>";
                    $_SESSION['register-msg'] = "<div class='msg-failed'><div></div>Registration Failed" . $reload . "</div>";
                    header('location:'.SITEURL.'register.php');
                }
                }else{
                    $_SESSION['email'] = $_POST['email'];
                    $reload = "<div><h4><a href='register.php'>x</a></h4></div>";
                    $_SESSION['register-msg'] = "<div class='msg-failed'><div></div>Please input a valid number." . $reload . "</div>";
                    header('location:'.SITEURL.'register.php');
                }

            }      
        }
    }
?>
