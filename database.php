<?php
try {
    $conn = new PDO("mysql:host=localhost;dbname=complaint_sys", "root", "root");
    // Set PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully"; 
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
