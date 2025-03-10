<?php
session_start();
include 'database.php';

if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['login_type'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $login_type = $_POST['login_type'];

    try {
        // Prepare the SQL statement
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email AND account_type = :login_type");
        $stmt->execute(['email' => $email, 'login_type' => $login_type]);

        // Fetch the user data
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        echo $user;

        if ($user) {
            // Verify the password
            if (password_verify($password, $user['password_hash'])) {
                $_SESSION['email'] = $email;
                $_SESSION['fullname'] = $user['fullname'];
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['login_type'] = $login_type;

                // Redirect based on login type
                if ($login_type === 'admin') {
                    header("Location: admin_dashboard.php");
                } elseif ($login_type === 'student') {
                    header("Location: student_dashboard.php");
                }
                exit();
            } else {
                echo "<script>alert('Invalid Email or password.'); window.location.href = 'login.html';</script>";
            }
        } else {
            echo "<script>alert('No account found for the given email and login type.'); window.location.href = 'login.html';</script>";
        }
    } catch (PDOException $e) {
        // echo "Database error: " . $e->getMessage();
        echo "<script>alert('Database error: " . $e->getMessage() . "'); window.location.href = 'login.html';</script>";
    }
} else {
    echo "All fields are required.";
}
