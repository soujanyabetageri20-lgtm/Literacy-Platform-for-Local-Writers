<?php
session_start();
include 'db_connect.php';

$post_id = $_GET['post_id'];

$sql = "SELECT comments.*, users.username 
        FROM comments 
        JOIN users ON comments.user_id = users.user_id 
        WHERE post_id='$post_id'
        ORDER BY created_at DESC";

$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result)){
?>

<div class="comment-box">

    <div class="comment-user">
        <?php echo $row['username']; ?>
    </div>

    <div class="comment-text">
        <?php echo $row['comment_text']; ?>
    </div>

    <div class="comment-time">
        <?php echo $row['created_at']; ?>
    </div>

    <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $row['user_id']){ ?>

        <button onclick="editComment(<?php echo $row['comment_id']; ?>)">Edit</button>

        <button onclick="deleteComment(<?php echo $row['comment_id']; ?>)">Delete</button>

    <?php } ?>

</div>

<?php } ?>