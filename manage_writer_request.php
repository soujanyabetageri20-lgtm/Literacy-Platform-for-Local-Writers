<?php
session_start();
include 'db_connect.php';

$user_id = $_SESSION['user_id'];

// GET CURRENT STATUS
$sql = "SELECT role, writer_request FROM users WHERE user_id='$user_id'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

// CASE 1: CANCEL PENDING REQUEST
if($user['writer_request'] == 'pending'){
    
    // DELETE REQUEST
    mysqli_query($conn, "DELETE FROM writer_requests WHERE user_id='$user_id'");
    
    // UPDATE USER TABLE
    mysqli_query($conn, "UPDATE users SET writer_request='none' WHERE user_id='$user_id'");

    header("Location: user_dashboard.php");
    exit();
}

// CASE 2: REMOVE WRITER ROLE
mysqli_query($conn,
"UPDATE users
SET role='user',
writer_request='none'
WHERE user_id='$user_id'");

$_SESSION['role'] = 'user';

echo "
<script>

if(confirm('Are you sure you want to leave writer role?')){

alert('You have successfully left the writer role.');

window.location.href='user_dashboard.php';

}
else{

window.location.href='user_dashboard.php';

}

</script>
";

exit();