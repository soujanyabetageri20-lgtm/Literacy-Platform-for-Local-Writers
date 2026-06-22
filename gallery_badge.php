<?php
session_start();
include 'db_connect.php';

if(!isset($_SESSION['user_id'])){
    die("Login required");
}

$user_id = $_SESSION['user_id'];

if(!isset($_GET['badge'])){
    die("Badge missing");
}

$badge = $_GET['badge'];

$q = mysqli_query($conn,
"SELECT * FROM achievements 
 WHERE user_id='$user_id' 
 AND badge_name='$badge'");

if(mysqli_num_rows($q)==0){
    die("Badge not unlocked");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Download Badge</title>

<style>
body{
    font-family: Arial;
    background:#f0fdf4;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.card{
    width:400px;
    padding:40px;
    background:white;
    border:3px solid #22c55e;
    border-radius:20px;
    text-align:center;
    box-shadow:0 10px 20px rgba(0,0,0,0.1);
}

.icon{
    font-size:60px;
}

.btn{
    margin-top:20px;
    padding:12px 20px;
    border:none;
    background:#16a34a;
    color:white;
    border-radius:10px;
    cursor:pointer;
}
</style>

</head>

<body>

<div class="card">

<div class="icon">🏆</div>

<h2><?php echo $badge; ?></h2>

<p>Congratulations! You earned this badge.</p>

<!-- THIS IS REAL DOWNLOAD -->
<button class="btn" onclick="window.print()">
Download as PDF
</button>

<div style="text-align:center; margin-top:20px;">
    <a href="user_dashboard.php" style="
        display:inline-block;
        padding:12px 25px;
        background:#0f172a;
        color:white;
        text-decoration:none;
        border-radius:12px;
        font-weight:600;
    ">
        ⬅ Back to Dashboard
    </a>
</div>

</div>


</body>
</html>