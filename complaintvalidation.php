<?php
session_start();
include 'database.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if (isset($_POST['complaint']) && isset($_POST['description'])) {
    $complaint = trim($_POST['complaint']);
    $description = trim($_POST['description']);
    $user_email = $_SESSION['email'];

    try {
        // Insert complaint into the database
        $stmt = $conn->prepare("INSERT INTO complaints (user_id, complaint, description) VALUES (:user_id, :complaint, :description)");
        $stmt->execute([
            'user_id' => $_SESSION['user_id'],
            'complaint' => $complaint,
            'description' => $description
        ]);

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

            $mail->setFrom('your_email@gmail.com', 'Complaint System');
            $mail->addAddress($user_email);
            $mail->isHTML(true);
            $mail->Subject = 'Complaint Submitted Successfully';
            $mail->Body = "<p>Your complaint regarding <strong>$complaint</strong> has been submitted successfully.</p>";

            if ($mail->send()) {
                $status = 'Sent';
                $error_message = NULL;
            } else {
                $status = 'Failed';
                $error_message = $mail->ErrorInfo;
            }
        } catch (Exception $e) {
            $status = 'Failed';
            $error_message = $mail->ErrorInfo;
        }

        // Log email notification in database
        $logStmt = $conn->prepare("INSERT INTO email_logs (recipient_email, subject, message, status, error_message) VALUES (:email, :subject, :message, :status, :error)");
        $logStmt->execute([
            'email' => $user_email,
            'subject' => 'Complaint Submitted Successfully',
            'message' => $mail->Body,
            'status' => $status,
            'error' => $error_message
        ]);

        echo "<script>alert('Complaint submitted successfully! Email log updated.'); window.location.href = 'student_dashboard.php';</script>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
