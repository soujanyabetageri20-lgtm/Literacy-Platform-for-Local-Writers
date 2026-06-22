<?php
session_start();
include 'db_connect.php';

// SECURITY CHECK
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: login.html");
    exit();
}

// FETCH REQUESTS
$sql = "SELECT writer_requests.*, users.username 
        FROM writer_requests
        JOIN users ON writer_requests.user_id = users.user_id
        ORDER BY writer_requests.created_at DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>

<head>

    <title>Writer Requests</title>

    <style>

@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap');

body{
    margin:0;
    font-family:'Poppins', sans-serif;
    background:linear-gradient(to right, #dbeafe, #e0f7fa);
    background-attachment:fixed;
    color:#0d3b66;
}

h2{
    text-align:center;
    margin-top:35px;
    margin-bottom:10px;
    font-weight:800;
    font-size:34px;
}

.sub-text{
    text-align:center;
    color:#64748b;
    margin-bottom:30px;
    font-size:15px;
}

table{
    width:92%;
    margin:30px auto;
    border-collapse:collapse;
    background:#ffffff;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 12px 35px rgba(0,0,0,0.08);
}

th{
    background:linear-gradient(to right, #4facfe, #00f2fe);
    color:white;
    padding:16px;
    font-size:15px;
    font-weight:700;
    text-align:center;
}

td{
    padding:18px 14px;
    border-bottom:1px solid #edf2f7;
    text-align:center;
    font-size:14px;
    vertical-align:top;
}

tr:hover{
    background:#f8fbff;
}

.message-box{
    text-align:left;
    background:#f8fbff;
    padding:14px;
    border-radius:14px;
    line-height:1.7;
    color:#334155;
    min-width:250px;
    white-space:pre-line;
}

.status-pending{
    color:#f59e0b;
    font-weight:700;
}

.status-approved{
    color:#22c55e;
    font-weight:700;
}

.status-rejected{
    color:#ef4444;
    font-weight:700;
}

.reason-box{
    margin-top:10px;
    padding:10px;
    background:#fff1f2;
    border-radius:12px;
    color:#dc2626;
    font-size:13px;
    line-height:1.1;
}

button{
    padding:10px 16px;
    border:none;
    border-radius:12px;
    color:white;
    cursor:pointer;
    font-weight:700;
    font-family:'Poppins', sans-serif;
    transition:0.3s;
    margin:4px;
}

.approve{
    background:linear-gradient(to right, #22c55e, #4ade80);
    box-shadow:0 4px 12px rgba(34,197,94,0.25);
}

.approve:hover{
    transform:translateY(-2px);
}

.reject{
    background:linear-gradient(to right, #ff6a6a, #ff3d3d);
    box-shadow:0 4px 12px rgba(255,61,61,0.25);
}

.reject:hover{
    transform:translateY(-2px);
}

.back-btn{
    display:inline-block;
    margin-top:10px;
    padding:12px 20px;
    background:linear-gradient(to right, #4facfe, #00f2fe);
    color:white;
    text-decoration:none;
    border-radius:14px;
    font-weight:700;
    box-shadow:0 4px 15px rgba(79,172,254,0.25);
    transition:0.3s;
}

.back-btn:hover{
    transform:translateY(-2px);
}

@media(max-width:768px){
    table{
        width:98%;
        font-size:12px;
    }

    td, th{
        padding:10px;
    }
}

    </style>

</head>

<body>

<h2>📝 Writer Requests</h2>

<p class="sub-text">
Review and manage writer applications from users
</p>

<table>

<tr>
    <th>User</th>
    <th>Application</th>
    <th>Date</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>

    <!-- USER -->
    <td>
        <strong><?php echo $row['username']; ?></strong>
    </td>

    <!-- MESSAGE -->
    <td>
        <div class="message-box" style="white-space: pre;">
             <?php 
        echo trim(preg_replace("/\n{2,}/", "\n", $row['request_message'])); 
    ?>
        </div>
    </td>

    <!-- DATE -->
    <td>
        <?php echo $row['created_at']; ?>
    </td>

    <!-- STATUS -->
    <td>

        <?php if($row['status'] == 'pending'){ ?>
            <span class="status-pending">⏳ Pending</span>
        <?php } elseif($row['status'] == 'approved'){ ?>
            <span class="status-approved">✔ Approved</span>
        <?php } elseif($row['status'] == 'rejected'){ ?>
            <span class="status-rejected">✖ Rejected</span>
        <?php } ?>

        <?php if(!empty($row['rejection_reason'])){ ?>
            <div class="reason-box">
                <strong>Reason:</strong><br>
                <?php echo $row['rejection_reason']; ?>
            </div>
        <?php } ?>

    </td>

    <!-- ACTION (FIXED - ALWAYS VISIBLE) -->
    <td>

<?php if($row['status'] == 'pending'){ ?>

    <!-- APPROVE -->
    <form action="handle_writer_request.php"
    method="POST"
    style="display:inline;">

        <input type="hidden"
        name="request_id"
        value="<?php echo $row['request_id']; ?>">

        <button name="approve"
        class="approve">

            Approve

        </button>

    </form>

    <!-- REJECT -->
    <form action="reject_writer_form.php"
    method="GET"
    style="display:inline;">

        <input type="hidden"
        name="id"
        value="<?php echo $row['request_id']; ?>">

        <button type="submit"
        class="reject">

            Reject

        </button>

    </form>

<?php } elseif($row['status'] == 'approved'){ ?>

    <span class="status-approved">
        ✔ Approved Successfully
    </span>

<?php } elseif($row['status'] == 'rejected'){ ?>

    <span class="status-rejected">
        ✖ Request Cancelled / Rejected
    </span>

    <?php if(!empty($row['rejection_reason'])){ ?>

    <div class="reason-box">

        <strong>Reason:</strong><br>
        <?php echo $row['rejection_reason']; ?>

        <br><br>

        <strong>Rating:</strong><br>

        <?php
            $rating = $row['rating'];

            for($i = 1; $i <= 5; $i++){

                if($i <= $rating){
                    echo "⭐";
                } else {
                    echo "☆";
                }

            }

            echo " ($rating / 5)";
        ?>

    </div>

<?php } ?>
<?php } ?>

</td>
</tr>

<?php } ?>

</table>

<div style="text-align:center; margin-bottom:40px;">

    <a href="user_dashboard.php"
    class="back-btn">

        ⬅ Back to Dashboard

    </a>

</div>

</body>
</html>