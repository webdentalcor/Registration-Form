<?php
// เปิดการแสดงผลข้อผิดพลาด
ini_set('display_errors', 1); error_reporting(E_ALL);

// เรียกใช้ไฟล์ที่จำเป็น
require_once __DIR__ . '/vendor/autoload.php';
require_once 'db_connect.php';

// Import classes
use Mpdf\Mpdf;
use Mpdf\Config\ConfigVariables;

// 1. ดึงข้อมูลคนไข้
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) die("Invalid Patient ID.");
$patient_id = intval($_GET['id']);
$patient = null;
try {
    $sql = "SELECT * FROM patients WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $patient_id, PDO::PARAM_INT);
    $stmt->execute();
    $patient = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$patient) die("Patient with ID {$patient_id} not found.");
} catch (PDOException $e) { die("Database query failed: ". $e->getMessage()); }


// ===================================================================
// ส่วน HTML และ CSS ฉบับใหม่ (อ้างอิงจากโค้ดตัวอย่าง)
// ===================================================================
$html = '
<html>
<head>
<style>
    body { font-family: "prompt", sans-serif; font-size: 9pt; color: #333; }
    .main-table { width: 100%; border-collapse: collapse; }
    .main-table td { padding: 5px; }

    /* --- สไตล์สำหรับ Input ที่จะแสดงผล --- */
    .value-box {
        border: 1px solid #ccc;
        padding: 3px 5px;
        min-height: 18px;
        background-color: #f8f8f8;
    }
    .value-line {
        border-bottom: 1px dotted #555;
        padding: 3px 5px;
        min-height: 18px;
    }

    /* --- สไตล์สำหรับ Header --- */
    .header-left { background-color: #fff; text-align: left; }
    .header-right { background-color: #fff; text-align: center; }
    .header-logo { max-width: 220px; }
    .section-title { font-size: 11pt; font-weight: bold; background-color: #e0e7f1; padding: 6px; }

</style>
</head>
<body>
<table class="main-table">
        <!-- Header -->
        <tr>
            <td width="20%" align="center">
            <img src="https://register.dentalhospitalthailand.com/images/Logo-Dental-Hospital-BIDH.png" alt="BIDC Logo" class="header-logo" style="max-height: 90px;" ><br>
                <span style="font-size:6pt;">QF-CR 001:003(07/19)_EN</span>
            </td>
            <td width="60%" align="center">
                <h2 style="margin:0;">New Patient Registration Form</h2>
            </td>
            <td width="20%" align="center">
                <h2 style="margin:0;">HN.....................&nbsp;</h2>
            </td>

          </tr>

        <tr><td colspan="3"><hr></td></tr>
          <tr><td colspan="3">
              <b>Dear Sir/Madam,</b><br>
              Welcome to Bangkok International Dental Hospital. As a new patient, we need you to answer a few questions in order for us to serve you more effectively. If possible, please complete all fields. At a minimum, please fill in the mandatory fields marked with an asterisk (*). We need this information to provide the quality of service you deserve.
          </td></tr>
        <tr><td colspan="3"><hr></td></tr>

    <!-- Personal Information -->
        <tr><td colspan="3" class="section-title">Personal Information</td></tr>
        <tr>
            <td colspan="2">
                <!-- ใช้ <input type="radio"> และ checked property -->
                <input type="radio" name="title" ' . (($patient['title'] ?? '') == 'Mr.' ? 'checked' : '') . '> Mr.
                <input type="radio" name="title" ' . (($patient['title'] ?? '') == 'Master' ? 'checked' : '') . '> Master
                <input type="radio" name="title" ' . (($patient['title'] ?? '') == 'Mrs.' ? 'checked' : '') . '> Mrs.
                <input type="radio" name="title" ' . (($patient['title'] ?? '') == 'Ms.' ? 'checked' : '') . '> Ms.
                <input type="radio" name="title" ' . (($patient['title'] ?? '') == 'Others' ? 'checked' : '') . '> Others
                <span class="value-line" style="min-width: 150px;">' . htmlspecialchars($patient['title_other'] ?? '&nbsp;') . '</span>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <table width="100%">
                    <tr>
                        <td width="33%">First name*: <div class="value-line">' . htmlspecialchars($patient['first_name'] ?? '&nbsp;') . '</div></td>
                        <td width="33%">Middle name: <div class="value-line">' . htmlspecialchars($patient['middle_name'] ?? '&nbsp;') . '</div></td>
                        <td width="33%">Surname*: <div class="value-line">' . htmlspecialchars($patient['surname'] ?? '&nbsp;') . '</div></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <table width="100%">
                    <tr>
                        <td width="40%">
                            Gender*:
                            <input type="radio" name="gender" ' . (($patient['gender'] ?? '') == 'Male' ? 'checked' : '') . '> Male
                            <input type="radio" name="gender" ' . (($patient['gender'] ?? '') == 'Female' ? 'checked' : '') . '> Female
                            <input type="radio" name="gender" ' . (($patient['gender'] ?? '') == 'Not Specify' ? 'checked' : '') . '> Not Specify
                        </td>
                        <td width="35%">*Date of Birth: <div class="value-line">' . htmlspecialchars($patient['dob'] ?? '&nbsp;') . '</div></td>
                        <td width="25%">Age: <div class="value-line">' . htmlspecialchars($patient['age'] ?? '&nbsp;') . '</div> Yrs.</td>
                    </tr>
                </table>
            </td>
        </tr>
        <!-- สร้างส่วนที่เหลือต่อไปตามหลักการนี้ -->
    </table>
</body>
</html>
';

// 3. สร้าง PDF Object และแสดงผล
$defaultConfig = (new ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];
$mpdf = new Mpdf([
    'mode' => 'utf-8',
    'format' => 'A4',
    'fontDir' => array_merge($fontDirs, [__DIR__ . '/fonts']),
    'fontdata' => ['prompt' => ['R' => 'Prompt-Regular.ttf', 'B' => 'Prompt-Bold.ttf']],
    'default_font' => 'prompt',
    // เพิ่มการตั้งค่าเพื่อให้รองรับ Form elements
    'allow_html_form_tags' => true
]);

// เขียน HTML และแสดงผล
$mpdf->WriteHTML($html);
$mpdf->Output('Patient-Form-'.$patient_id.'.pdf', 'I');
exit;
?>
