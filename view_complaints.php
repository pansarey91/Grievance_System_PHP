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

// Fetch all complaints
$search = isset($_GET['search']) ? $_GET['search'] : '';
$filter_status = isset($_GET['filter_status']) ? $_GET['filter_status'] : '';

$query = "SELECT c.id, u.fullname, c.complaint, c.description, c.status, c.created_at, c.updated_at 
          FROM complaints c 
          JOIN users u ON c.user_id = u.id WHERE 1=1";

$params = [];

if ($search) {
    $query .= " AND (u.fullname LIKE :search OR c.description LIKE :search)";
    $params['search'] = "%$search%";
}

if ($filter_status) {
    $query .= " AND c.status = :status";
    $params['status'] = $filter_status;
}

$stmt = $conn->prepare($query);
$stmt->execute($params);
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

        th,
        td {
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
        <form method="GET" action="">
            <input type="text" style="margin-bottom: 20px; height: 30px" name="search" placeholder="Search complaints..." value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>">
            <select name="filter_status" style="margin-bottom: 20px; height: 40px">
                <option value="">All Status</option>
                <option value="Pending">Pending</option>
                <option value="In Progress">In Progress</option>
                <option value="Resolved">Resolved</option>
            </select>
            <button type="submit" style="margin-bottom: 20px; height: 40px; margin-left: 10px; width: 8%;">Filter</button>
        </form>

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
                            <td>
                                <?php
                                if ($complaint['status'] === 'Pending') {
                                    echo '<span class="status-badge pending">Pending</span>';
                                } elseif ($complaint['status'] === 'In Progress') {
                                    echo '<span class="status-badge progress">In Progress</span>';
                                } else {
                                    echo '<span class="status-badge resolved">Resolved</span>';
                                }
                                ?>
                            </td>

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