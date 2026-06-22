<?php
session_start();

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'writer'){
		header("Location: login.html");
		exit();
}
?>

<?php
include 'db_connect.php';
$result=mysqli_query($conn,"SELECT * FROM categories");
?>


<!DOCTYPE html>
<html>
<head>
	<title>Create post</title>
	<link rel="stylesheet" href="writer_dashboard.css">
</head>
<body>

	<?php //include 'navbar.php'; ?>

<div class="form-container">
	<h2>Create Post</h2>
<form action="save_posts.php" method="POST" enctype="multipart/form-data">
	<label for="tite">Title</label><br>
	<input type="text" name="title" id="title" required><br><br>
	<label for="content">Content</label><br>
	<textarea name="content" id="content" rows="6" required></textarea><br><br>
	<label for="category">Category</label>
	<select id="category" name="category_id" required>
	<option value="">Select Category</option>

	<?php
	while($row=mysqli_fetch_assoc($result)){
	?>
	<option value="<?php echo $row["category_id"];?>">
		<?php echo $row["category_name"];?></option>
	<?php
	}
	?>
</select>

	<label for="image">Upload Image</label><br>
	<input type="file" name="image" id="image"><br><br>
	<button type="submit">Publish Post</button>
	<br><br>
	<a href="user_dashboard.php" class="back-btn">Back</a>
</form>
</div>
</body>
</html>