<?php
session_start();
include 'db_connect.php';


if (!isset($_SESSION['user_id'])) {
    echo "Please login first";
    exit();
}
$user_id = $_SESSION['user_id'];


/* ================= COUNTS ================= */
$liked_count = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as cnt FROM post_reactions WHERE user_id='$user_id'"))['cnt'];

$rated_count = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as cnt FROM ratings WHERE user_id='$user_id'"))['cnt'];

$commented_count = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(DISTINCT post_id) as cnt FROM comments WHERE user_id='$user_id'"))['cnt'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Activities</title>
    <link rel="stylesheet" href="my_activities.css">
</head>

<body>

<div class="container">

    <h2>My Activities</h2>

    <!-- ================= TABS ================= -->
    <div class="tabs">
        <button class="card" onclick="showTab('liked', event)">
            👍 Liked (<?php echo $liked_count; ?>)
        </button>

        <button class="card" onclick="showTab('rated', event)">
            ⭐ Rated (<?php echo $rated_count; ?>)
        </button>

        <button class="card" onclick="showTab('commented', event)">
            💬 Commented (<?php echo $commented_count; ?>)
        </button>
    </div>

    <!-- ================= LIKED ================= -->
    <div id="liked" class="tab-content" style="display:block;">

        <?php
        $sql = "SELECT p.post_id, p.title, l.id
                FROM posts p
                JOIN post_reactions l ON p.post_id = l.post_id
                WHERE l.user_id = '$user_id'
                ORDER BY l.id DESC";

        $result = mysqli_query($conn, $sql);

        while($row = mysqli_fetch_assoc($result)){
        ?>
        <a href="view_post_user.php?id=<?php echo $row['post_id']; ?>">
            <div class="activity-card">
                <h3><?php echo $row['title']; ?></h3>
                <p>👍 You liked this post</p>
            </div>
        </a>
        <?php } ?>

    </div>

    <!-- ================= RATED ================= -->
    <div id="rated" class="tab-content">

        <?php
        $sql = "SELECT p.post_id, p.title, r.rating, r.rating_id
                FROM posts p
                JOIN ratings r ON p.post_id = r.post_id
                WHERE r.user_id = '$user_id'
                ORDER BY r.rating_id DESC";

        $result = mysqli_query($conn, $sql);

        while($row = mysqli_fetch_assoc($result)){
        ?>
        <a href="view_post_user.php?id=<?php echo $row['post_id']; ?>">
            <div class="activity-card">
                <h3><?php echo $row['title']; ?></h3>
                <p>⭐ Your Rating: <?php echo $row['rating']; ?></p>
            </div>
        </a>
        <?php } ?>

    </div>

    <!-- ================= COMMENTED ================= -->
    <div id="commented" class="tab-content">

        <?php
        $sql = "SELECT c.comment_text, c.created_at, p.post_id, p.title
                FROM comments c
                JOIN posts p ON p.post_id = c.post_id
                WHERE c.user_id = '$user_id'
                ORDER BY c.created_at DESC";

        $result = mysqli_query($conn, $sql);

        while($row = mysqli_fetch_assoc($result)){
        ?>
        <a href="view_post_user.php?id=<?php echo $row['post_id']; ?>">
            <div class="activity-card">
                <h3><?php echo $row['title']; ?></h3>
                <p>💬 "<?php echo substr($row['comment_text'], 0, 60); ?>..."</p>
                <p>🕒 <?php echo $row['created_at']; ?></p>
            </div>
        </a>
        <?php } ?>

    </div>

</div>

<a href="user_dashboard.php" class="back-btn">⬅ Back</a>

<!-- ================= JS ================= -->
<script>
function showTab(tabId, event) {

    document.querySelectorAll('.tab-content').forEach(el => {
        el.style.display = "none";
    });

    document.querySelectorAll('.card').forEach(btn => {
        btn.classList.remove("active");
    });

    document.getElementById(tabId).style.display = "block";

    event.target.classList.add("active");
}
</script>

</body>
</html>