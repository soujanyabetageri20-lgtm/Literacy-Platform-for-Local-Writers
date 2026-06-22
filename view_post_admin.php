<?php
session_start();
include 'db_connect.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: login.html");
    exit();
}

$id = $_GET['id'];

$sql = "SELECT posts.*, categories.category_name 
        FROM posts 
        LEFT JOIN categories 
        ON posts.category_id = categories.category_id
        WHERE post_id='$id'";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Post</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap');

/* ===== BODY ===== */
body {
    margin: 0;
    font-family: 'Poppins', sans-serif;

    background: linear-gradient(to right, #dbeafe, #e0f7fa);
    background-attachment: fixed;

    color: #0d3b66;
}

/* ===== CONTAINER ===== */
.container {
    align-items: center;
    width: 80%;
    margin: 40px auto;

    background: rgba(255,255,255,0.95);
    padding: 25px;

    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

/* ===== TITLE ===== */
h2 {
    text-align: center;
    font-size: 28px;
    font-weight: 800;
}

/* ===== CATEGORY TEXT ===== */
p {
    font-size: 15px;
    color: #334155;
    line-height: 1.6;
}

/* ===== IMAGE (FINAL FIX - NO CONFLICTS) ===== */
.post-img {
    width: 100%;
    max-width: 320px;   /* smaller than before */

    height: auto;

    display: block;
    margin: 20px auto;

    border-radius: 16px;
    object-fit: cover;

    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
}

/* ===== CONTENT ===== */
.content {
    text-align: justify;
    margin-top: 20px;

    line-height: 1.8;
    color: #475569;
}

/* ===== BACK BUTTON ===== */
.logout {
    display: inline-block;

    margin-top: 30px;
    padding: 10px 20px;

    background: linear-gradient(to right, #60a5fa, #22d3ee);
    color: white;

    text-decoration: none;
    border-radius: 12px;

    font-weight: 700;
    box-shadow: 0 4px 15px rgba(96,165,250,0.3);

    transition: 0.3s;


}

.logout:hover {
    transform: translate(-2px);
}

.category{
    text-align:center;
    font-size:15px;
    color:#334155;
    margin:10px 0 20px;
    font-weight:500;
}
    </style>

</head>

<body>

<div class="container">

<h2><?php echo $row['title']; ?></h2>

<p class="category"><b>Category:</b> <?php echo $row['category_name']; ?></p>

<?php if(!empty($row['image'])){ ?>
    <img src="uploads/<?php echo $row['image']; ?>" class="post-img">
<?php } ?>

<p class="content"><?php echo $row['content']; ?></p>

<a href="admin_dashboard.php" class="logout">← Back</a>

</div>

</body>
</html>