<?php
session_start();
include 'db_connect.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

/* CHECK CERTIFICATE */
$q = mysqli_query($conn,
"SELECT * FROM achievements 
 WHERE user_id='$user_id' 
 AND badge_name='Certificate'");

if(mysqli_num_rows($q)==0){
    die("Certificate not unlocked yet");
}

/* USER INFO */
$user = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT * FROM users WHERE user_id='$user_id'"));

$name = $user['name'] ?? 'User';
?>

<!DOCTYPE html>
<html>
<head>
<title>Certificate</title>

<style>
body{
    margin:0;
    font-family:Poppins;
    background:linear-gradient(135deg,#dbeafe,#f0fdf4);
}

.container{
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.card{
    width:600px;
    background:white;
    padding:50px;
    text-align:center;
    border:8px solid gold;
    border-radius:20px;
    box-shadow:0 10px 30px rgba(0,0,0,0.2);
}

h1{color:#0f172a;}
h2{color:#16a34a;font-size:32px;}

.btn{
    display:inline-block;
    margin-top:20px;
    padding:12px 20px;
    background:#16a34a;
    color:white;
    text-decoration:none;
    border-radius:10px;
    font-weight:600;
}
.back{
    background:#0f172a;
}
</style>

</head>

<body>

<div class="container">

<div class="card">

<div style="font-size:70px;">🎓</div>

<h1>Certificate of Achievement</h1>

<p>This certifies that</p>

<h2><?php echo $name; ?></h2>

<p>has successfully completed all required badges</p>

<h3>Literacy Hub</h3>

<a class="btn" href="download_certificate.php">
Download Certificate
</a>

<br>

<a class="btn back" href="achievements.php">
Back
</a>

</div>

</div>

</body>
</html>