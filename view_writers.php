<?php
session_start();
include 'db_connect.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: login.html");
    exit();
}

$sql = "SELECT * FROM users WHERE role='writer'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Writers</title>

    <style>
       /* ===== BODY ===== */
body {
    margin: 0;
    font-family: 'Poppins', sans-serif;

    /* PASTEL GRADIENT BACKGROUND */
    background: linear-gradient(to right, #dbeafe, #e0f7fa);
    background-attachment: fixed;

    color: #0d3b66;
}

/* ===== CONTAINER ===== */
.container {
    width: 80%;
    margin: 40px auto;

    /* GLASS EFFECT */
    background: rgba(255, 255, 255, 0.9);

    padding: 25px;

    border-radius: 20px;

    border: none;

    box-shadow:
        0 10px 30px rgba(0,0,0,0.1);
}

/* ===== TITLE ===== */
h2 {
    text-align: center;
    color: #0d3b66;
    font-weight: 800;
}

/* ===== TABLE ===== */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;

    background: #ffffff;

    border-radius: 14px;
    overflow: hidden;

    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
}

/* ===== HEADER ===== */
th {
    background: linear-gradient(to right, #60a5fa, #22d3ee);
    color: white;
    padding: 12px;
}

/* ===== CELLS ===== */
td {
    padding: 10px;
    text-align: center;
    border-bottom: 1px solid #e0f2fe;

    color: #334155;
}

/* ===== ROW HOVER ===== */
tr:hover {
    background: #f0f9ff;
}

/* ===== BACK BUTTON ===== */
.back-btn {
    display: block;
    width: fit-content;
    margin: 25px auto 0;

    background: linear-gradient(to right, #60a5fa, #22d3ee);
    color: white;

    padding: 10px 20px;

    border-radius: 12px;

    text-decoration: none;
    font-weight: 700;

    box-shadow: 0 4px 15px rgba(96,165,250,0.3);
}

/* ===== HOVER ===== */
.back-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(96,165,250,0.4);
}
    </style>
</head>

<body>

<div class="container">

<h2>✍️ Approved Writers (<?php echo mysqli_num_rows($result); ?>)</h2>

<table>
<tr>
    <th>Username</th>
    <th>Email</th>
    <th>Created Date</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>
<tr>
    <td><?php echo $row['username']; ?></td>
    <td><?php echo $row['email']; ?></td>
    <td><?php echo date("d M Y", strtotime($row['created_at'])); ?></td>
</tr>
<?php } ?>

</table>

<a href="user_dashboard.php" class="back-btn">⬅ Back</a>

</div>

</body>
</html>