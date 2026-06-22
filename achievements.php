<?php
session_start();
include 'db_connect.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

/* ================= STATS ================= */

$user_comments = $user_ratings = $user_likes = 0;
$total_posts = $total_likes = $total_ratings = 0;

/* USER STATS */
if($role == 'user'){

    $user_comments = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT COUNT(*) as total FROM comments WHERE user_id='$user_id'"))['total'];

    $user_ratings = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT COUNT(*) as total FROM ratings WHERE user_id='$user_id'"))['total'];

    $user_likes = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT COUNT(*) as total FROM post_reactions 
     WHERE user_id='$user_id' 
     AND reaction='like'"))['total'];
}

/* WRITER STATS */
if($role == 'writer'){

    $total_posts = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT COUNT(*) as total 
     FROM posts 
     WHERE author_id='$user_id'"))['total'];

    $total_likes = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT COUNT(*) as total 
     FROM post_reactions pr 
     JOIN posts p ON pr.post_id=p.post_id
     WHERE p.author_id='$user_id' 
     AND pr.reaction='like'"))['total'];

    $total_ratings = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT COUNT(*) as total 
     FROM ratings r 
     JOIN posts p ON r.post_id=p.post_id
     WHERE p.author_id='$user_id'"))['total'];
}

/* ================= CHECK FUNCTION ================= */

function isUnlocked($conn,$user_id,$badge){

    $q = mysqli_query($conn,
    "SELECT 1 FROM achievements 
     WHERE user_id='$user_id' 
     AND badge_name='$badge'
     LIMIT 1");

    return mysqli_num_rows($q) > 0;
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Achievements</title>

    <link rel="stylesheet" href="achievements.css">

</head>

<body>

<div class="achievement-container">

<h1>🏆 Achievements</h1>

<p class="sub-text">
    Unlock badges by activity
</p>

<div class="badge-grid">

<!-- ================= USER BADGES ================= -->

<?php if($role == 'user'){ ?>

<!-- BOOK EXPLORER -->

<div class="badge-card">

<div class="badge-icon">📚</div>

<h2>Book Explorer</h2>

<?php if(!isUnlocked($conn,$user_id,'Book Explorer')){ ?>

<p>Requirement: 1 like</p>

<div class="progress-text">
    <?php echo $user_likes; ?>/1
</div>

<div class="progress-bar">

    <div class="progress-fill"
    style="width:<?php echo min(($user_likes/1)*100,100); ?>%">

    </div>

</div>

<button onclick="unlockBadge('Book Explorer')"
class="unlock-btn">

Unlock Badge

</button>

<?php } else { ?>

<span class="unlocked-text">
    ✔ Unlocked
</span>

<a href="download_badge.php?badge=Book Explorer"
class="download-btn">

View

</a>

<?php } ?>

</div>

<!-- COMMUNITY VOICE -->

<div class="badge-card">

<div class="badge-icon">💬</div>

<h2>Community Voice</h2>

<?php if(!isUnlocked($conn,$user_id,'Community Voice')){ ?>

<p>Requirement: 1 comment</p>

<div class="progress-text">
    <?php echo $user_comments; ?>/1
</div>

<div class="progress-bar">

    <div class="progress-fill"
    style="width:<?php echo min(($user_comments/1)*100,100); ?>%">

    </div>

</div>

<button onclick="unlockBadge('Community Voice')"
class="unlock-btn">

Unlock Badge

</button>

<?php } else { ?>

<span class="unlocked-text">
    ✔ Unlocked
</span>

<a href="download_badge.php?badge=Community Voice"
class="download-btn">

View

</a>

<?php } ?>

</div>

<!-- TOP SUPPORTER -->

<div class="badge-card">

<div class="badge-icon">❤️</div>

<h2>Top Supporter</h2>

<?php if(!isUnlocked($conn,$user_id,'Top Supporter')){ ?>

<p>Requirement: 1 rating</p>

<div class="progress-text">
    <?php echo $user_ratings; ?>/1
</div>

<div class="progress-bar">

    <div class="progress-fill"
    style="width:<?php echo min(($user_ratings/1)*100,100); ?>%">

    </div>

</div>

<button onclick="unlockBadge('Top Supporter')"
class="unlock-btn">

Unlock Badge

</button>

<?php } else { ?>

<span class="unlocked-text">
    ✔ Unlocked
</span>

<a href="download_badge.php?badge=Top Supporter"
class="download-btn">

View

</a>

<?php } ?>

</div>

<?php } ?>

<!-- ================= WRITER BADGES ================= -->

<?php if($role == 'writer'){ ?>

<!-- Published Author -->

<div class="badge-card">

<div class="badge-icon">✍️</div>

<h2>Published Author</h2>

<?php if(!isUnlocked($conn,$user_id,'Published Author')){ ?>

<p>Requirement: 1 post</p>

<div class="progress-text">
    <?php echo $total_posts; ?>/1
</div>

<div class="progress-bar">

    <div class="progress-fill"
    style="width:<?php echo min(($total_posts/1)*100,100); ?>%">

    </div>

</div>

<button onclick="unlockBadge('Published Author')"
class="unlock-btn">

Unlock Badge

</button>

<?php } else { ?>

<span class="unlocked-text">
    ✔ Unlocked
</span>

<a href="download_badge.php?badge=Published Author"
class="download-btn">

View

</a>

<?php } ?>

</div>

<!-- Trending Writer -->

<div class="badge-card">

<div class="badge-icon">🔥</div>

<h2>Trending Writer</h2>

<?php if(!isUnlocked($conn,$user_id,'Trending Writer')){ ?>

<p>Requirement: 1 like</p>

<div class="progress-text">
    <?php echo $total_likes; ?>/1
</div>

<div class="progress-bar">

    <div class="progress-fill"
    style="width:<?php echo min(($total_likes/1)*100,100); ?>%">

    </div>

</div>

<button onclick="unlockBadge('Trending Writer')"
class="unlock-btn">

Unlock Badge

</button>

<?php } else { ?>

<span class="unlocked-text">
    ✔ Unlocked
</span>

<a href="download_badge.php?badge=Trending Writer"
class="download-btn">

View

</a>

<?php } ?>

</div>

<!-- Reader Favorite -->

<div class="badge-card">

<div class="badge-icon">⭐</div>

<h2>Reader Favorite</h2>

<?php if(!isUnlocked($conn,$user_id,'Reader Favorite')){ ?>

<p>Requirement: 1 rating</p>

<div class="progress-text">
    <?php echo $total_ratings; ?>/1
</div>

<div class="progress-bar">

    <div class="progress-fill"
    style="width:<?php echo min(($total_ratings/1)*100,100); ?>%">

    </div>

</div>

<button onclick="unlockBadge('Reader Favorite')"
class="unlock-btn">

Unlock Badge

</button>

<?php } else { ?>

<span class="unlocked-text">
    ✔ Unlocked
</span>

<a href="download_badge.php?badge=Reader Favorite"
class="download-btn">

View

</a>

<?php } ?>

</div>

<?php } ?>

</div>

<!-- ================= CERTIFICATE ================= -->

<?php

$required = ($role=='user')
? ["Book Explorer","Community Voice","Top Supporter"]
: ["Published Author","Trending Writer","Reader Favorite"];

$completed = true;

foreach($required as $b){

    if(!isUnlocked($conn,$user_id,$b)){

        $completed = false;
        break;
    }
}

$cert_q = mysqli_query($conn,
"SELECT 1 FROM achievements 
 WHERE user_id='$user_id' 
 AND badge_name='Certificate' 
 LIMIT 1");

$cert_unlocked = mysqli_num_rows($cert_q) > 0;

?>

<div class="certificate-section">

<h2>🎓 Certificate</h2>

<?php if(!$completed){ ?>

<div class="certificate-box locked">

    <p>
        🔒 Complete all 3 badges to unlock certificate
    </p>

</div>

<?php } else { ?>

    <?php if(!$cert_unlocked){ ?>

    <div class="certificate-box ready">

        <p>
            🎉 Certificate Ready to Unlock
        </p>

       <button onclick="unlockCertificate()"
class="unlock-btn">

    Unlock Certificate

</button>

    </div>

    <?php } else { ?>

    <div class="certificate-box unlocked">

        <p>
            🏆 Certificate Unlocked
        </p>

        <a href="download_certificate.php"
        class="download-btn">

            View Certificate

        </a>

    </div>

    <?php } ?>

<?php } ?>

</div>

<!-- BACK BUTTON -->

<div style="margin:20px 0;" align="center">

    <a href="user_dashboard.php"
    style="
        display:inline-block;
        padding:10px 18px;
        background:#0f172a;
        color:white;
        text-decoration:none;
        border-radius:10px;
        font-weight:600;
        transition:0.2s;
    ">

        ⬅ Back to Dashboard

    </a>

</div>

</div>

<!-- ================= BATCH POPUP ================= -->

<div id="successPopup" class="success-popup" style="display:none;">

    <div class="popup-box">

        <div class="popup-icon">
            🏆
        </div>

        <h2>
            Congratulations!
        </h2>

        <p>
            Your badge has been unlocked successfully.
            Keep exploring Literacy Hub and earn more achievements!
        </p>

        <button onclick="closePopup()">
            View badge
        </button>

    </div>

</div>

<!-- CERTIFICATE POPUP -->

<div id="certificatePopup"
class="success-popup"
style="display:none;">

    <div class="popup-box">

        <div class="popup-icon">
            🎓
        </div>

        <h2>
            Certificate Unlocked!
        </h2>

        <p>
            Congratulations! You completed all achievements
            and unlocked your Literacy Hub certificate.
        </p>

        <button onclick="closeCertificatePopup()">
            View certificate
        </button>

    </div>

</div>
<input type="hidden"
id="currentBadge">

<!-- ================= JAVASCRIPT ================= -->

<script>

/* ================= BADGE ================= */

function unlockBadge(badge){

    document.getElementById("currentBadge").value = badge;

    fetch("unlock_badge.php?badge=" + encodeURIComponent(badge))
    .then(res => res.json())
    .then(data => {

        /* REQUIREMENT COMPLETED */

        if(data.status == "success"){

            document.getElementById("successPopup")
            .style.display = "flex";

        }

        /* BADGE ALREADY UNLOCKED */

        else if(data.status == "exists"){

            alert(data.message);

        }

        /* REQUIREMENT NOT COMPLETED */

        else{

            alert(data.message);

        }

    });

}

function closePopup(){

    document.getElementById("successPopup")
    .style.display = "none";

    let badge =
    document.getElementById("currentBadge").value;

    window.location.href =
    "download_badge.php?badge=" +
    encodeURIComponent(badge);

}

/* ================= CERTIFICATE ================= */

function unlockCertificate(){

    fetch("unlock_certificate.php")
    .then(res => res.text())
    .then(data => {

        document.getElementById("certificatePopup")
        .style.display = "flex";

    });

}

function closeCertificatePopup(){

    document.getElementById("certificatePopup")
    .style.display = "none";

    window.location.href =
    "download_certificate.php";

}


</script>
</body>
</html>