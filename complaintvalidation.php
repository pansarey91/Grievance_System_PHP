<?php
session_start();
include 'database.php';

// Check if form data is submitted
if (isset($_POST['complaint']) && isset($_POST['description'])) {
    $complaint = trim($_POST['complaint']);
    $description = trim($_POST['description']);

    try {
        // Prepare and execute the SQL query using prepared statements
        $stmt = $conn->prepare("INSERT INTO complaints (user_id, complaint, description) VALUES (:user_id, :complaint, :description)");
        $stmt->execute([
            'user_id' => $_SESSION['user_id'],
            'complaint' => $complaint,
            'description' => $description
        ]);

        // Redirect to a success page or dashboard
        echo "<script>alert('Complaint submitted successfully!'); window.location.href = 'student_dashboard.php';</script>";
    } catch (PDOException $e) {
        // Handle database errors
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request. Please fill in all the fields.";
}
?>
