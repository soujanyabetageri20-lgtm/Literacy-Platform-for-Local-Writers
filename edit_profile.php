<?php
session_start();
include 'db_connect.php';

/* LOGIN CHECK */
if(!isset($_SESSION['user_id'])){
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$error = "";

/* ================= FETCH USER ================= */

$sql = "SELECT * FROM users WHERE user_id='$user_id'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);


/* ================= UPDATE PROFILE ================= */

if(isset($_POST['update'])){

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $mobile = trim($_POST['mobile']);
    $gender = trim($_POST['gender']);

    $old_password = trim($_POST['old_password']);
    $new_password = trim($_POST['new_password']);

    /* PASSWORD REGEX */
    $pattern =
    "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,20}$/";

    /* ================= PASSWORD CHANGE ================= */

    if(!empty($old_password) || !empty($new_password)){

        /* BOTH FIELDS REQUIRED */
        if(empty($old_password) || empty($new_password)){

            $error = "Enter both old and new password";
        }
        else{

            /* CHECK OLD PASSWORD */
            $check = mysqli_query($conn,
            "SELECT password FROM users WHERE user_id='$user_id'");

            $row = mysqli_fetch_assoc($check);

            if(!password_verify($old_password, $row['password'])){

                $error = "Old password does not match";
            }
            else if(!preg_match($pattern, $new_password)){

                $error =
                "Password must be 8–20 chars with uppercase, lowercase, number & special character";
            }
            else{

                /* UPDATE PASSWORD */
                $hashed_password =
                password_hash($new_password, PASSWORD_DEFAULT);

                mysqli_query($conn,
                "UPDATE users
                SET password='$hashed_password'
                WHERE user_id='$user_id'");
            }
        }
    }

    /* ================= UPDATE PROFILE ================= */

    if(empty($error)){

        $update_sql = "UPDATE users SET

        username='$username',
        email='$email',
        mobile='$mobile',
        gender='$gender'

        WHERE user_id='$user_id'";

        mysqli_query($conn, $update_sql);

        header("Location: profile.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Edit Profile</title>

<style>

@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap');

body{
    margin:0;
    font-family:'Poppins',sans-serif;
    background:linear-gradient(to right,#dbeafe,#e0f7fa);
}

/* FORM BOX */

.form-box{
    width:400px;
    margin:70px auto;
    padding:30px;

    background:rgba(255,255,255,0.92);

    border-radius:24px;

    box-shadow:0 12px 35px rgba(0,0,0,0.12);

    text-align:center;
}

/* TITLE */

.form-box h2{
    color:#0d3b66;
    margin-bottom:20px;
}

/* INPUT */

input{
    width:100%;
    padding:13px;
    margin:10px 0;

    border-radius:12px;
    border:1px solid #dbeafe;

    box-sizing:border-box;

    font-size:14px;
    font-family:'Poppins',sans-serif;
}

input:focus{
    outline:none;
    border:1px solid #60a5fa;
    box-shadow:0 0 8px rgba(96,165,250,0.3);
}

/* GENDER */

.gender-box{
    display:flex;
    justify-content:center;
    gap:20px;

    margin:15px 0;
}

.gender-box label{
    display:flex;
    align-items:center;
    gap:5px;

    font-size:14px;
}

/* BUTTON */

button{
    width:100%;
    padding:13px;

    border:none;
    border-radius:14px;

    background:linear-gradient(to right,#4facfe,#00f2fe);

    color:white;

    font-size:15px;
    font-weight:700;

    cursor:pointer;

    margin-top:10px;
}

button:hover{
    transform:translateY(-2px);
}

/* MESSAGE */

small{
    display:block;
    text-align:left;

    margin-top:-5px;
    margin-bottom:10px;

    font-size:12px;
    font-weight:600;
}

/* ERROR BOX */

.error-box{
    color:red;
    font-size:14px;
    font-weight:600;

    margin-bottom:15px;
}

.back-btn{
    background:linear-gradient(to right,#60a5fa,#22d3ee);
}

</style>

</head>

<body>

<div class="form-box">

<h2>Edit Profile</h2>

<?php if(!empty($error)){ ?>

<div class="error-box">
    <?php echo $error; ?>
</div>

<?php } ?>

<form method="POST" id="profileForm">

    <!-- USERNAME -->

    <input type="text"
           name="username"
           value="<?php echo $user['username']; ?>"
           required>

    <!-- EMAIL -->

    <input type="email"
           name="email"
           value="<?php echo $user['email']; ?>"
           required>

    <!-- MOBILE -->

    <input type="text"
           name="mobile"
           value="<?php echo $user['mobile']; ?>"
           required>

    <!-- GENDER -->

    <div class="gender-box">

        <label>
            <input type="radio"
                   name="gender"
                   value="male"

            <?php
            if(isset($user['gender']) &&
            strtolower($user['gender']) == "male")
            echo "checked";
            ?>>

            Male
        </label>

        <label>
            <input type="radio"
                   name="gender"
                   value="female"

            <?php
            if(isset($user['gender']) &&
            strtolower($user['gender']) == "female")
            echo "checked";
            ?>>

            Female
        </label>

        <label>
            <input type="radio"
                   name="gender"
                   value="other"

            <?php
            if(isset($user['gender']) &&
            strtolower($user['gender']) == "other")
            echo "checked";
            ?>>

            Other
        </label>

    </div>

    <!-- OLD PASSWORD -->

    <input type="password"
           name="old_password"
           id="old_password"
           placeholder="Old Password">

    <!-- NEW PASSWORD -->

    <input type="password"
           name="new_password"
           id="new_password"
           placeholder="New Password">

    <small id="pass-msg"></small>

    <!-- UPDATE BUTTON -->

    <button type="submit" name="update">
        Update
    </button>

</form>

<!-- BACK BUTTON -->

<form action="profile.php">

    <button type="submit" class="back-btn">
        ← Back to Profile
    </button>

</form>

</div>

<script>

/* ================= PASSWORD STRENGTH ================= */

const password =
document.getElementById("new_password");

const msg =
document.getElementById("pass-msg");

password.addEventListener("input", function(){

    let val = password.value;

    if(val.length === 0){

        msg.textContent = "";
        return;
    }

    let rulesOk =

        val.length >= 8 &&
        val.length <= 20 &&
        /[a-z]/.test(val) &&
        /[A-Z]/.test(val) &&
        /\d/.test(val) &&
        /[\W_]/.test(val);

    /* RULE MESSAGE */

    if(!rulesOk){

        msg.textContent =
        "Password must be 8–20 chars with uppercase, lowercase, number & special character";

        msg.style.color = "red";

        return;
    }

    /* STRENGTH */

    if(val.length <= 10){

        msg.textContent =
        "Weak password";

        msg.style.color = "orange";
    }
    else if(val.length <= 15){

        msg.textContent =
        "Medium password";

        msg.style.color = "#2563eb";
    }
    else{

        msg.textContent =
        "Strong password";

        msg.style.color = "green";
    }

});

</script>

</body>
</html>
