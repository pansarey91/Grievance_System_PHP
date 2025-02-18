<?php
session_start();
include 'database.php';

// Check if the admin is logged in
if (!isset($_SESSION['login_type']) || $_SESSION['login_type'] !== 'admin') {
    header("Location: login.html");
    exit();
}

// Fetch all complaints
$stmt = $conn->query("SELECT c.id, u.fullname, c.complaint, c.description, c.status, c.created_at , c.updated_at
                      FROM complaints c 
                      JOIN users u ON c.user_id = u.id");
$complaints = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Complaints</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .table-container {
            width: 90%;
            margin: 0 auto;
            overflow-x: auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            text-align: center;
            padding: 12px 15px;
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

        select {
            padding: 5px 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        button.delete-btn {
            background-color: #dc3545;
        }

        button:hover {
            opacity: 0.9;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <h1>Complaint Management</h1>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($complaints) > 0): ?>
                    <?php foreach ($complaints as $complaint): ?>
                        <tr>
                            <td><?= $complaint['id'] ?></td>
                            <td><?= $complaint['fullname'] ?></td>
                            <td><?= ucfirst($complaint['complaint']) ?></td>
                            <td><?= $complaint['description'] ?></td>
                            <td><?= $complaint['status'] ?></td>
                            <td><?= $complaint['created_at'] ?></td>
                            <td><?= $complaint['updated_at'] ?></td>
                            <td>
                                <!-- Update Status Form -->
                                <form method="post" action="update_complaint.php" style="display: inline;">
                                    <input type="hidden" name="complaint_id" value="<?= $complaint['id'] ?>">
                                    <select name="status">
                                        <option value="Pending" <?= $complaint['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                                        <option value="In Progress" <?= $complaint['status'] === 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                                        <option value="Resolved" <?= $complaint['status'] === 'Resolved' ? 'selected' : '' ?>>Resolved</option>
                                    </select><br>
                                    <button type="submit">Update</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No complaints found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
   <?php include 'footer.php'; ?>
</body>
</html>
