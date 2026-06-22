<?php
session_start();
include 'db_connect.php';

header('Content-Type: application/json');

/* ================= LOGIN CHECK ================= */

if(!isset($_SESSION['user_id'])){
    echo json_encode([
        "status" => "error",
        "message" => "Login required"
    ]);
    exit();
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

/* ================= ROLE BASED REQUIREMENTS ================= */

if($role == 'user'){
    $required = ["Book Explorer","Community Voice","Top Supporter"];
}
else if($role == 'writer'){
    $required = ["Published Author","Trending Writer","Reader Favorite"];
}
else{
    echo json_encode([
        "status" => "error",
        "message" => "Invalid role"
    ]);
    exit();
}

/* ================= CHECK BADGES COMPLETED ================= */

foreach($required as $badge){

    $q = mysqli_query($conn,
    "SELECT 1 FROM achievements 
     WHERE user_id='$user_id' 
     AND badge_name='$badge'
     LIMIT 1");

    if(mysqli_num_rows($q) == 0){

        echo json_encode([
            "status" => "error",
            "message" => "Complete all badges first"
        ]);
        exit();
    }
}

/* ================= CHECK IF CERTIFICATE EXISTS ================= */

$cert_check = mysqli_query($conn,
"SELECT 1 FROM achievements 
 WHERE user_id='$user_id' 
 AND badge_name='Certificate'
 LIMIT 1");

if(mysqli_num_rows($cert_check) > 0){

    echo json_encode([
        "status" => "exists",
        "message" => "Certificate already unlocked"
    ]);
    exit();
}

/* ================= INSERT CERTIFICATE ================= */

$insert = mysqli_query($conn,
"INSERT INTO achievements 
(user_id, badge_name, badge_type, unlocked_at)
VALUES
('$user_id','Certificate','certificate',NOW())");

if($insert){

    echo json_encode([
        "status" => "success",
        "message" => "Certificate unlocked successfully"
    ]);

} else {

    echo json_encode([
        "status" => "error",
        "message" => "Database error"
    ]);

}
?>