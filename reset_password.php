<?php
session_start();
include 'db_connect.php';

/* SESSION CHECK */

if(!isset($_SESSION['reset_email'])){
    exit("Session expired");
}

$email = $_SESSION['reset_email'];

/* ================= OTP VERIFY ================= */

if(isset($_POST['verify_otp'])){

    $otp = mysqli_real_escape_string($conn, $_POST['otp']);

    $check = mysqli_query($conn,
    "SELECT * FROM users
     WHERE email='$email'
     AND otp='$otp'
     AND otp_expiry >= NOW()");

    if(mysqli_num_rows($check) > 0){

        echo "verified";

    } else {

        echo "invalid";
    }

    exit();
}

/* ================= RESET PASSWORD ================= */

if(isset($_POST['ajax_reset'])){

    $otp = mysqli_real_escape_string($conn, $_POST['otp']);

    $password = $_POST['password'];

    $confirm = $_POST['confirm_password'];

    /* PASSWORD MATCH */

    if($password !== $confirm){

        echo "Passwords do not match";
        exit();
    }

    /* PASSWORD VALIDATION */

    if(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,20}$/', $password)){

        echo "Password must contain uppercase, lowercase, number and special character";

        exit();
    }

    /* OTP CHECK */

    $result = mysqli_query($conn,
    "SELECT * FROM users
     WHERE email='$email'
     AND otp='$otp'
     AND otp_expiry >= NOW()");

    if(mysqli_num_rows($result) > 0){

        $hashed = password_hash($password, PASSWORD_DEFAULT);

        mysqli_query($conn,
        "UPDATE users
         SET password='$hashed',
             otp=NULL,
             otp_expiry=NULL
         WHERE email='$email'");

        session_destroy();

        echo "success";

    } else {

        echo "Invalid or expired OTP";
    }

    exit();
}
?>

<!DOCTYPE html>
<html>

<head>

<title>Reset Password</title>

<link rel="stylesheet" href="style.css">

<style>

#ajax-msg{

    margin-bottom:15px;
    font-weight:bold;
    text-align:center;
}

#verifyBtn{

    width:100%;
    padding:12px;

    margin-top:10px;
    margin-bottom:15px;

    border:none;
    border-radius:12px;

    background:linear-gradient(to right,#2563eb,#1d4ed8);

    color:white;

    font-size:15px;
    font-weight:600;

    cursor:pointer;

    transition:0.3s;
}

#verifyBtn:hover{

    transform:scale(1.02);

    background:linear-gradient(to right,#1d4ed8,#1e40af);
}

</style>

</head>

<body>

<div class="register-card">

<h2>Reset Password</h2>

<!-- AJAX MESSAGE -->

<div id="ajax-msg"></div>

<form id="resetForm">

<!-- OTP FIELD -->

<input type="text"
name="otp"
placeholder="Enter OTP"
required>

<!-- VERIFY BUTTON -->

<button type="button"
id="verifyBtn"
onclick="verifyOTP()">

Verify OTP

</button>

<!-- PASSWORD SECTION -->

<div id="passwordSection"
style="display:none;">

<input type="password"
name="password"
placeholder="New Password">

<small id="pass-msg"
style="display:block;
margin-bottom:10px;
color:red;">

Password must be 8-20 characters and include uppercase, lowercase, number, special character

</small>

<input type="password"
name="confirm_password"
placeholder="Confirm Password">

<input type="submit"
value="Reset Password">

</div>

</form>

<p>

<a href="login.html">

⬅ Back to Login

</a>

</p>

</div>

<!-- ================= JAVASCRIPT ================= -->

<script>

const form =
document.getElementById("resetForm");

const password =
document.querySelector('input[name="password"]');

const confirm =
document.querySelector('input[name="confirm_password"]');

const msg =
document.getElementById("pass-msg");

const ajaxMsg =
document.getElementById("ajax-msg");

/* ================= VERIFY OTP ================= */

function verifyOTP(){

    let otp =
    document.querySelector('input[name="otp"]').value;

    let formData = new FormData();

    formData.append("verify_otp", true);

    formData.append("otp", otp);

    fetch("", {

        method: "POST",
        body: formData

    })

    .then(response => response.text())

    .then(data => {

        if(data.trim() === "verified"){

            ajaxMsg.innerHTML =
            "✅ OTP Verified";

            ajaxMsg.style.color =
            "green";

            /* SHOW PASSWORD SECTION */

            document.getElementById("passwordSection")
            .style.display = "block";

            /* HIDE OTP FIELD */

            document.querySelector('input[name="otp"]')
            .style.display = "none";

            /* HIDE VERIFY BUTTON */

            document.getElementById("verifyBtn")
            .style.display = "none";

        } else {

            ajaxMsg.innerHTML =
            "❌ Invalid or expired OTP";

            ajaxMsg.style.color =
            "red";
        }

    });

}

/* ================= LIVE VALIDATION ================= */

password.addEventListener("input", validatePassword);

confirm.addEventListener("input", validatePassword);

function validatePassword(){

    const pass = password.value;

    const confirmPass = confirm.value;

    const pattern =
    /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,20}$/;

    /* EMPTY */

    if(pass === ""){

        password.style.border = "";

        msg.innerHTML =
        "Password must be 8-20 characters and include uppercase, lowercase, number, special character";

        msg.style.color = "red";
    }

    /* INVALID */

    else if(!pattern.test(pass)){

        password.style.border =
        "2px solid red";

        msg.innerHTML =
        "Include uppercase, lowercase, number and special character";

        msg.style.color = "orange";
    }

    /* VALID */

    else{

        password.style.border =
        "2px solid green";

        if(pass.length <= 10){

            msg.innerHTML =
            "🟠 Requirements satisfied • Weak password";

            msg.style.color =
            "orange";
        }

        else if(pass.length <= 15){

            msg.innerHTML =
            "🔵 Requirements satisfied • Medium password";

            msg.style.color =
            "#2563eb";
        }

        else{

            msg.innerHTML =
            "🟢 Requirements satisfied • Strong password";

            msg.style.color =
            "green";
        }
    }

    /* CONFIRM PASSWORD */

    if(confirmPass !== ""){

        if(pass !== confirmPass){

            confirm.style.border =
            "2px solid red";

        } else {

            confirm.style.border =
            "2px solid green";
        }
    }
}

/* ================= AJAX SUBMIT ================= */

form.addEventListener("submit", function(e){

    e.preventDefault();

    const formData =
    new FormData(form);

    formData.append("ajax_reset", true);

    fetch("", {

        method: "POST",
        body: formData

    })

    .then(response => response.text())

    .then(data => {

        ajaxMsg.style.display =
        "block";

        if(data.trim() === "success"){

            ajaxMsg.innerHTML =
            "✅ Password updated successfully";

            ajaxMsg.style.color =
            "green";

            setTimeout(() => {

                window.location =
                "login.html";

            }, 1500);

        } else {

            ajaxMsg.innerHTML =
            "❌ " + data;

            ajaxMsg.style.color =
            "red";
        }

    });

});

</script>

</body>
</html>