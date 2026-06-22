<?php
session_start();
include 'db_connect.php';

/* SECURITY CHECK */
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: login.html");
    exit();
}

/* ================= APPROVE ================= */
if(isset($_POST['approve'])){

    $request_id = $_POST['request_id'];

    // FETCH REQUEST ONLY HERE
    $get = mysqli_query($conn,
    "SELECT * FROM writer_requests WHERE request_id='$request_id'");

    $request = mysqli_fetch_assoc($get);

    if(!$request || $request['status'] != 'pending'){
        header("Location: admin_writer_requests.php");
        exit();
    }

    $user_id = $request['user_id'];

    // UPDATE REQUEST
    mysqli_query($conn,
    "UPDATE writer_requests
     SET status='approved'
     WHERE request_id='$request_id'");

    // UPDATE USER ROLE
    mysqli_query($conn,
    "UPDATE users
     SET role='writer',
         writer_request='approved'
     WHERE user_id='$user_id'");

    // NOTIFICATION
    $message = "🎉 Congratulations! Your request has been approved.";

    mysqli_query($conn,
    "INSERT INTO notifications (user_id, message, created_at)
     VALUES ('$user_id','$message',NOW())");

    header("Location: admin_writer_requests.php");
    exit();
}

/* ================= REJECT ================= */
if(isset($_POST['reject'])){

    $request_id = $_POST['request_id'];
    $reason = mysqli_real_escape_string($conn,$_POST['reason']);

    $rating = $_POST['rating'];

    // FETCH REQUEST HERE ALSO
    $get = mysqli_query($conn,
    "SELECT * FROM writer_requests WHERE request_id='$request_id'");

    $request = mysqli_fetch_assoc($get);

    if(!$request || $request['status'] != 'pending'){
        header("Location: admin_writer_requests.php");
        exit();
    }

    $user_id = $request['user_id'];

    // UPDATE REQUEST
   mysqli_query($conn,
"UPDATE writer_requests
 SET status='rejected',
     rejection_reason='$reason',
     rating='$rating'
 WHERE request_id='$request_id'");

    // UPDATE USER
    mysqli_query($conn,
    "UPDATE users
     SET writer_request='rejected'
     WHERE user_id='$user_id'");

    // NOTIFICATION
    $message = "❌ Your writer request was rejected. Reason: $reason";

    mysqli_query($conn,
    "INSERT INTO notifications (user_id, message, created_at)
     VALUES ('$user_id','$message',NOW())");

    header("Location: admin_writer_requests.php");
    exit();
}
?>