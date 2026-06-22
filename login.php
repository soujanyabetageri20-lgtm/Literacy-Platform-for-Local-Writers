<?php
session_start();
include 'db_connect.php';

header('Content-Type: application/json');

/* ================= CAPTCHA SET ================= */
if(isset($_GET['set_captcha'])){
    $_SESSION['captcha'] = $_GET['set_captcha'];
    echo json_encode(["status"=>"ok"]);
    exit();
}

/* ================= LOGIN ================= */
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $email = strtolower(trim($_POST['email']));
    $password = $_POST['password'];
    $captcha_input = $_POST['captcha_input'];

    $errors = [];

    /* EMPTY CHECK */
    if(empty($email)) $errors[] = "Email is required";
    if(empty($password)) $errors[] = "Password is required";
    if(empty($captcha_input)) $errors[] = "Captcha is required";

    /* CAPTCHA CHECK */
    if(!isset($_SESSION['captcha']) || strtolower($captcha_input) !== strtolower($_SESSION['captcha'])){
        $errors[] = "Invalid captcha";
    }

    unset($_SESSION['captcha']);

    /* DATABASE CHECK */
    $stmt = $conn->prepare("SELECT user_id, username, password, role FROM users WHERE LOWER(email)=LOWER(?) LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows == 0){
        $errors[] = "Email not registered";
    } else {

        $user = $result->fetch_assoc();

        if(!password_verify($password, $user['password'])){
            $errors[] = "Incorrect password";
        }
    }

    /* IF ERRORS EXIST */
    if(count($errors) > 0){
        echo json_encode([
            "status" => "error",
            "message" => $errors
        ]);
        exit();
    }

    /* SUCCESS LOGIN */
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];

    echo json_encode([
        "status" => "success",
        "redirect" => "user_dashboard.php"
    ]);
}
?>