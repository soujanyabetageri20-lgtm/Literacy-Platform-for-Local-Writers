<?php
session_start();

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

include 'db_connect.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: login.html");
    exit();
}

$sql = "SELECT posts.*, categories.category_name 
        FROM posts 
        LEFT JOIN categories 
        ON posts.category_id = categories.category_id
        ORDER BY posts.created_at DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="admin.css">
</head>

<body>
    <?php //include 'navbar.php';?>

<div class="container">

<h2>Post Approval List</h2>

<table>
<tr>
    <th>Title</th>
    <th>Category</th>
    <th>Status</th>
    <th>Actions</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>
<tr>
    <td><?php echo $row['title']; ?></td>
    <td><?php echo $row['category_name']; ?></td>

    <td>
<?php
if($row['status'] == 'pending'){
    echo "<span class='status-pending'>Pending</span>";
}
elseif($row['status'] == 'approved'){
    echo "<span class='status-approved'>Approved</span>";
}
else{
    echo "<span class='status-rejected'>Rejected</span>";
}

// 5SHOW5 REASON ALWAYS if it exists
if(!empty($row['rejection_reason']) && $row['status']!='approved'){
    echo "<br><small style='color:red;'>Reason: ".$row['rejection_reason']."</small>";
}
else{
    echo "";
}
?>
</td>

    <td>
        <a href="view_post_admin.php?id=<?php echo $row['post_id']; ?>" class="btn view">View</a>

        <?php if($row['status']=='pending'){ ?>
            <a href="approve_post.php?id=<?php echo $row['post_id']; ?>" class="btn approve">Approve</a>
            <a href="reject_form.php?id=<?php echo $row['post_id']; ?>" class="btn reject">Reject</a>
        <?php } else { ?>
            <span class="done">Done</span>
        <?php } ?>
    </td>
</tr>
<?php } ?>

</table>

<a href="user_dashboard.php" class="logout">Back</a>

</div>

</body>
</html>