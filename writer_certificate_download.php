<?php
session_start();
include 'db_connect.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'writer'){
    die("Access denied");
}

$user_id = $_SESSION['user_id'];

$user = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT username FROM users WHERE user_id='$user_id'"));

$name = $user['username'];

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
<title>Download Certificate</title>

<style>

@media print{
    .btn{ display:none; }
}

body{
    margin:0;
    font-family:Georgia, serif;
    background:white;
}

.wrapper{
    display:flex;
    justify-content:center;
    padding:30px;
}

.certificate{
    width:800px;
    border:8px solid #d4af37;
    padding:25px;
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

.btn{
    padding:10px 18px;
    background:#16a34a;
    color:white;
    border-radius:8px;
    text-decoration:none;
    display:inline-block;
    margin-top:20px;
}

.center{
    text-align:center;
}

</style>

</head>

<body>

<div class="wrapper">

<div class="certificate">

<div class="inner">

<div class="title">WRITER CERTIFICATE</div>

<p class="text">This is to certify that</p>

<div class="name"><?php echo $name; ?></div>

<p class="text">
has successfully completed all writer achievements including:
Publishing, Engagement, and Reader interaction.
</p>

<p class="text">
Awarded for excellence in writing contribution.
</p>

<div class="center">
<button class="btn" onclick="window.print()">Download PDF</button>
</div>

</div>

</div>

</div>

</body>
</html>