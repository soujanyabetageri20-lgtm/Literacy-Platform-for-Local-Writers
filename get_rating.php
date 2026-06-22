<?php
include 'db_connect.php';

$post_id = $_GET['post_id'];

$result = mysqli_query($conn,
"SELECT AVG(rating) as avg_rating FROM ratings WHERE post_id='$post_id'");

$row = mysqli_fetch_assoc($result);

if($row['avg_rating']){
    echo "⭐ Average Rating: " . round($row['avg_rating'],1) . " / 5";
} else {
    echo "⭐ No ratings yet";
}
?>