<?php
session_start();

if(!isset($_SESSION['user_id'])){
	header("Location: login.html");
	exit();
}
?>

<h2>Welcome <?php echo $_SESSION['username'];?></h2>
<p>You have successfully loged in.</p>