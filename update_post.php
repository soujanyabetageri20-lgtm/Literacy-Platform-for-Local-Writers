<?php
session_start();
include 'db_connect.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Get form data
    $id = $_POST['post_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Image handling (safe)
    $image_name = isset($_FILES['image']['name']) ? $_FILES['image']['name'] : '';
    $temp_name = isset($_FILES['image']['tmp_name']) ? $_FILES['image']['tmp_name'] : '';

    $allowed_types = ['jpg','jpeg','png','gif'];

    // If new image uploaded
    if(!empty($image_name)){

        $file_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

        if(!in_array($file_extension, $allowed_types)){
            echo "<script>
            alert('Only JPG, JPEG, PNG, GIF allowed');
            window.location.href='edit_post.php?id=$id';
            </script>";
            exit();
        }

        $upload_path = "uploads/" . $image_name;

        if(move_uploaded_file($temp_name, $upload_path)){
            $image_sql = ", image='$image_name'";
        } else {
            echo "Image upload failed";
            exit();
        }

    } else {
        $image_sql = "";
    }

    //  FINAL LOGIC:
    // Every edit → goes for approval
    // DO NOT remove rejection_reason

    $sql = "UPDATE posts 
            SET title='$title',
                content='$content',
                status='pending'
                $image_sql
            WHERE post_id='$id'";

    if(mysqli_query($conn, $sql)){
        echo "<script>
        alert('Post updated and sent for approval');
        window.location.href='my_posts1.php';
        </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

} else {
    echo "Invalid request";
}
?>