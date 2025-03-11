<?php
session_start();
include 'database.php';

// Check if the admin is logged in
if (!isset($_SESSION['login_type']) || $_SESSION['login_type'] !== 'admin') {
    echo "<script>alert('You are not logged in as an admin.'); window.location.href = 'login.html';</script>";
    session_unset();
    session_destroy();
    exit();
}

// Initialize variables
$reportType = $_POST['report_type'] ?? '';
$startDate = $_POST['start_date'] ?? '';
$endDate = $_POST['end_date'] ?? '';
$reportData = [];
$reportTitle = '';

if ($reportType && $startDate && $endDate) {
    $query = "";
    $params = ['start_date' => $startDate, 'end_date' => $endDate];

    switch ($reportType) {
        case 'total_complaints':
            $query = "SELECT COUNT(*) AS total FROM complaints WHERE created_at BETWEEN :start_date AND :end_date";
            break;
        case 'complaints_by_type':
            $query = "SELECT complaint, COUNT(*) AS count FROM complaints WHERE created_at BETWEEN :start_date AND :end_date GROUP BY complaint";
            break;
        case 'complaints_by_status':
            $query = "SELECT status, COUNT(*) AS count FROM complaints WHERE created_at BETWEEN :start_date AND :end_date GROUP BY status";
            break;
        case 'complaints_by_user':
            $query = "SELECT u.fullname, COUNT(*) AS count FROM complaints c JOIN users u ON c.user_id = u.id WHERE c.created_at BETWEEN :start_date AND :end_date GROUP BY c.user_id, u.fullname";
            break;
        case 'recent_complaints':
            $query = "SELECT c.id, u.fullname, c.complaint, c.status, c.created_at FROM complaints c JOIN users u ON c.user_id = u.id WHERE c.created_at BETWEEN :start_date AND :end_date ORDER BY c.created_at DESC LIMIT 5";
            break;
        case 'pending_complaints':
        case 'in_progress_complaints':
        case 'resolved_complaints':
            $status = str_replace("_complaints", "", $reportType);
            $query = "SELECT c.id, u.fullname, u.class, u.email, c.complaint, c.description, c.status, c.created_at, c.updated_at FROM complaints c JOIN users u ON c.user_id = u.id WHERE c.status = :status AND c.created_at BETWEEN :start_date AND :end_date";
            $params['status'] = ucfirst(str_replace("_", " ", $status));
            break;
        case 'hostel_complaints':
        case 'food_complaints':
        case 'library_complaints':
            $type = str_replace("_complaints", "", $reportType);
            $query = "SELECT c.id, u.fullname, u.class, u.email, c.complaint, c.description, c.status, c.created_at, c.updated_at FROM complaints c JOIN users u ON c.user_id = u.id WHERE c.complaint = :complaint AND c.created_at BETWEEN :start_date AND :end_date";
            $params['complaint'] = $type;
            break;
    }
    if ($query) {
        $stmt = $conn->prepare($query);
        $stmt->execute($params);
        $reportData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $reportTitle = "Report from $startDate to $endDate";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - View Reports</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container1 {
            width: 90%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            margin-bottom: 20px;
            text-align: center;
        }

        select,
        input,
        button {
            padding: 10px;
            margin: 5px;
            font-size: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            text-align: left;
            padding: 10px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .no-data {
            text-align: center;
            color: #666;
            padding: 10px;
        }

        .print-button {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>

<body>

    <?php include 'header.php'; ?>

    <div class="container1">
        <h1>Complaint Reports</h1>
        <form method="post" action="">
            <label for="report_type">Choose a Report:</label>
            <select name="report_type" id="report_type" required>
                <option value="">-- Select Report --</option>
                <optgroup label="General Reports">
                    <option value="total_complaints" <?= $reportType === 'total_complaints' ? 'selected' : '' ?>>Total Complaints</option>
                    <option value="complaints_by_type" <?= $reportType === 'complaints_by_type' ? 'selected' : '' ?>>Complaints by Type</option>
                    <option value="complaints_by_status" <?= $reportType === 'complaints_by_status' ? 'selected' : '' ?>>Complaints by Status</option>
                    <option value="complaints_by_user" <?= $reportType === 'complaints_by_user' ? 'selected' : '' ?>>Complaints by User</option>
                    <option value="recent_complaints" <?= $reportType === 'recent_complaints' ? 'selected' : '' ?>>Recent Complaints</option>
                </optgroup>
                <optgroup label="Status Reports">
                    <option value="pending_complaints" <?= $reportType === 'pending_complaints' ? 'selected' : '' ?>>Pending Complaints</option>
                    <option value="in_progress_complaints" <?= $reportType === 'in_progress_complaints' ? 'selected' : '' ?>>In Progress Complaints</option>
                    <option value="resolved_complaints" <?= $reportType === 'resolved_complaints' ? 'selected' : '' ?>>Resolved Complaints</option>
                </optgroup>
                <optgroup label="Type Reports">
                    <option value="hostel_complaints" <?= $reportType === 'hostel_complaints' ? 'selected' : '' ?>>Hostel Complaints</option>
                    <option value="food_complaints" <?= $reportType === 'food_complaints' ? 'selected' : '' ?>>Food Complaints</option>
                    <option value="library_complaints" <?= $reportType === 'library_complaints' ? 'selected' : '' ?>>Library Complaints</option>
                </optgroup>
            </select>

            <label for="start_date">From:</label>
            <input type="date" name="start_date" id="start_date" value="<?= $startDate ?>" required>

            <label for="end_date">To:</label>
            <input type="date" name="end_date" id="end_date" value="<?= $endDate ?>" required>

            <button type="submit">View Report</button>
        </form>

        <?php include 'report_table.php'; ?>
    </div>
    <?php include 'footer.php'; ?>
</body>

</html>