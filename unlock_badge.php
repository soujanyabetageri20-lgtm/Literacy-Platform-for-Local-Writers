<?php
session_start();
include 'db_connect.php';

header('Content-Type: application/json');

if(!isset($_SESSION['user_id'])){
    echo json_encode(["status"=>"error","message"=>"Login required"]);
    exit();
}

$user_id = $_SESSION['user_id'];

/* ================= BADGE INPUT ================= */

if(!isset($_GET['badge'])){
    echo json_encode(["status"=>"error","message"=>"Badge not provided"]);
    exit();
}

$badge = trim($_GET['badge']);

/* ================= GET USER STATS ================= */

$likes = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM post_reactions 
 WHERE user_id='$user_id' AND reaction='like'"))['total'];

$comments = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM comments 
 WHERE user_id='$user_id'"))['total'];

$ratings = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM ratings 
 WHERE user_id='$user_id'"))['total'];

$posts = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM posts 
 WHERE author_id='$user_id'"))['total'];

/* ================= CONDITION CHECK ================= */

$allowed = false;
$message = "";

/* USER BADGES */
if($badge == "Book Explorer"){
    if($likes >= 1){
        $allowed = true;
    } else {
        $message = "Need at least 1 like";
    }
}

else if($badge == "Community Voice"){
    if($comments >= 1){
        $allowed = true;
    } else {
        $message = "Need at least 1 comment";
    }
}

else if($badge == "Top Supporter"){
    if($ratings >= 1){
        $allowed = true;
    } else {
        $message = "Need at least 1 rating";
    }
}

/* WRITER BADGES */
else if($badge == "Published Author"){
    if($posts >= 1){
        $allowed = true;
    } else {
        $message = "Need at least 1 post";
    }
}

else if($badge == "Trending Writer"){
    if($likes >= 1){
        $allowed = true;
    } else {
        $message = "Need at least 1 like on posts";
    }
}

else if($badge == "Reader Favorite"){
    if($ratings >= 1){
        $allowed = true;
    } else {
        $message = "Need at least 1 rating on posts";
    }
}

else {
    echo json_encode(["status"=>"error","message"=>"Invalid badge"]);
    exit();
}

/* ================= IF CONDITION NOT MET ================= */

if(!$allowed){
    echo json_encode([
        "status"=>"error",
        "message"=>$message
    ]);
    exit();
}

/* ================= CHECK IF ALREADY UNLOCKED ================= */

$check = mysqli_query($conn,
"SELECT 1 FROM achievements 
 WHERE user_id='$user_id' 
 AND badge_name='$badge'
 LIMIT 1");

if(mysqli_num_rows($check) > 0){
    echo json_encode([
        "status"=>"exists",
        "message"=>"Badge already unlocked"
    ]);
    exit();
}

/* ================= INSERT BADGE ================= */

$insert = mysqli_query($conn,
"INSERT INTO achievements 
(user_id, badge_name, badge_type, unlocked_at)
VALUES
('$user_id','$badge','badge',NOW())");

if($insert){
    echo json_encode([
        "status"=>"success",
        "message"=>"Badge unlocked successfully"
    ]);
} else {
    echo json_encode([
        "status"=>"error",
        "message"=>"Database error"
    ]);
}
?>