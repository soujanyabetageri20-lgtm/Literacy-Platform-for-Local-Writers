<?php
session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: login.html");
    exit();
}

$id = $_GET['id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reject Post</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

<div class="container">

<h2>Enter Rejection Reason</h2>

<form action="reject_post.php" method="POST">

    <input type="hidden" name="id" value="<?php echo $id; ?>">

    <textarea name="reason" placeholder="Enter reason..." required 
    style="width:100%; height:120px;"></textarea><br><br>

    <button type="submit" class="btn reject">Submit</button>

</form>

</div>

</body>
</html>