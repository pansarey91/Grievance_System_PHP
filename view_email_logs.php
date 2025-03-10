<?php
session_start();
include 'database.php';

// Fetch email logs
$stmt = $conn->query("SELECT * FROM email_logs ORDER BY created_at DESC");
$email_logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Logs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        .container {
            width: 90%;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            overflow-x: auto;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            background: white;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
            word-wrap: break-word;
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

        .status-sent {
            color: green;
            font-weight: bold;
        }

        .status-failed {
            color: red;
            font-weight: bold;
        }

        .log-container {
            text-align: center;
            margin-top: 20px;
        }

        .back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }

        .back-btn:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h2>Email Notification Logs</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Recipient Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Error Message</th>
                    <th>Sent At</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($email_logs) > 0): ?>
                    <?php foreach ($email_logs as $log): ?>
                        <tr>
                            <td><?= $log['id'] ?></td>
                            <td><?= htmlspecialchars($log['recipient_email']) ?></td>
                            <td><?= htmlspecialchars($log['subject']) ?></td>
                            <td><?= nl2br($log['message']) ?></td>
                            <td class="<?= $log['status'] === 'Sent' ? 'status-sent' : 'status-failed' ?>">
                                <?= $log['status'] ?>
                            </td>
                            <td><?= $log['error_message'] ?: 'N/A' ?></td>
                            <td><?= $log['created_at'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No email logs found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="log-container">
        <a href="admin_dashboard.php" class="back-btn">Back to Dashboard</a>
    </div>

</body>

</html>