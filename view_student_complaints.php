<?php
session_start();
include 'database.php';

// Check if the student is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['login_type'] !== 'student') {
    header("Location: login.html");
    exit();
}

// Fetch student complaints with updated_at column
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT id, complaint, description, status, created_at, updated_at FROM complaints WHERE user_id = :user_id");
$stmt->execute(['user_id' => $user_id]);
$complaints = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View My Complaints</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>

<?php include 'studheader.php'; ?>

<div class="container">
    <h2>My Complaints</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Description</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Updated At</th> <!-- Added Updated At Column -->
            </tr>
        </thead>
        <tbody>
            <?php if (count($complaints) > 0): ?>
                <?php foreach ($complaints as $complaint): ?>
                    <tr>
                        <td><?= $complaint['id'] ?></td>
                        <td><?= ucfirst($complaint['complaint']) ?></td>
                        <td><?= $complaint['description'] ?></td>
                        <td><?= $complaint['status'] ?></td>
                        <td><?= $complaint['created_at'] ?></td>
                        <td><?= $complaint['updated_at'] ?></td> <!-- Display Updated At -->
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6">No complaints found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include 'studfooter.php'; ?>

</body>
</html>
