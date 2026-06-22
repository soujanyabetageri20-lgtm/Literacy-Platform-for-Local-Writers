<?php
session_start();
include 'db_connect.php';

if(!isset($_SESSION['user_id'])){
    die("Login required");
}

$user_id = $_SESSION['user_id'];

/* CHECK CERTIFICATE */
$check = mysqli_query($conn,
"SELECT * FROM achievements 
 WHERE user_id='$user_id' 
 AND badge_name='Certificate'");

if(mysqli_num_rows($check)==0){
    die("Certificate not unlocked");
}

/* USERNAME */
$user = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT username FROM users WHERE user_id='$user_id'"));

$name = $user['username'] ?? 'User';
?>

<!DOCTYPE html>
<html>
<head>
<title>Download Certificate</title>

<style>

/* PRINT SAFE PAGE */
body{
    margin:0;
    background:white;
    font-family:Georgia, serif;
}

/* CENTER ONLY FOR SCREEN */
.wrapper{
    display:flex;
    justify-content:center;
    padding:30px;
}

/* CERTIFICATE BOX (PRINT FRIENDLY) */
.certificate{
    width:780px;
    border:8px solid #d4af37;
    padding:25px;
    box-shadow:0 10px 25px rgba(0,0,0,0.15);
}

/* INNER BORDER */
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
    font-size:18px;
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
    text-align:center;
    color:#334155;
    line-height:1.6;
}

/* SIGNATURE */
.signature{
    margin-top:25px;
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
    border:none;
    cursor:pointer;
}

.back{
    background:#0f172a;
    color:white;
}

/* PRINT SETTINGS */
@media print{
    .btn{
        display:none;
    }
    body{
        background:white;
    }
}

</style>

</head>

<body>

<div class="wrapper">

<div class="certificate">

<div class="inner">

<div class="symbol">🏆 🎓 📜</div>

<div class="title">CERTIFICATE OF ACHIEVEMENT</div>

<div class="symbol">────────────────────────</div>

<p class="text">This is to certify that</p>

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
<div>📅 <?php echo date("d M Y"); ?></div>
<div>🏛 Literacy Hub System</div>
</div>

<!-- BUTTONS -->
<div style="text-align:center;margin-top:20px;">
<button class="btn download" onclick="window.print()">Download PDF</button>
<a href="achievements.php" class="btn back">Back</a>
</div>

</div>

</div>

</div>

</body>
</html>