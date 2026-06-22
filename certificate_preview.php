<?php
session_start();
include 'db_connect.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

/* CHECK CERTIFICATE */
$check = mysqli_query($conn,
"SELECT * FROM achievements 
 WHERE user_id='$user_id' 
 AND badge_name='Certificate'");

if(mysqli_num_rows($check)==0){
    die("<h2 style='text-align:center;font-family:Arial;'>Certificate not unlocked yet</h2>");
}

/* USERNAME */
$user = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT username FROM users WHERE user_id='$user_id'"));

$name = $user['username'] ?? 'User';
?>

<!DOCTYPE html>
<html>
<head>
<title>Certificate</title>

<style>

body{
    margin:0;
    background:#f3f4f6;
    font-family:Georgia, serif;
    padding:30px 0; /* IMPORTANT FIX */
}

/* NO FULL SCREEN CENTER (THIS WAS CAUSING CUT) */
.container{
    display:flex;
    justify-content:center;
}

/* REDUCED HEIGHT + SAFE WIDTH */
.certificate{
    width:750px;
    background:white;
    border:8px solid #d4af37;
    padding:25px;
    box-shadow:0 10px 25px rgba(0,0,0,0.2);
}

/* INNER */
.inner{
    border:2px solid #d4af37;
    padding:20px;
}

/* TITLE */
.title{
    font-size:28px;
    font-weight:bold;
    text-align:center;
    color:#0f172a;
}

/* SYMBOL */
.symbol{
    text-align:center;
    font-size:20px;
    margin:5px 0;
}

/* NAME */
.name{
    font-size:36px;
    font-weight:bold;
    color:#16a34a;
    text-align:center;
    margin:15px 0;
    text-transform:capitalize;
}

/* TEXT */
.text{
    font-size:16px;
    color:#334155;
    line-height:1.6;
    text-align:center;
    margin:6px 0;
}

/* SIGNATURE */
.signature{
    margin-top:20px;
    display:flex;
    justify-content:space-between;
    font-size:13px;
    color:#64748b;
}

/* BUTTONS */
.btn{
    padding:10px 16px;
    margin:8px;
    border-radius:8px;
    text-decoration:none;
    font-weight:600;
    display:inline-block;
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

<div class="symbol">🏆 🎓 📜</div>

<div class="title">CERTIFICATE OF ACHIEVEMENT</div>

<div class="symbol">────────────────────────</div>

<p class="text">
This is to certify that
</p>

<div class="name">
    <?php echo htmlspecialchars($name); ?>
</div>

<p class="text">
has successfully completed all required learning activities, engagement tasks, and interactive achievements
within the <b>Literacy Hub Platform</b>.
</p>

<p class="text">
The above-named participant has demonstrated consistent contribution, active participation, and successful completion
of all mandatory badge requirements including reading engagement, community interaction, and content participation.
</p>

<p class="text">
This certificate is awarded in recognition of dedication, performance, and successful achievement of platform milestones.
</p>

<div class="symbol">────────────────────────</div>

<div class="signature">
<div>📅 Date: <?php echo date("d M Y"); ?></div>
<div>🏛 Literacy Hub Authority</div>
</div>

<!-- BUTTONS -->
<div style="margin-top:25px;">
<a href="download_certificate.php" class="btn download">Download</a>
<a href="achievements.php" class="btn back">Back</a>
</div>

</div>

</div>

</div>

</body>
</html>