<?php
$conn = new PDO("mysql:host=localhost;dbname=complaint_sys", "root", "root");

if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
}
