<?php
include 'db_connect.php';

$id = $_GET['id'];

$sql = "SELECT * FROM posts WHERE post_id='$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Post</title>
<link rel="stylesheet" href="edit_post.css">
</head>
<div class="form-container">
<body>

<h2>Edit Post</h2>

<form action="update_post.php" method="POST">

<input type="hidden" name="post_id" value="<?php echo $row['post_id']; ?>">

<label>Title</label>
<input type="text" name="title" value="<?php echo $row['title']; ?>"><br><br>

<label>Content</label>
<textarea name="content" ros="6"><?php echo $row['content']; ?></textarea><br><br>

<button type="submit">Update</button>

</form>
<br><br>
</body>
</div>
</html>