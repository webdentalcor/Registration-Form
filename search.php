<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
// --- search.php (ฉบับแก้ไขเรื่องการเปรียบเทียบวันที่) ---
require_once 'db_connect.php';

// กำหนดตัวแปรสำหรับเก็บค่าค้นหาและผลลัพธ์
$search_term = $_GET['search_term'] ?? '';
$reg_date = $_GET['submission_date'] ?? '';
$patients = [];

// ถ้ามีการส่งค่าค้นหามา
if (!empty($search_term) || !empty($reg_date)) {
    // เริ่มสร้าง query
    $sql = "SELECT id, title, first_name, surname, email, passport_id, submission_date FROM patients WHERE 1=1";
    $params = [];

    // เพิ่มเงื่อนไขสำหรับ search term (ชื่อ, email, passport)
    if (!empty($search_term)) {
        $sql .= " AND (first_name LIKE :term OR surname LIKE :term OR email LIKE :term OR passport_id LIKE :term)";
        $params[':term'] = "%" . $search_term . "%";
    }

    // --- START: ส่วนแก้ไขการค้นหาด้วยวันที่ ---
    if (!empty($reg_date)) {
        // สร้างเงื่อนไขให้ค้นหาข้อมูล "ทั้งวัน" ของวันที่ที่เลือก
        $sql .= " AND submission_date >= :start_date AND submission_date < :end_date";

        // กำหนดค่าวันที่เริ่มต้น (เวลา 00:00:00)
        $params[':start_date'] = $reg_date . " 00:00:00";

        // กำหนดค่าวันที่สิ้นสุด (คือวันถัดไป เวลา 00:00:00)
        $date = new DateTime($reg_date);
        $date->modify('+1 day');
        $params[':end_date'] = $date->format('Y-m-d') . " 00:00:00";
    }
    // --- END: ส่วนแก้ไข ---

    $sql .= " ORDER BY submission_date DESC";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // แสดงข้อผิดพลาดถ้า query ไม่สำเร็จ (เพื่อช่วยดีบัก)
        die("Database query failed: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Patients</title>
    <!-- CSS styles are the same, no changes needed here -->
    <style>
        body { font-family: sans-serif; background-color: #f4f7f9; margin: 20px; }
        .container { max-width: 1200px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1, h2 { color: #005a9c; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px 15px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #007bff; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        tr:hover { background-color: #ddd; }
        .nav-links { margin-bottom: 20px; }
        .nav-links a { margin-right: 15px; font-size: 1.1em; }
        .search-form { background-color: #f8f9fa; padding: 20px; border-radius: 5px; margin-bottom: 20px; display: flex; gap: 15px; align-items: flex-end; flex-wrap: wrap; }
        .form-group { display: flex; flex-direction: column; }
        .form-group label { margin-bottom: 5px; font-weight: bold; }
        .form-group input { padding: 10px; border-radius: 4px; border: 1px solid #ccc; font-size: 1em; }
        .form-group button { padding: 10px 20px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 1em; }
        .form-group button:hover { background-color: #218838; }
        .no-results { text-align: center; padding: 20px; font-style: italic; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Search Patient Records</h1>
        <div class="nav-links">
            <a href="index.php">New Registration</a>
            <a href="view-patients.php">View All Patients</a>
        </div>

        <!-- Search Form (No changes needed here) -->
        <form action="search.php" method="GET" class="search-form">
            <div class="form-group">
                <label for="search_term">Name, Email, or Passport/ID</label>
                <input type="text" id="search_term" name="search_term" value="<?php echo htmlspecialchars($search_term); ?>" placeholder="Enter search term...">
            </div>
            <div class="form-group">
                <label for="submission_date">Registration Date</label>
                <input type="date" id="submission_date" name="submission_date" value="<?php echo htmlspecialchars($reg_date); ?>">
            </div>
            <div class="form-group">
                <button type="submit">Search</button>
            </div>
        </form>

        <!-- Search Results (No changes needed here) -->
        <h2>Search Results</h2>
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
                <?php if (!empty($patients)): ?>
                    <?php foreach($patients as $row): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['title'] . ' ' . $row['first_name'] . ' ' . $row['surname']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['passport_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['submission_date']); ?></td>
                            <td>
                                <a href="generate_pdf.php?id=<?php echo $row['id']; ?>" target="_blank" style="text-decoration: none; background-color: #dc3545; color: white; padding: 5px 10px; border-radius: 4px;">
                                    Print PDF
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="no-results">
                            <?php if ($_SERVER['REQUEST_METHOD'] === 'GET' && (isset($_GET['search_term']) || isset($_GET['submission_date'])) && (trim($search_term) !== '' || trim($reg_date) !== '') ): ?>
                                No patients found matching your criteria.
                            <?php else: ?>
                                Please enter search criteria above.
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php
// ปิดการเชื่อมต่อ
unset($conn);
?>
