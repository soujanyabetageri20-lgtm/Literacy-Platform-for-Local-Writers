<?php
session_start();
include 'db_connect.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(!isset($_SESSION['user_id'])){
        echo "User not logged in";
        exit();
    }

    // Writer id
    $author_id = $_SESSION['user_id'];

    // Form data
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category_id=$_POST['category_id'];

    // Image details
    $image_name = $_FILES['image']['name'];
    $temp_name = $_FILES['image']['tmp_name'];

    $allowed_types = ['jpg','jpeg','png','gif'];

    // If image uploaded
    if(!empty($image_name)){

        $file_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

        if(!in_array($file_extension, $allowed_types)){
            echo "<script>
            alert('Only JPG, JPEG, PNG and GIF images are allowed');
            window.location.href='create_post.php';
            </script>";
            exit();
        }

        $upload_path = "uploads/" . $image_name;

        if(move_uploaded_file($temp_name, $upload_path)){
            $image_value = $image_name;
        }else{
            echo "Image upload failed";
            exit();
        }

    }else{
        // No image uploaded
        $image_value = NULL;
    }

    // Insert into database
    $sql = "INSERT INTO posts (author_id, title, content, image, category_id, status) 
            VALUES ('$author_id', '$title', '$content', '$image_value', '$category_id', 'pending')";

    if(mysqli_query($conn, $sql)){
        echo "<script>
        alert('Post submitted successfully. Waiting for admin approval.');
        window.location.href='user_dashboard.php';
        </script>";
    }
    else{
        echo "Error: " . mysqli_error($conn);
    }

}else{
    echo "Invalid request";
}
?>