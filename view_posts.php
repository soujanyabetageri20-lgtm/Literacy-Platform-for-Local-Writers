<?php
include 'db_connect.php';

$id = $_GET['id'];

$sql = "SELECT posts.*, categories.category_name 
        FROM posts 
        LEFT JOIN categories 
        ON posts.category_id = categories.category_id
        WHERE post_id = '$id'";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
<title>View Post</title>
<link rel="stylesheet" href="dashboard.css">
</head>

<body>

<div class="dashboard-container">

<h2><?php echo $row['title']; ?></h2>

<p><strong>Category:</strong> <?php echo $row['category_name']; ?></p>

<?php if($row['image']){ ?>
<img src="uploads/<?php echo $row['image']; ?>" width="300">
<?php } ?>


<p><?php echo $row['content']; ?></p>



<br><br>
<a href="my_posts1.php" class="card">Back</a>

</div>

</body>
</html>