<?php
session_start();
include 'db_connect.php';

/* LOGIN CHECK */
if(!isset($_SESSION['user_id'])){
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

/* ================= IMAGE UPLOAD ================= */
if(isset($_POST['submit']) && isset($_FILES['profile_image'])){

    $image = $_FILES['profile_image']['name'];
    $tmp = $_FILES['profile_image']['tmp_name'];

    $ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png'];

    if(in_array($ext, $allowed)){

        if(!empty($image)){
            $new_name = time() . "." . $ext;
            $folder = "uploads/" . $new_name;

            move_uploaded_file($tmp, $folder);

            mysqli_query($conn, "UPDATE users SET profile_image='$new_name' WHERE user_id='$user_id'");
        }

    } else {
        echo "<p style='color:red;text-align:center;'>Only JPG, JPEG, PNG allowed!</p>";
    }
}

/* ================= FETCH USER ================= */
$sql = "SELECT * FROM users WHERE user_id='$user_id'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>

    <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap');

    body {
        margin: 0;
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(to right, #dbeafe, #e0f7fa);
        background-attachment: fixed;
        color: #0d3b66;
    }

    .profile-box {
        width: 400px;
        margin: 70px auto;
        padding: 30px;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 24px;
        box-shadow: 0 12px 35px rgba(0,0,0,0.1);
        text-align: center;
    }

    .profile-box h2 {
        margin-bottom: 20px;
        font-weight: 800;
    }

    .profile-box p {
        margin: 10px 0;
        color: #475569;
        font-size: 15px;
        font-weight: 500;
    }

    .btn {
        display: inline-block;
        margin-top: 15px;
        padding: 10px 20px;
        background: linear-gradient(to right, #60a5fa, #22d3ee);
        color: white;
        text-decoration: none;
        border-radius: 12px;
        font-weight: 700;
        transition: 0.3s;
        box-shadow: 0 4px 15px rgba(96,165,250,0.3);
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(96,165,250,0.4);
    }

    .profile-img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #60a5fa;
        box-shadow: 0 6px 15px rgba(0,0,0,0.15);
        margin-bottom: 15px;
    }
    </style>
</head>

<body>

<div class="profile-box">

    <h2>👤 My Profile</h2>

    <!-- PROFILE IMAGE -->
    <form method="POST" enctype="multipart/form-data">

        <?php if(!empty($user['profile_image'])) { ?>
            <img src="uploads/<?php echo $user['profile_image']; ?>" class="profile-img">
        <?php } else { ?>
            <img src="uploads/default.png" class="profile-img">
        <?php } ?>

        <input type="file" name="profile_image" accept="image/*">
        <button type="submit" name="submit" class="btn">Upload</button>

    </form>

    <!-- USER DETAILS -->
    <p><b>Username:</b> <?php echo $user['username']; ?></p>

    <p><b>Email:</b> <?php echo $user['email']; ?></p>

    <p><b>Mobile No:</b> 
        <?php echo !empty($user['mobile']) ? $user['mobile'] : 'Not Added'; ?>
    </p>

    <p><b>Gender:</b> 
        <?php echo !empty($user['gender']) ? ucfirst($user['gender']) : 'Not Specified'; ?>
    </p>

    <p><b>Role:</b> <?php echo ucfirst($user['role']); ?></p>

    <!-- BUTTONS -->
    <a href="edit_profile.php" class="btn">Edit Profile</a>

    <p>
        <a href="index.php" class="btn">Back</a>
    </p>

</div>

</body>
</html>