<?php
session_start();
include 'db_connect.php';

/* ================= EMAIL AJAX CHECK ================= */
if(isset($_POST['ajax']) && $_POST['ajax'] == "email_check"){

    $email = trim($_POST['email']);

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        echo "invalid";
        exit();
    }

    $sql = "SELECT user_id FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    echo (mysqli_stmt_num_rows($stmt) > 0) ? "exists" : "available";
    exit();
}

/* ================= REGISTER SUBMIT ================= */
if($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['ajax'])){

    header('Content-Type: application/json');

    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $mobile = $_POST['mobile_no'];
    $gender = $_POST['gender'];

    /* ================= VALIDATION ================= */

    if(empty($fullname) || empty($email) || empty($password) || empty($confirm_password) || empty($mobile) || empty($gender)){
        echo json_encode(["status"=>"error","message"=>"All fields are required"]);
        exit();
    }

    if(!preg_match("/^[A-Za-z ]+$/", $fullname)){
        echo json_encode(["status"=>"error","message"=>"Only letters and spaces allowed"]);
        exit();
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL) || !str_ends_with($email, "@gmail.com")){
        echo json_encode(["status"=>"error","message"=>"Enter valid Gmail ID"]);
        exit();
    }

    if($password !== $confirm_password){
        echo json_encode(["status"=>"error","message"=>"Passwords do not match"]);
        exit();
    }

    if(!preg_match("/^[6789][0-9]{9}$/", $mobile)){
        echo json_encode(["status"=>"error","message"=>"Invalid mobile number"]);
        exit();
    }

    if(!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,20}$/", $password)){
        echo json_encode(["status"=>"error","message"=>"Weak password"]);
        exit();
    }

    /* ================= INSERT ================= */
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users(username,email,password,mobile,gender,role,status)
            VALUES(?,?,?,?,?,?,?)";

    $stmt = mysqli_prepare($conn, $sql);

    $role = "user";
    $status = "active";

    mysqli_stmt_bind_param($stmt, "sssssss",
        $fullname,
        $email,
        $hashed_password,
        $mobile,
        $gender,
        $role,
        $status
    );

    if(mysqli_stmt_execute($stmt)){
        echo json_encode(["status"=>"success","message"=>"Registration successful"]);
    } else {
        echo json_encode(["status"=>"error","message"=>"Database error"]);
    }

    exit();
}
?>