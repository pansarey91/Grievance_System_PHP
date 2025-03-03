<?php
session_start();
include 'database.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';


if (!isset($_SESSION['login_type']) || $_SESSION['login_type'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_POST['complaint_id']) && isset($_POST['status'])) {
    $complaint_id = $_POST['complaint_id'];
    $status = $_POST['status'];

    try {
        // Fetch user email
        $stmt = $conn->prepare("SELECT u.email, c.complaint FROM complaints c JOIN users u ON c.user_id = u.id WHERE c.id = :id");
        $stmt->execute(['id' => $complaint_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $user_email = $result['email'];
        $complaint_type = $result['complaint'];

        // Update the complaint status
        $stmt = $conn->prepare("UPDATE complaints SET status = :status WHERE id = :id");
        $stmt->execute(['status' => $status, 'id' => $complaint_id]);

        // Send Email Notification
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'virajpansare72@gmail.com';
            $mail->Password = 'bmdubpkkqhkpvvcn';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('virajpansare72@gmail.com', 'Complaint System');
            $mail->addAddress($user_email);

            $mail->isHTML(true);
            $mail->Subject = 'Complaint Status Updated';
            $mail->Body = "<p>Dear User,</p>
                <p>The status of your complaint regarding <strong>$complaint_type</strong> has been updated to <strong>$status</strong>.</p>
                <p>Thank you.</p>";

            $mail->send();
        } catch (Exception $e) {
            error_log("Email sending failed: " . $mail->ErrorInfo);
        }

        echo "<script>alert('Complaint status updated and email sent!'); window.location.href = 'admin_dashboard.php';</script>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
