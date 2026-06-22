<?php
session_start();
include 'db_connect.php';

/* LOGIN CHECK */

if(!isset($_SESSION['user_id'])){
    header("Location: login.html");
    exit();
}

/* SESSION DATA */

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$role = $_SESSION['role'];

$notif_query = mysqli_query($conn,
"SELECT * FROM notifications 
 WHERE user_id='$user_id' AND 
 status='unread'
 ORDER BY created_at DESC
 LIMIT 1");

$notification = mysqli_fetch_assoc($notif_query);


/* ================= WRITER STATS ================= */

$total_posts = 0;
$total_likes = 0;
$total_ratings = 0;

if($role == 'writer'){

    $post_query = mysqli_query($conn,
    "SELECT COUNT(*) as total_posts
     FROM posts
     WHERE author_id='$user_id'");

    $post_data = mysqli_fetch_assoc($post_query);

    $total_posts = $post_data['total_posts'];


    $writer_like_query = mysqli_query($conn,
    "SELECT COUNT(*) as total_likes
     FROM post_reactions pr
     JOIN posts p
     ON pr.post_id = p.post_id
     WHERE p.author_id='$user_id'
     AND pr.reaction='like'");

    $writer_like_data = mysqli_fetch_assoc($writer_like_query);

    $total_likes = $writer_like_data['total_likes'];


    $writer_rating_query = mysqli_query($conn,
    "SELECT COUNT(*) as total_ratings
     FROM ratings r
     JOIN posts p
     ON r.post_id = p.post_id
     WHERE p.author_id='$user_id'");

    $writer_rating_data = mysqli_fetch_assoc($writer_rating_query);

    $total_ratings = $writer_rating_data['total_ratings'];

}


/* ================= USER STATS ================= */

$user_ratings = 0;
$user_comments = 0;
$user_likes = 0;

if($role == 'user'){

    $rating_query = mysqli_query($conn,
    "SELECT COUNT(*) as total
     FROM ratings
     WHERE user_id='$user_id'");

    $rating_data = mysqli_fetch_assoc($rating_query);

    $user_ratings = $rating_data['total'];


    $comment_query = mysqli_query($conn,
    "SELECT COUNT(*) as total
     FROM comments
     WHERE user_id='$user_id'");

    $comment_data = mysqli_fetch_assoc($comment_query);

    $user_comments = $comment_data['total'];


    $like_query = mysqli_query($conn,
    "SELECT COUNT(*) as total
     FROM post_reactions
     WHERE user_id='$user_id'
     AND reaction='like'");

    $like_data = mysqli_fetch_assoc($like_query);

    $user_likes = $like_data['total'];

}


/* ================= ADMIN STATS ================= */

$total_users = 0;
$total_writers = 0;
$total_pending_posts = 0;

if($role == 'admin'){

    $user_query = mysqli_query($conn,
    "SELECT COUNT(*) as total
     FROM users
     WHERE role='user'");

    $user_data = mysqli_fetch_assoc($user_query);

    $total_users = $user_data['total'];


    $writer_query = mysqli_query($conn,
    "SELECT COUNT(*) as total
     FROM users
     WHERE role='writer'");

    $writer_data = mysqli_fetch_assoc($writer_query);

    $total_writers = $writer_data['total'];


    $pending_query = mysqli_query($conn,
    "SELECT COUNT(*) as total
     FROM posts
     WHERE status='pending'");

    $pending_data = mysqli_fetch_assoc($pending_query);

    $total_pending_posts = $pending_data['total'];

}

?>

<!DOCTYPE html>
<html>

<head>

    <title>User Dashboard</title>

    <link rel="stylesheet" href="user_dashboard.css?v=17">

</head>

<body>

    <!-- notification popup UI -->
<?php if($notification){ ?>
<div id="popup" style="position:fixed;top:30%;left:50%;transform:translate(-50%,-50%);background:#fff;padding:25px;border-radius:15px;z-index:9999;text-align:center;">
<p><?php echo $notification['message']; ?></p>
<button onclick="closePopup()">OK</button>
</div>
<script>
// close popup + mark read + redirect
function closePopup(){
window.location.href="mark_notification_read.php?user_id=<?php echo $user_id; ?>";
}
</script>
<?php } ?>

<div class="dashboard-layout">

    <!-- SIDEBAR -->

    <div class="sidebar">

        <div class="profile-box">

            <h2>📚 Literacy Hub</h2>

            <p><?php echo $username; ?></p>

            <p><?php echo ucfirst($role); ?></p>

        </div>


        <!-- USER MENU -->

        <?php if($role == 'user'){ ?>

        <div class="menu-section">

            <div class="menu-title">
                Writer Access
            </div>

            <?php

            $res = mysqli_query($conn,
            "SELECT writer_request
             FROM users
             WHERE user_id='$user_id'");

            $row = mysqli_fetch_assoc($res);

            $status = $row['writer_request'];

            ?>

            <?php if(
                $status == 'none' ||
                $status == 'rejected' ||
                $status == '' ||
                is_null($status)
            ){ ?>

                <a href="request_writer.php"
                   class="menu-item">

                   ✍️ Become Writer

                </a>

            <?php } elseif($status == 'pending'){ ?>

                <div class="pending-box">
                    ⏳ Request Pending
                </div>

                <form action="manage_writer_request.php"
method="POST"
onsubmit="return confirmCancelRequest()">

                    <button class="menu-item"
                            type="submit"
                            name="cancel_request">

                        ❌ Cancel Request

                    </button>

                </form>

            <?php } ?>

        </div>

        <?php } ?>


        <!-- WRITER MENU -->

        <?php if($role == 'writer'){ ?>

        <div class="menu-section">

            <div class="menu-title">
                Content Management
            </div>

            <a href="create_post.php"
               class="menu-item">

               📝 Create Post

            </a>

            <a href="my_posts1.php"
               class="menu-item">

               📚 My Posts

            </a>

            <form action="manage_writer_request.php"
                  method="POST" onsubmit="return confirmLeaveCancel()">

                <button class="menu-item"
                        type="submit"
                        name="remove_writer">

                    ❌ Leave Writer Role

                </button>

            </form>

        </div>

        <?php } ?>


        <!-- ADMIN MENU -->

        <?php if($role == 'admin'){ ?>

        <div class="menu-section">

            <div class="menu-title">
                Admin Panel
            </div>

            <a href="approve_post.php"
               class="menu-item">

               📄 Post Approval

            </a>

            <a href="admin_writer_requests.php"
               class="menu-item">

               📝 Writer Requests

            </a>

            <a href="view_writers.php"
               class="menu-item">

               ✍️ Writers

            </a>

            <a href="view_users.php"
               class="menu-item">

               👤 Users

            </a>

        </div>

        <?php } ?>


        <!-- COMMON MENU -->

        <div class="menu-section">

            <div class="menu-title">
                Navigation
            </div>

            <?php if($role != 'admin'){ ?>

            <a href="achievements.php"
               class="menu-item">

               🏆 Achievements

            </a>

            <?php } ?>

            <a href="my_activities.php"
               class="menu-item">

               🧾 Activities

            </a>

            <a href="index.php"
               class="menu-item">

               🏠 Home Page

            </a>

            <a href="#"
class="menu-item logout-item"
onclick="confirmLogout()">

🚪 Logout

</a>

        </div>

    </div>


    <!-- MAIN CONTENT -->

    <div class="main-content">


        <!-- WELCOME -->

        <div class="welcome-card">

            <h1>
                Welcome,
                <?php echo $username; ?>
            </h1>

            <p>
                Manage your Literacy Hub journey from one modern dashboard.
            </p>

        </div>


        <!-- WRITER STATS -->

        <?php if($role == 'writer'){ ?>

        <div class="stats-grid">

            <div class="stat-card">

                <div class="stat-icon">📝</div>

                <h2><?php echo $total_posts; ?></h2>

                <p>Total Posts</p>

            </div>


            <div class="stat-card">

                <div class="stat-icon">❤️</div>

                <h2><?php echo $total_likes; ?></h2>

                <p>Likes Received</p>

            </div>


            <div class="stat-card">

                <div class="stat-icon">⭐</div>

                <h2><?php echo $total_ratings; ?></h2>

                <p>Ratings Received</p>

            </div>

        </div>

        <?php } ?>


        <!-- USER STATS -->

        <?php if($role == 'user'){ ?>

        <div class="stats-grid">

            <div class="stat-card">

                <div class="stat-icon">⭐</div>

                <h2><?php echo $user_ratings; ?></h2>

                <p>Ratings Given</p>

            </div>


            <div class="stat-card">

                <div class="stat-icon">💬</div>

                <h2><?php echo $user_comments; ?></h2>

                <p>Comments Made</p>

            </div>


            <div class="stat-card">

                <div class="stat-icon">❤️</div>

                <h2><?php echo $user_likes; ?></h2>

                <p>Likes Given</p>

            </div>

        </div>

        <?php } ?>


        <!-- ADMIN STATS -->

        <?php if($role == 'admin'){ ?>

        <div class="stats-grid">

            <div class="stat-card">

                <div class="stat-icon">👤</div>

                <h2><?php echo $total_users; ?></h2>

                <p>Total Users</p>

            </div>


            <div class="stat-card">

                <div class="stat-icon">✍️</div>

                <h2><?php echo $total_writers; ?></h2>

                <p>Total Writers</p>

            </div>


            <div class="stat-card">

                <div class="stat-icon">📄</div>

                <h2><?php echo $total_pending_posts; ?></h2>

                <p>Pending Posts</p>

            </div>

        </div>

        <?php } ?>


        <!-- ACHIEVEMENT GALLERY -->

        <?php
        if($role != 'admin'){

            $achievement_query = mysqli_query($conn,
            "SELECT badge_name FROM achievements
             WHERE user_id='$user_id'");

            $unlocked_badges = [];

            while($row = mysqli_fetch_assoc($achievement_query)){

                $clean_badge = strtolower(
                    trim(
                        preg_replace('/\s+/', ' ', $row['badge_name'])
                    )
                );

                $unlocked_badges[] = $clean_badge;

            }

            if($role == 'user'){

                $badges = [

                    ["name"=>"Book Explorer","icon"=>"📚"],
                    ["name"=>"Community Voice","icon"=>"💬"],
                    ["name"=>"Top Supporter","icon"=>"❤️"],
                    ["name"=>"Certificate","icon"=>"🎓"]

                ];

            } else {

                $badges = [

                    ["name"=>"Published Author","icon"=>"✍️"],
                    ["name"=>"Trending Writer","icon"=>"🔥"],
                    ["name"=>"Reader Favorite","icon"=>"⭐"],
                    ["name"=>"Certificate","icon"=>"🎓"]

                ];

            }
        ?>

        <div class="achievement-gallery">

            <div class="gallery-header">

                <h2>🏆 Achievement Gallery</h2>

                <a href="achievements.php"
                   class="view-all-btn">

                   View All

                </a>

            </div>

            <div class="gallery-grid">

                <?php foreach($badges as $badge){

                    $current_badge = strtolower(
                        trim($badge['name'])
                    );

                    $isUnlocked = in_array(
                        $current_badge,
                        $unlocked_badges
                    );

                ?>

               <div class="gallery-card <?php echo $isUnlocked ? 'unlocked' : 'locked'; ?>"

<?php if($isUnlocked){ ?>

    <?php if(strtolower($badge['name']) == 'certificate'){ ?>

        onclick="window.location.href='gallery_certificate.php'"

    <?php } else { ?>

        onclick="window.location.href='gallery_badge.php?badge=<?php echo urlencode($badge['name']); ?>'"

    <?php } ?>

    style="cursor:pointer;"

<?php } ?>

>

                    <div class="gallery-icon">
                        <?php echo $badge['icon']; ?>
                    </div>

                    <h3>
                        <?php echo $badge['name']; ?>
                    </h3>

                    <p>
                        <?php echo $isUnlocked ? 'Unlocked' : 'Locked'; ?>
                    </p>

                </div>

                <?php } ?>

            </div>

        </div>

        <?php } ?>


        <!-- QUICK ACTIONS -->

        <div class="quick-section">

            <h2 class="quick-title">
                Quick Actions
            </h2>

            <div class="quick-actions">

                <?php if($role == 'writer'){ ?>

                <a href="create_post.php"
                   class="quick-btn">

                   ✍️ Create Post

                </a>

                <?php } ?>


                <?php if($role != 'admin'){ ?>

                <a href="achievements.php"
                   class="quick-btn">

                   🏆 View Achievements

                </a>

                <?php } ?>


                <a href="index.php"
                   class="quick-btn">

                   📚 Explore Posts

                </a>

            </div>

        </div>

    </div>

</div>

<script>

function confirmLeaveCancel(){

    return confirm("Are you sure you want to cancel your writer request?"){

        

    }

}


</script>

<script>

function confirmLogout(){

    if(confirm("Are you sure you want to logout?")){

        window.location.href = "logout.php";

    }

}

</script>
<script>

function confirmCancelRequest(){

    return confirm(
    "Are you sure you want to cancel your writer request?"
    );

}

</script>

</body>
</html>