<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

include 'db_connect.php';

/* LOGIN CHECK */
if(!isset($_SESSION['user_id'])){
    header("Location: login.html");
    exit();
}

$author_id = $_SESSION['user_id'];

/* FETCH POSTS */
$sql = "SELECT posts.post_id,
posts.title,
posts.status,
posts.rejection_reason,
posts.created_at,
categories.category_name 
FROM posts 
LEFT JOIN categories 
ON posts.category_id = categories.category_id
WHERE posts.author_id = $author_id
ORDER BY posts.created_at DESC";

$result = mysqli_query($conn, $sql);

/* ERROR CHECK */
if(!$result){
    die("SQL Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Posts</title>
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="my_posts.css">
</head>

<body>
<?php //include 'navbar.php'; ?>

<div class="dashboard-container">

<h2 style="text-align:center;">📚 My Posts</h2>

<?php if(mysqli_num_rows($result) > 0){?>
<table border="1" cellpadding="10" cellspacing="0" style="margin:auto; margin-top:20px;">

<tr>
    <th>Title</th>
    <th>Category</th>
    <th>Status</th>
    <th>Date</th>
    <th>Actions</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)){
 ?>

<tr>
    <td><?php echo htmlspecialchars($row['title']); ?></td>

    <td>
        <?php echo !empty($row['category_name']) ? $row['category_name'] : 'N/A'; ?>
    </td>

    <td>

<?php

if($row['status'] == 'pending'){

    echo "<span style='color:orange; font-weight:bold;'>
    Pending
    </span>";

}
elseif($row['status'] == 'approved'){

    echo "<span style='color:green; font-weight:bold;'>
    Approved
    </span>";

}
else{

    echo "<span style='color:red; font-weight:bold;'>
    Rejected
    </span>";

    if(!empty($row['rejection_reason'])){

        echo "<br><small style='color:#555;'>
        Reason: ".$row['rejection_reason']."
        </small>";

    }

}

?>

</td>

    <td><?php echo $row['created_at']; ?></td>

    <td>
        <a href="view_posts.php?id=<?php echo $row['post_id']; ?>">View</a> |
        <a href="edit_post.php?id=<?php echo $row['post_id']; ?>">Edit</a> |
        <a href="delete_post.php?id=<?php echo $row['post_id']; ?>"
           class="delete-btn"
           onclick="return confirm('⚠️ Are you sure you want to delete this post?');">
           Delete
        </a>
    </td>
</tr>

<?php } ?>

</table>

<?php } else { ?>

<p style="text-align:center; margin-top:20px;">No posts found</p>

<?php } ?>

<br>

<div style="text-align:center; margin-top:20px;">
    <a href="user_dashboard.php" class="card">⬅ Back to Dashboard</a>
</div>

</div>

</body>
</html>