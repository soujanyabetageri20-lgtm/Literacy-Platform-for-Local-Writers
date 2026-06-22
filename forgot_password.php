<?php
session_start();
include 'db_connect.php';

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST['send_otp'])){

    $email = trim($_POST['email']);

    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if(mysqli_num_rows($check) > 0){

        $otp = rand(100000,999999);
        $expiry = date("Y-m-d H:i:s", strtotime("+5 minutes"));

        mysqli_query($conn, "UPDATE users 
            SET otp='$otp', otp_expiry='$expiry' 
            WHERE email='$email'");

        $_SESSION['reset_email'] = $email;

        // 🔴 TEMP: Showing OTP (testing only)
        $mail = new PHPMailer(true);

try {

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;

    $mail->Username = 'soujanyabetageri20@gmail.com';
    $mail->Password = 'flpdowlbasskmcoj';

    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('soujanyabetageri20@gmail.com', 'Drama Website');

    $mail->addAddress($email);

    $mail->isHTML(true);

    $mail->Subject = 'Password Reset OTP';

    $mail->Body = "
        <h3>Password Reset OTP</h3>
        <p>Your OTP is: <b>$otp</b></p>
        <p>This OTP expires in 5 minutes.</p>
    ";

    $mail->send();

    echo "<script>
            alert('OTP sent to your email');
            window.location='reset_password.php';
          </script>";

} catch (Exception $e) {

    echo "<script>alert('Mail not sent');</script>";
}

    } else {
        echo "<script>alert('Email not registered');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Forgot Password</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="register-card">
<h2>Forgot Password</h2>

<form method="POST">
<input type="email" name="email" placeholder="Enter your email" required>
<input type="submit" name="send_otp" value="Send OTP">
</form>

<p><a href="login.html">⬅ Back to Login</a></p>

</div>

</body>
</html>