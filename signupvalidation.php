<?php
session_start();
include 'database.php';

if (isset($_POST['fullname']) && isset($_POST['class']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm_password']) && isset($_POST['signup_type'])) {
    $fullname = trim($_POST['fullname']);
    $class = trim($_POST['class']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $signup_type = $_POST['signup_type'];

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format.'); window.location.href = 'signup.html';</script>";
        exit();
    }

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match.'); window.location.href = 'signup.html';</script>";
        exit();
    }

    // Check if email is already registered
    $stmt = $conn->prepare("SELECT email FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    if ($stmt->rowCount() > 0) {
        echo "<script>alert('Email already registered.'); window.location.href = 'signup.html';</script>";
        exit();
    }

    // Insert the user into the database
    try {
        $stmt = $conn->prepare("INSERT INTO users (fullname, class, email, password_hash, account_type) VALUES (:fullname, :class, :email, :password_hash, :account_type)");
        $stmt->execute([
            'fullname' => $fullname,
            'class' => $class,
            'email' => $email,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'account_type' => $signup_type
        ]);

        // Start a session and redirect based on signup type
        $_SESSION['email'] = $email;
        $_SESSION['login_type'] = $signup_type;
        $_SESSION['fullname'] = $fullname;
        session_regenerate_id(true);

        if ($signup_type === 'admin') {
            header("Location: login.html");
        } elseif ($signup_type === 'student') {
            header("Location: login.html");
        }
        exit();
    } catch (PDOException $e) {
        echo "<script>alert('Database error: " . $e->getMessage() . "'); window.location.href = 'signup.html';</script>";
        exit();
    }
} else {
    echo "<script>alert('All fields are required.'); window.location.href = 'signup.html';</script>";
}
?>
