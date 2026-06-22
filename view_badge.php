<?php
session_start();

if(!isset($_GET['badge'])){
    echo "Badge not found";
    exit();
}

$badge = $_GET['badge'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Badge</title>

    <link rel="stylesheet" href="view_badge.css">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

</head>

<body>

<div class="card">

    <div class="icon">🏆</div>

    <h2><?php echo htmlspecialchars($badge); ?></h2>

    <p>You have successfully unlocked this badge.</p>

    <a class="btn"
       href="download_badge.php?badge=<?php echo urlencode($badge); ?>">
        Download Badge
    </a>

    <a class="back" href="achievements.php">
        ← Back to Achievements
    </a>

</div>

</body>
</html>