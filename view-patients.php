<?php
// --- view_patients.php (ฉบับแก้ไข) ---
require_once 'db_connect.php'; // เรียกใช้ไฟล์เชื่อมต่อ

// ดึงข้อมูลคนไข้ทั้งหมด เรียงจากล่าสุดไปเก่าสุด
// ให้แน่ใจว่าชื่อคอลัมน์ submission_date ถูกต้องตามฐานข้อมูลของคุณ
$sql = "SELECT id, title, first_name, surname, email, passport_id, submission_date FROM patients ORDER BY submission_date DESC";

try {
    // --- FIX 1: เปลี่ยน $pdo เป็น $conn ---
    $stmt = $conn->query($sql);
} catch (PDOException $e) {
    die("Database query failed: " . $e->getMessage());
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Patient Registrations</title>
    <style>
        body { font-family: sans-serif; background-color: #f4f7f9; margin: 20px; }
        .container { max-width: 1200px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #005a9c; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px 15px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #007bff; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        tr:hover { background-color: #ddd; }
        .nav-links { margin-bottom: 20px; }
        .nav-links a { margin-right: 15px; font-size: 1.1em; color: #007bff; text-decoration: none; }
        .nav-links a:hover { text-decoration: underline; }
        

    </style>
</head>
<body>
    <div class="container">
        <h1>All Patient Registrations</h1>
        <div class="nav-links">
            <a href="index.php">New Registration</a>
            <a href="search.php">Search Patients</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Passport/ID No.</th>
                    <th>Registration Time</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($stmt->rowCount() > 0): ?>
                    <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['title'] . ' ' . $row['first_name'] . ' ' . $row['surname']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['passport_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['submission_date']); ?></td>
                            <!-- VVV เพิ่มคอลัมน์นี้ VVV -->
                            <td>
                                <a href="generate_pdf.php?id=<?php echo $row['id']; ?>" target="_blank" style="text-decoration: none; background-color: #dc3545; color: white; padding: 5px 10px; border-radius: 4px;">
                                    Print PDF
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align:center;">No patients found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php
// --- FIX 2: เปลี่ยน $pdo เป็น $conn ---
// ปิดการเชื่อมต่อ
unset($stmt);
unset($conn);
?>
