<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}

include 'db_connect.php';

$user = null;

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];

    $result = mysqli_query($conn, "SELECT username, profile_image FROM users WHERE user_id='$user_id'");
    $user = mysqli_fetch_assoc($result);
}
?>

<div class="navbar">  
    <h2 class="logo">📚 Literacy Hub</h2>  <div class="nav-links">  
    <a href="index.php">Home</a>  

    <?php if(isset($_SESSION['user_id'])){ ?>  

        <a href="user_dashboard.php">Dashboard</a>  

        <a href="profile.php" class="profile-link">

    <?php if(!empty($user['profile_image'])) { ?>
        <img src="uploads/<?php echo $user['profile_image']; ?>" class="nav-profile-img">
    <?php } else { ?>
        <img src="uploads/default.png" class="nav-profile-img">
    <?php } ?>

    <?php echo $user['username']; ?>
</a>


        <a href="logout.php">Logout</a>  

    <?php } else { ?>  

        <a href="login.html">Login</a>  

    <?php } ?>  
</div>

</div>  