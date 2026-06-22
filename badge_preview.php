<?php
session_start();
include 'db_connect.php';

/* ================= DEBUG MODE ================= */
error_reporting(E_ALL);
ini_set('display_errors', 1);

/* ================= SESSION CHECK ================= */
if(!isset($_SESSION['user_id'])){
    die("❌ Session expired. Please login again.");
}

$user_id = $_SESSION['user_id'];

/* ================= BADGE CHECK ================= */
if(!isset($_GET['badge']) || $_GET['badge'] == ''){
    die("❌ Badge not provided.");
}

$badge = $_GET['badge'];

/* ================= DATABASE CHECK ================= */
$q = mysqli_query($conn,
"SELECT * FROM achievements 
 WHERE user_id='$user_id' 
 AND badge_name='$badge'");

if(!$q){
    die("❌ SQL Error: " . mysqli_error($conn));
}

if(mysqli_num_rows($q) == 0){
    die("❌ Badge not found or not unlocked.");
}

$data = mysqli_fetch_assoc($q);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Badge Preview</title>

    <style>
        body{
            font-family: Poppins, sans-serif;
            background: linear-gradient(135deg,#dbeafe,#f0fdf4);
            display:flex;
            justify-content:center;
            align-items:center;
            height:100vh;
            margin:0;
        }

        .card{
            background:white;
            padding:40px;
            border-radius:25px;
            width:380px;
            text-align:center;
            box-shadow:0 10px 30px rgba(0,0,0,0.15);
            animation:fadeIn 0.5s ease;
        }

        @keyframes fadeIn{
            from{opacity:0; transform:scale(0.8);}
            to{opacity:1; transform:scale(1);}
        }

        .icon{
            font-size:70px;
        }

        h1{
            color:#0f172a;
            margin:10px 0;
        }

        p{
            color:#475569;
        }

        .badge-name{
            font-size:20px;
            font-weight:600;
            color:#16a34a;
            margin:15px 0;
        }

        .btn{
            display:inline-block;
            margin-top:20px;
            padding:12px 20px;
            border:none;
            border-radius:12px;
            cursor:pointer;
            font-weight:600;
            text-decoration:none;
        }

        .download{
            background:#16a34a;
            color:white;
        }

        .back{
            background:#0f172a;
            color:white;
            margin-left:10px;
        }
    </style>

</head>

<body>

<div class="card">

    <div class="icon">🏆</div>

    <h1>Achievement Unlocked</h1>

    <div class="badge-name"><?php echo htmlspecialchars($badge); ?></div>

    <p>Congratulations! You have successfully earned this badge.</p>

    <p>User ID: <?php echo $user_id; ?></p>

    <!-- DOWNLOAD BUTTON -->
    <a class="btn download"
       href="download_badge.php?badge=<?php echo urlencode($badge); ?>">
       Download Badge
    </a>

    <!-- BACK BUTTON -->
    <a class="btn back" href="achievements.php">
        Back
    </a>

</div>

</body>
</html>