<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint System</title>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="styles.css">

</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <a class="navbar-brand" href="admin_dashboard.php">Complaint System</a>
        <button class="navbar-toggler" onclick="toggleMenu()">&#9776;</button>
        <ul class="navbar-nav" id="navbarNav">
            <li class="nav-item">
                <a class="nav-link" href="admin_dashboard.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="view_complaints.php">Complaints</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="view_email_logs.php">E-Logs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="view_reports.php">Reports</a>
            </li>
            <li class="nav-item">
                <a class="nav-link logout-btn" href="logout.php" style="color: red; font-weight: bold;">Logout</a>
            </li>
        </ul>
    </nav>

    <script>
        function toggleMenu() {
            const navbarNav = document.getElementById('navbarNav');
            navbarNav.classList.toggle('active');
        }
    </script>