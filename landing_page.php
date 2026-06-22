<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Literacy Hub</title>

    <link rel="stylesheet"
          href="landing_page.css?v=3">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>

<!-- ================= NAVBAR ================= -->

<div class="navbar">

    <div class="logo">
        📚 Literacy Hub
    </div>

    <div class="nav-links">

        <a href="#features">Features</a>

        <a href="#achievements">Achievements</a>

        <a href="#about">About</a>

        <a href="index.php">Explore</a>

        <?php if(isset($_SESSION['user_id'])){ ?>

            <a href="user_dashboard.php"
               class="main-btn">

               Dashboard

            </a>

        <?php } else { ?>

            <a href="login.html"
               class="main-btn">

               Login

            </a>

        <?php } ?>

    </div>

</div>


<!-- ================= HERO SECTION ================= -->

<section class="hero">

    <div class="hero-left">

        <h1>
            Discover Stories,<br>
            Share Creativity,<br>
            Build Achievements.
        </h1>

        <p>
            Literacy Hub is a modern digital storytelling platform
            where readers and writers connect through creative content,
            achievements, ratings, discussions, and interactive experiences.
        </p>

        <div class="hero-buttons">

            <a href="index.php"
               class="hero-btn primary-btn">

               Explore Stories

            </a>

            <a href="register.html"
               class="hero-btn secondary-btn">

               Join Community

            </a>

        </div>

    </div>


    <div class="hero-right">

        <div class="hero-card">

            <h2>
                Platform Highlights
            </h2>

            <div class="feature-item">

                <div class="feature-icon">
                    ✍️
                </div>

                <div>
                    <h3>Creative Writing</h3>
                    <p>Publish stories and share ideas.</p>
                </div>

            </div>


            <div class="feature-item">

                <div class="feature-icon">
                    🏆
                </div>

                <div>
                    <h3>Achievements</h3>
                    <p>Unlock badges and certificates.</p>
                </div>

            </div>


            <div class="feature-item">

                <div class="feature-icon">
                    💬
                </div>

                <div>
                    <h3>Community</h3>
                    <p>Interact through comments and ratings.</p>
                </div>

            </div>


            <div class="feature-item">

                <div class="feature-icon">
                    📚
                </div>

                <div>
                    <h3>Reading Experience</h3>
                    <p>Explore engaging stories and articles.</p>
                </div>

            </div>

        </div>

    </div>

</section>


<!-- ================= FEATURES ================= -->

<section class="section"
         id="features">

    <h2 class="section-title">
        Platform Features
    </h2>

    <p class="section-subtitle">

        Everything needed for an engaging reading
        and writing experience.

    </p>


    <div class="features-grid">

        <div class="feature-box">

            <i class="fa-solid fa-book-open"></i>

            <h3>Read Stories</h3>

            <p>
                Explore creative stories and informative posts
                from different writers.
            </p>

        </div>


        <div class="feature-box">

            <i class="fa-solid fa-pen-nib"></i>

            <h3>Create Content</h3>

            <p>
                Writers can publish posts and share their creativity
                with the community.
            </p>

        </div>


        <div class="feature-box">

            <i class="fa-solid fa-star"></i>

            <h3>Ratings & Reviews</h3>

            <p>
                Readers can rate posts and interact with content
                through comments.
            </p>

        </div>


        <div class="feature-box">

            <i class="fa-solid fa-shield-heart"></i>

            <h3>Creative Community</h3>

            <p>
                A collaborative environment where readers and writers
                share ideas, creativity, and knowledge.
            </p>

        </div>

    </div>

</section>


<!-- ================= ACHIEVEMENTS ================= -->

<section class="achievement-section"
         id="achievements">

    <h2 class="section-title">
        Unlock Achievements
    </h2>

    <p class="section-subtitle">

        Earn badges and certificates based on your activity.

    </p>


    <div class="badge-grid">

        <div class="badge-card">

            <div class="badge-icon">
                📚
            </div>

            <h3>Book Explorer</h3>

            <p>
                Earned by active readers who regularly
                explore stories.
            </p>

        </div>


        <div class="badge-card">

            <div class="badge-icon">
                💬
            </div>

            <h3>Community Voice</h3>

            <p>
                Given to users who actively participate
                in discussions.
            </p>

        </div>


        <div class="badge-card">

            <div class="badge-icon">
                ✍️
            </div>

            <h3>Published Author</h3>

            <p>
                Writers receive this achievement
                after publishing posts.
            </p>

        </div>


        <div class="badge-card">

            <div class="badge-icon">
                🎓
            </div>

            <h3>Certificates</h3>

            <p>
                Unlock digital certificates after completing
                achievement milestones.
            </p>

        </div>

    </div>

</section>


<!-- ================= ABOUT ================= -->

<section class="section"
         id="about">

    <h2 class="section-title">
        About Literacy Hub
    </h2>

    <p class="section-subtitle">

        A modern platform designed to encourage reading,
        writing, creativity, and community engagement.

    </p>


    <div class="features-grid">

        <div class="feature-box">

            <i class="fa-solid fa-users"></i>

            <h3>Community Driven</h3>

            <p>
                Readers and writers connect through meaningful
                discussions and engagement.
            </p>

        </div>


        <div class="feature-box">

            <i class="fa-solid fa-award"></i>

            <h3>Gamified Experience</h3>

            <p>
                Achievements and certificates make the platform
                interactive and motivating.
            </p>

        </div>


        <div class="feature-box">

            <i class="fa-solid fa-laptop-code"></i>

            <h3>Modern Platform</h3>

            <p>
                Built with a clean and responsive design
                for smooth user experience.
            </p>

        </div>

    </div>

</section>


<!-- ================= CTA ================= -->

<section class="cta-section">

    <div class="cta-box">

        <h2>
            Start Your Journey Today
        </h2>

        <p>
            Join Literacy Hub and explore stories,
            achievements, and creative experiences.
        </p>

        <a href="register.html"
           class="hero-btn primary-btn">

           Get Started

        </a>

    </div>

</section>


<!-- ================= FOOTER ================= -->

<footer class="footer">

    <div class="footer-grid">

        <div>

            <h3>Literacy Hub</h3>

            <p>
                A modern storytelling and achievement platform
                designed for readers and writers worldwide.
            </p>

        </div>


        <div>

            <h3>Quick Links</h3>

            <a href="index.php">Home</a><br>

            <a href="login.html">Login</a><br>

            <a href="register.html">Register</a><br>

            <a href="user_dashboard.php">Dashboard</a>

        </div>


        <div>

            <h3>Features</h3>

            <p>Story Reading</p>

            <p>Writer Dashboard</p>

            <p>Achievements</p>

            <p>Certificates</p>

        </div>


        <div>

            <h3>Connect</h3>

            <p>Email: literacyhub@gmail.com</p>

            <p>Community Platform</p>

            <p>Creative Writing Network</p>

        </div>

    </div>


    <div class="footer-bottom">

        © 2026 Literacy Hub | All Rights Reserved

    </div>

</footer>

</body>
</html>