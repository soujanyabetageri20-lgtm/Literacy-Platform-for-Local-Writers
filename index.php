<?php
session_start();
include 'db_connect.php';

/* USER INFO */
$user = null;

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];

    $user_query = mysqli_query($conn,
    "SELECT username, profile_image FROM users WHERE user_id='$user_id'");

    $user = mysqli_fetch_assoc($user_query);
}

/* FILTER */
$search = isset($_GET['search']) ? $_GET['search'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';

$sql = "SELECT posts.*, categories.category_name, users.username,
       AVG(ratings.rating) as avg_rating
FROM posts
LEFT JOIN categories ON posts.category_id = categories.category_id
LEFT JOIN users ON posts.author_id = users.user_id
LEFT JOIN ratings ON posts.post_id = ratings.post_id
WHERE posts.status='approved'";

if(!empty($search)){
    $sql .= " AND (posts.title LIKE '%$search%' OR posts.content LIKE '%$search%')";
}

if(!empty($category)){
    $sql .= " AND posts.category_id='$category'";
}

$sql .= " GROUP BY posts.post_id ORDER BY posts.created_at DESC";

$result = mysqli_query($conn, $sql);
$cat_result = mysqli_query($conn, "SELECT * FROM categories");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Literacy Hub</title>
    <link rel="stylesheet" href="index.css">
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
    <h2>📚 Literacy Hub</h2>

    <div>
        <a href="index.php">Home</a>
        <a href="landing_page.php">About</a>

        <?php if(isset($_SESSION['user_id'])){ ?>

            <a href="user_dashboard.php">Dashboard</a>

            <?php if($_SESSION['role'] == 'admin'){ ?>
                <a href="admin_dashboard.php">Admin</a>
            <?php } ?>

            <a href="profile.php" class="profile-link">

                <?php if(!empty($user['profile_image'])) { ?>
                    <img src="uploads/<?php echo $user['profile_image']; ?>" class="nav-profile-img">
                <?php } else { ?>
                    <img src="uploads/default.png" class="nav-profile-img">
                <?php } ?>

                <?php echo $user['username']; ?>
            </a>

            <a href="#" onclick="confirmLogout()">Logout</a>

        <?php } else { ?>
            <a href="login.html">Login</a>
        <?php } ?>
    </div>
</div>

<!-- HERO -->
<div class="hero">
    <h1>Discover Stories That Inspire</h1>
    <p>Read • Write • Rate • Connect</p>
</div>

<!-- SEARCH -->
<div class="search-bar">
<form method="GET">
    <input type="text" name="search" placeholder="Search stories..." value="<?php echo $search; ?>">

    <select name="category">
        <option value="">All Categories</option>
        <?php while($cat = mysqli_fetch_assoc($cat_result)){ ?>
            <option value="<?php echo $cat['category_id']; ?>"
            <?php if($category == $cat['category_id']) echo "selected"; ?>>
                <?php echo $cat['category_name']; ?>
            </option>
        <?php } ?>
    </select>

    <button type="submit">Search</button>
</form>
</div>

<!-- SECTION HEADER (FIXED POSITION) -->
<div class="section-heading">
    <h2>Explore Latest Posts</h2>
    <p>Browse and enjoy stories from the Literacy Hub community</p>
</div>

<!-- POSTS -->
<div class="posts-container">

<?php if(mysqli_num_rows($result) > 0){ ?>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<?php
$likes = mysqli_query($conn,
"SELECT COUNT(*) as total FROM post_reactions 
WHERE post_id='".$row['post_id']."' AND reaction='like'");
$like_count = mysqli_fetch_assoc($likes)['total'];

$dislikes = mysqli_query($conn,
"SELECT COUNT(*) as total FROM post_reactions 
WHERE post_id='".$row['post_id']."' AND reaction='dislike'");
$dislike_count = mysqli_fetch_assoc($dislikes)['total'];
?>

<div class="post-card">

    <a href="view_post_user.php?id=<?php echo $row['post_id']; ?>">

        <?php if(!empty($row['image'])){ ?>
            <img src="uploads/<?php echo $row['image']; ?>">
        <?php } else { ?>
            <img src="default.jpg">
        <?php } ?>

    </a>

    <div class="post-content">

        <div class="category">
            <?php echo $row['category_name']; ?>
        </div>

        <h3><?php echo $row['title']; ?></h3>

        <p>By <?php echo $row['username']; ?></p>

        <p class="rating">
            ⭐ <?php echo $row['avg_rating'] ? round($row['avg_rating'],1) : "0"; ?>
        </p>

        <div style="display:flex; gap:15px;">

             <span id="like-<?php echo $row['post_id']; ?>" 
          onclick="react(<?php echo $row['post_id']; ?>,'like')"
          class="like-btn">
        👍 <?php echo $like_count; ?>
    </span>

    <span id="dislike-<?php echo $row['post_id']; ?>" 
          onclick="react(<?php echo $row['post_id']; ?>,'dislike')"
          class="dislike-btn">
        👎 <?php echo $dislike_count; ?>
    </span>

        </div>

    </div>

</div>

<?php } ?>

<?php } else { ?>

<p class="no-posts">No posts found</p>

<?php } ?>

</div>

<script>

function react(postId, type){

    var xhr = new XMLHttpRequest();

    xhr.open("POST", "like_post.php", true);

    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onload = function(){

        let res = JSON.parse(this.responseText);

        document.getElementById("like-" + postId).innerHTML =
            "👍 " + res.likes;

        document.getElementById("dislike-" + postId).innerHTML =
            "👎 " + res.dislikes;
    };

    xhr.send("post_id=" + postId + "&type=" + type);
}

</script>
<script>

function confirmLogout(){

    if(confirm("Are you sure you want to logout?")){

        window.location.href = "logout.php";

    }

}

</script>

</body>
</html>

</body>
</html>