<?php
session_start();
include 'db_connect.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

/* CHECK PENDING REQUEST */

$check = mysqli_query($conn,
"SELECT * FROM writer_requests
 WHERE user_id='$user_id'
 AND status='pending'");

if(mysqli_num_rows($check) > 0){

    echo "
    <script>
    alert('Your writer request is already pending.');
    window.location='user_dashboard.php';
    </script>
    ";
    exit();
}

/* SUBMIT FORM */

if(isset($_POST['submit'])){

    $fullname = mysqli_real_escape_string($conn,$_POST['fullname']);
    $interest = mysqli_real_escape_string($conn,$_POST['interest']);
    $experience = mysqli_real_escape_string($conn,$_POST['experience']);
    $reason = mysqli_real_escape_string($conn,$_POST['reason']);
    $goals = mysqli_real_escape_string($conn,$_POST['goals']);

    $message = "
Full Name: $fullname

Writing Interest: $interest

Experience Level: $experience

Reason:
$reason

Writing Goals:
$goals
";

    mysqli_query($conn,
    "INSERT INTO writer_requests
    (user_id, request_message, status, created_at)
    VALUES
    ('$user_id','$message','pending',NOW())");

    mysqli_query($conn,
    "UPDATE users
     SET writer_request='pending'
     WHERE user_id='$user_id'");
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Become a Writer</title>

    <link rel="stylesheet" href="request_writer.css">

</head>

<body>

<div class="request-container">

    <div class="request-card">

        <h1>✍ Become a Writer</h1>

        <p class="subtitle">
            Share your creativity with the Literacy Hub community.
        </p>

        <form method="POST">

            <div class="form-group">

                <label>Full Name</label>

                <input type="text"
                name="fullname" id="fullname"
                required>
                <small id="nameError" class="error-text"></small>

            </div>

            <div class="form-group">

    <label>Writing Interest</label>

    <select name="interest" required>

        <option value="">Select Category</option>

        <?php

        $cat_query = mysqli_query($conn,
        "SELECT * FROM categories");

        while($cat = mysqli_fetch_assoc($cat_query)){

        ?>

        <option value="<?php echo $cat['category_name']; ?>">

            <?php echo $cat['category_name']; ?>

        </option>

        <?php } ?>

    </select>

</div>

            <div class="form-group">

                <label>Experience Level</label>

                <select name="experience" required>

                    <option value="">Select</option>

                    <option>Beginner</option>
                    <option>Intermediate</option>
                    <option>Experienced</option>

                </select>

            </div>

            <div class="form-group">

                <label>
                    Why do you want to become a writer?
                </label>

                <textarea
                name="reason"
                required></textarea>

            </div>

            <div class="form-group">

                <label>
                    What will you contribute to Literacy Hub?
                </label>

                <textarea
                name="goals"
                required></textarea>

            </div>

            <div class="checkbox-group">

                <input type="checkbox" required>

                <span>
                    I agree to follow Literacy Hub community guidelines.
                </span>

            </div>

            <button type="submit"
            name="submit"
            class="submit-btn">

                Submit Writer Request

            </button>

        </form>

        <div class="guidelines">

            <h3>📘 Writer Guidelines</h3>

            <ul>

                <li>Publish original content only</li>

                <li>Avoid harmful or offensive content</li>

                <li>Maintain quality writing standards</li>

                <li>Respect copyrights and community rules</li>

                <li>Approval may take some time</li>

            </ul>

        </div>

        <a href="user_dashboard.php"
        class="back-btn">

            ⬅ Back to Dashboard

        </a>

    </div>

</div>

<!-- SUCCESS POPUP -->

<?php if(isset($_POST['submit'])){ ?>

<div class="popup-overlay" id="successPopup">

    <div class="popup-box">

        <div class="popup-icon">
            ✅
        </div>

        <h2>
            Request Submitted
        </h2>

        <p>
            Your writer request has been sent successfully.
            Please wait for admin approval.
        </p>

        <button onclick="goDashboard()">
            OK
        </button>

    </div>

</div>

<?php } ?>

<script>

function goDashboard(){

    window.location.href = "user_dashboard.php";
}
const fullname = document.getElementById("fullname");
const nameError = document.getElementById("nameError");

fullname.onkeyup = function(){

    let original = fullname.value;

    // CHECK INVALID
    if(/[^A-Za-z\s]/.test(original)){

        nameError.innerHTML =
        "Only letters and spaces are allowed";

        nameError.style.color = "red";

        fullname.style.border =
        "1px solid red";

    }
    else{

        nameError.innerHTML = "";

        fullname.style.border =
        "1px solid #dbeafe";
    }

    // REMOVE INVALID CHARACTERS
    fullname.value =
    original.replace(/[^A-Za-z\s]/g,'');

}

</script>

</body>
</html>