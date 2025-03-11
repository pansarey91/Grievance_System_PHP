<?php
 session_start();
    
    if(!isset($_SESSION['login_type']) || $_SESSION['login_type'] !== 'admin') {
        echo"<script>alert('You are not logged in as an admin.'); window.location.href = 'login.html';</script>";
        session_unset();
        session_destroy();
        exit();
    }
 
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Complaint System</title>
    <!-- Link to Stylesheet -->
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <!-- Include Header -->
    <?php include 'header.php'; ?>

    <!-- Main Content -->
    <main class="main-content">
        <div class="hero-section">
            <h1>Welcome to the Complaint System <?php echo $_SESSION['fullname']; ?></h1>
            <p>Your platform to voice concerns about hostel, food, library, and more.</p>
            <a href="view_complaints.php" class="btn">View Complaints</a>
        </div>

        <section class="features">
            <div class="feature">
                <h2><i class="fas fa-bed"></i> Hostel Issues</h2>
                <p>Submit complaints about hostel maintenance, cleanliness, and more.</p>
            </div>
            <div class="feature">
                <h2><i class="fas fa-utensils"></i> Food Services</h2>
                <p>Share feedback or report issues with the food services provided.</p>
            </div>
            <div class="feature">
                <h2><i class="fas fa-book"></i> Library Services</h2>
                <p>Report problems with library facilities or request new resources.</p>
            </div>
        </section>
    </main>

    <!-- Include Footer -->
    <?php include 'footer.php'; ?>
</body>

</html>