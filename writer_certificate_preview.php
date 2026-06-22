<?php
session_start();
include 'db_connect.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'writer'){
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

$user = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT username FROM users WHERE user_id='$user_id'"));

$name = $user['username'];

/* CHECK CERTIFICATE */
$check = mysqli_query($conn,
"SELECT * FROM achievements 
 WHERE user_id='$user_id' 
 AND badge_name='Certificate'");

if(mysqli_num_rows($check)==0){
    die("Certificate not unlocked");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Writer Certificate</title>

<style>

body{
    margin:0;
    background:#f3f4f6;
    font-family:Georgia, serif;
    padding:30px;
}

.container{
    display:flex;
    justify-content:center;
}

.certificate{
    width:780px;
    border:8px solid #d4af37;
    background:white;
    padding:25px;
    box-shadow:0 10px 25px rgba(0,0,0,0.15);
}

.inner{
    border:2px solid #d4af37;
    padding:20px;
}

.title{
    text-align:center;
    font-size:28px;
    font-weight:bold;
}

.name{
    text-align:center;
    font-size:34px;
    font-weight:bold;
    color:#16a34a;
    margin:15px 0;
}

.text{
    text-align:center;
    font-size:16px;
    line-height:1.6;
    color:#334155;
}

.btns{
    text-align:center;
    margin-top:20px;
}

.btn{
    padding:10px 18px;
    margin:5px;
    border-radius:8px;
    text-decoration:none;
    font-weight:bold;
}

.download{
    background:#16a34a;
    color:white;
}

.back{
    background:#0f172a;
    color:white;
}

</style>

</head>

<body>

<div class="container">

<div class="certificate">

<div class="inner">

<div class="title">WRITER CERTIFICATE</div>

<p class="text">This is to certify that</p>

<div class="name"><?php echo $name; ?></div>

<p class="text">
has successfully completed all writer achievements in the
Literacy Hub Platform including publishing posts, gaining likes,
and reader engagement.
</p>

<p class="text">
This certificate recognizes outstanding contribution as a writer.
</p>

<div class="btns">

<a href="writer_certificate_download.php" class="btn download">
Download PDF
</a>

<a href="achievements.php" class="btn back">
Back
</a>

</div>

</div>

</div>

</div>

</body>
</html>