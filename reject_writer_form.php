<!DOCTYPE html>
<html>
<head>
    <title>Reject Request</title>
    <style>

    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap');

/* ===== BODY ===== */

body{
    margin:0;
    font-family:'Poppins', sans-serif;

    background:linear-gradient(to right, #dbeafe 0%, #e0f7fa 100%);
    background-attachment:fixed;

    color:#0d3b66;
}

/* ===== CONTAINER ===== */

.container{
    width:40%;
    margin:80px auto;

    background:#ffffff;

    padding:35px;

    border-radius:24px;

    border:none;

    box-shadow:0 12px 35px rgba(0,0,0,0.1);

    text-align:center;
}

/* ===== HEADING ===== */

.container h2{
    color:#0d3b66;
    font-size:32px;
    margin-bottom:15px;
    font-weight:800;
}

/* ===== PARAGRAPH ===== */

.container p{
    color:#5b6475;
    line-height:1.8;
    font-size:15px;
}

/* ===== TEXTAREA ===== */

textarea{
    width:100%;
    height:120px;

    padding:14px;

    border-radius:16px;
    border:1px solid #dbeafe;

    background:#ffffff;

    color:#0d3b66;

    resize:none;

    font-family:'Poppins', sans-serif;

    transition:0.3s;
}

/* ===== FOCUS ===== */

textarea:focus{
    outline:none;

    border:1px solid #60a5fa;

    box-shadow:0 4px 15px rgba(96,165,250,0.2);
}

/* ===== BUTTON BASE ===== */

.btn{
    margin-top:15px;

    padding:12px 24px;

    border:none;
    border-radius:14px;

    color:white;

    cursor:pointer;

    font-weight:700;

    transition:0.3s;

    font-family:'Poppins', sans-serif;
}

/* ===== REJECT BUTTON ===== */

.reject-btn{
    background:linear-gradient(to right, #4facfe, #00f2fe);

    box-shadow:0 6px 20px rgba(79,172,254,0.3);
}

.reject-btn:hover{
    transform:translateY(-2px);

    box-shadow:0 10px 25px rgba(79,172,254,0.45);
}

/* ===== BACK BUTTON ===== */

.back-btn{
    background:#ffffff;

    color:#0d3b66;

    border:1px solid #dbeafe;

    box-shadow:0 4px 12px rgba(0,0,0,0.06);
}

.back-btn:hover{
    background:#f0faff;

    transform:translateY(-2px);
}

/* ===== RESPONSIVE ===== */

@media(max-width:768px){

    .container{
        width:90%;
        padding:25px;
    }

}
</style>
</head>

<body>

<div class="container">
    <h2>Reject Writer Request</h2>

    <form method="POST" action="handle_writer_request.php">

        <input type="hidden" name="request_id" value="<?php echo $_GET['id']; ?>">

        <textarea name="reason" placeholder="Enter rejection reason..." required></textarea>

        <br>
        
        <button type="submit" name="reject" class="btn reject-btn">
            Submit
        </button>
    </form>

    <!-- BACK BUTTON -->
    <form action="admin_writer_requests.php">
        <button class="btn back-btn">⬅ Back</button>
    </form>

</div>

</body>
</html>