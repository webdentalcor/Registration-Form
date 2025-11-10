<?php
// --- DATABASE CONNECTION ---
$servername = "localhost"; // หรือ 127.0.0.1
$username = "ueo2rskhfkbxz"; // Username ของ XAMPP MySQL โดยปกติคือ root
$password = "1@+{&62m1#1h"; // Password ของ XAMPP MySQL โดยปกติคือว่าง
$dbname = "dbugrz2fjn1g7z"; // ชื่อฐานข้อมูลที่คุณสร้าง

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    // ตั้งค่า PDO error mode เป็น exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
