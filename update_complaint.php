<?php
session_start();
include 'database.php';

// Check if the admin is logged in
if (!isset($_SESSION['login_type']) || $_SESSION['login_type'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_POST['complaint_id']) && isset($_POST['status'])) {
    $complaint_id = $_POST['complaint_id'];
    $status = $_POST['status'];

    try {
        // Update the complaint status
        $stmt = $conn->prepare("UPDATE complaints SET status = :status WHERE id = :id");
        $stmt->execute(['status' => $status, 'id' => $complaint_id]);

        echo "<script>alert('Complaint status updated successfully!'); window.location.href = 'admin_dashboard.php';</script>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>
