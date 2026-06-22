<?php
session_start();

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

include 'db_connect.php';

$isLoggedIn = isset($_SESSION['user_id']);

if(isset($_GET['id'])){
    $post_id = $_GET['id'];
} else {
    echo "Post not found";
    exit();
}

/* FETCH POST */
$sql = "SELECT posts.*, users.username, categories.category_name
        FROM posts
        LEFT JOIN users ON posts.author_id = users.user_id
        LEFT JOIN categories ON posts.category_id = categories.category_id
        WHERE posts.post_id = '$post_id'";

$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) == 0){
    echo "Post not found";
    exit();
}

$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>

    <title><?php echo $row['title']; ?></title>

    <link rel="stylesheet" href="view_post_user.css?v=2">

    <style> 
    .post-title{ 
        text-align:center;
     } 
 .post-meta{ 
 text-align:center;
  margin-bottom:20px; 
color:#555; 
font-size:15px;
 } 
.image-wrapper{ 
text-align:center; 
margin-bottom:25px;
 } 
.post-image
{ max-width:100%; 
width:500px; 
border-radius:18px; 
object-fit:cover;
 box-shadow:0 4px 12px rgba(0,0,0,0.15);
  } 
.comment-section{ 
margin-top:40px; 
} 
.login-lock-box{ 
margin-top:30px; 
} 
</style>

</head>

<body>

<div class="post-container">

    <!-- TITLE -->
    <h2 class="post-title">
        <?php echo $row['title']; ?>
    </h2>

    <!-- META -->
    <div class="post-meta">
        ✍️ By <b><?php echo $row['username']; ?></b>
        | 📚 <?php echo $row['category_name']; ?>
    </div>

    <!-- IMAGE -->
    <div class="image-wrapper">

    <?php if(!empty($row['image']) && file_exists("uploads/".$row['image'])){ ?>
        <img src="uploads/<?php echo $row['image']; ?>" class="post-image">
    <?php } else { ?>
        <img src="default.jpg" class="post-image">
    <?php } ?>

    </div>

    <!-- CONTENT -->
    <div class="post-content">

    <?php
    $content = $row['content'];

    if($isLoggedIn){
        echo nl2br($content);
    } else {
        $lines = explode("\n", $content);
        $short = implode("\n", array_slice($lines, 0, 3));
        echo nl2br($short) . "...";
    }
    ?>

    </div>

    <!-- LOGIN BOX -->
    <?php if(!$isLoggedIn){ ?>
    <div class="login-lock-box">
        <p>🔒 Login to unlock full story, rating & comments interaction</p>
        <a href="login.html" class="login-btn">Login to Continue</a>
    </div>
    <?php } ?>

    <!-- ⭐ RATING -->
    <div class="rating-box">

    <?php if($isLoggedIn){ ?>
        <label><b>Rate this story:</b></label>
        <br><br>

        <div class="stars" id="star-container">
            <span onclick="rate(1)">★</span>
            <span onclick="rate(2)">★</span>
            <span onclick="rate(3)">★</span>
            <span onclick="rate(4)">★</span>
            <span onclick="rate(5)">★</span>
        </div>
    <?php } ?>

    <p id="avg-rating"></p>

    </div>

    <!-- COMMENTS -->
    <div class="comment-section">

        <h3>💬 Comments</h3>

        <?php if($isLoggedIn){ ?>
            <textarea id="comment-input" placeholder="Write a comment..."></textarea>
            <br>
            <button onclick="addComment(<?php echo $row['post_id']; ?>)">
                Post
            </button>
        <?php } ?>

        <!-- ALWAYS VISIBLE COMMENTS -->
        <div id="comments-box"></div>

    </div>

</div>

<a href="index.php" class="back-btn">← Back to Home</a>

<script>

/* ================= RATING ================= */
function rate(value){

    const postId = <?php echo $row['post_id']; ?>;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "rate_post.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onload = function(){
        loadAverage();
    };

    xhr.send("post_id=" + postId + "&rating=" + value);
}

/* ================= LOAD AVERAGE ================= */
function loadAverage(){

    var xhr = new XMLHttpRequest();
    xhr.open("GET", "get_rating.php?post_id=<?php echo $row['post_id']; ?>", true);

    xhr.onload = function(){
        document.getElementById("avg-rating").innerHTML = this.responseText;
    };

    xhr.send();
}

/* ================= LOAD COMMENTS ================= */
function loadComments(postId){

    var xhr = new XMLHttpRequest();
    xhr.open("GET", "fetch_comments.php?post_id=" + postId, true);

    xhr.onload = function(){
        document.getElementById("comments-box").innerHTML = this.responseText;
    };

    xhr.send();
}

/* ================= ADD COMMENT ================= */
function addComment(postId){

    var text = document.getElementById("comment-input").value;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "add_comment.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onload = function(){
        document.getElementById("comment-input").value = "";
        loadComments(postId);
    };

    xhr.send("post_id=" + postId + "&comment=" + text);
}

/* ================= DELETE COMMENT (FIXED) ================= */
function deleteComment(id){

    let confirmDelete = confirm("Are you sure you want to delete this comment?");

    if(!confirmDelete){
        return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "delete_comment.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onload = function(){
        loadComments(<?php echo $row['post_id']; ?>);
    };

    xhr.send("comment_id=" + encodeURIComponent(id));
}

/* EDIT COMMENT */ 
function editComment(id){ 
    var newText = prompt( "Edit your comment:" );
     if(newText == null) return; 
     var xhr = new XMLHttpRequest(); 
     xhr.open( "POST", "edit_comment.php", true ); 
     xhr.setRequestHeader( "Content-type", "application/x-www-form-urlencoded" ); 
     xhr.onload = function(){ 
        loadComments( <?php echo $row['post_id'];
         ?> ); 
    };
     xhr.send( "comment_id=" + id + "&text=" + newText ); 
 }

/* ================= INITIAL LOAD ================= */
loadComments(<?php echo $row['post_id']; ?>);
loadAverage();

</script>

</body>
</html>