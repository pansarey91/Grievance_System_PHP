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
    <?php include 'studheader.php'; ?>

    <!-- Main Content -->
    <main class="main-content">
        <div class="hero-section">
            <h1>Welcome to the Complaint System</h1>
            <p>Your platform to voice concerns about hostel, food, library, and more.</p>
            <a href="complaint.php" class="btn">Submit a Complaint</a>
        </div>

        <section class="features">
            <div class="feature">
                <h2>Hostel Issues</h2>
                <p>Submit complaints about hostel maintenance, cleanliness, and more.</p>
            </div>
            <div class="feature">
                <h2>Food Services</h2>
                <p>Share feedback or report issues with the food services provided.</p>
            </div>
            <div class="feature">
                <h2>Library Services</h2>
                <p>Report problems with library facilities or request new resources.</p>
            </div>
        </section>
    </main>

    <!-- Include Footer -->
    <?php include 'studfooter.php'; ?>
</body>
</html>