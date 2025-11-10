<?php
// ===================================================================
// ส่วนที่ 1: การตั้งค่าเริ่มต้น
// ===================================================================

// เปิดการแสดงผลข้อผิดพลาดเพื่อการดีบัก
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// เรียกใช้ไฟล์เชื่อมต่อฐานข้อมูลเท่านั้น
require_once 'db_connect.php';

// ===================================================================
// ส่วนที่ 2: ประกาศฟังก์ชัน Helper
// ===================================================================

function get_post($key) {
    return isset($_POST[$key]) ? trim($_POST[$key]) : null;
}

function get_checkbox_group($name) {
    return isset($_POST[$name]) && is_array($_POST[$name]) ? implode(', ', $_POST[$name]) : null;
}

// ===================================================================
// ส่วนที่ 3: ตรวจสอบ Request Method และเริ่มทำงาน
// ===================================================================

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("location: index.php");
    exit();
}

// ===================================================================
// ส่วนที่ 4: รับค่าจากฟอร์มและเก็บใส่ตัวแปร
// ===================================================================

$patientData = [
    'hn_number' => get_post('hn_number'),
    'title' => get_post('title'),
    'title_other' => get_post('title_other'),
    'first_name' => get_post('first_name'),
    'middle_name' => get_post('middle_name'),
    'surname' => get_post('surname'),
    'gender' => get_post('gender'),
    'dob' => get_post('dob'),
    'age' => get_post('age'),
    'passport_id' => get_post('passport_id'),
    'primary_language' => get_post('primary_language'),
    'nationality' => get_post('nationality'),
    'patient_section' => get_checkbox_group('patient_section'),
    'patient_residence' => get_post('patient_residence'),
    'religion' => get_checkbox_group('religion'),
    'religion_other' => get_post('religion_other'),
    'claim' => get_checkbox_group('claim'),
    'claim_other' => get_post('claim_other'),
    'address_street' => get_post('address_street'),
    'address_city' => get_post('address_city'),
    'address_country' => get_post('address_country'),
    'address_postal' => get_post('address_postal'),
    'tel_home' => get_post('tel_home'),
    'tel_mobile' => get_post('tel_mobile'),
    'address_thailand' => get_post('address_thailand'),
    'tel_thailand' => get_post('tel_thailand'),
    'mobile_thailand' => get_post('mobile_thailand'),
    'email' => get_post('email'),
    'emergency_contact_name' => get_post('emergency_contact_name'),
    'emergency_contact_tel' => get_post('emergency_contact_tel'),
    'emergency_contact_relation' => get_post('emergency_contact_relation'),
    'med_underlying_conditions' => get_post('med_underlying_conditions'),
    'med_cerebrovascular' => get_post('med_cerebrovascular'),
    'med_hypothyroidism' => get_post('med_hypothyroidism'),
    'med_hyperthyroidism' => get_post('med_hyperthyroidism'),
    'med_tuberculosis' => get_post('med_tuberculosis'),
    'med_asthma' => get_post('med_asthma'),
    'med_rheumatoid' => get_post('med_rheumatoid'),
    'med_lupus' => get_post('med_lupus'),
    'med_epilepsy' => get_post('med_epilepsy'),
    'med_renal' => get_post('med_renal'),
    'med_hypertension' => get_post('med_hypertension'),
    'med_lung_disease' => get_post('med_lung_disease'),
    'med_lung_disease_specify' => get_post('med_lung_disease_specify'),
    'med_heart_disease' => get_post('med_heart_disease'),
    'med_heart_disease_specify' => get_post('med_heart_disease_specify'),
    'med_bleeding_disorder' => get_post('med_bleeding_disorder'),
    'med_bleeding_disorder_specify' => get_post('med_bleeding_disorder_specify'),
    'med_hepatitis' => get_post('med_hepatitis'),
    'med_hepatitis_specify' => get_post('med_hepatitis_specify'),
    'med_diabetes' => get_post('med_diabetes'),
    'med_diabetes_dm' => get_checkbox_group('med_diabetes_dm'),
    'med_diabetes_glucose' => get_checkbox_group('med_diabetes_glucose'),
    'med_diabetes_specify' => get_post('med_diabetes_specify'),
    'med_other_condition' => get_post('med_other_condition'),
    'med_current_medication' => get_post('med_current_medication'),
    'med_current_medication_specify' => get_post('med_current_medication_specify'),
    'med_allergy' => get_post('med_allergy'),
    'med_allergy_specify' => get_post('med_allergy_specify'),
    'med_pregnancy' => get_post('med_pregnancy'),
    'med_pregnancy_specify' => get_post('med_pregnancy_specify'),
    'med_past_dental_exp' => get_post('med_past_dental_exp'),
    'med_past_anesthesia_exp' => get_post('med_past_anesthesia_exp'),
    'med_dental_anxiety' => get_post('med_dental_anxiety'),
    'req_purpose' => get_checkbox_group('req_purpose'),
    'req_purpose_specify' => get_post('req_purpose_specify'),
    'req_chief_complaint' => get_post('req_chief_complaint'),
    'req_doctor_request' => get_post('req_doctor_request'),
    'how_learn_about_us' => get_checkbox_group('how_learn_about_us'),
    'how_learn_recommended' => get_checkbox_group('how_learn_recommended'),
    'how_learn_recommended_specify' => get_post('how_learn_recommended_specify'),
    'how_learn_other' => get_checkbox_group('how_learn_other'),
    'how_learn_specify' => get_post('how_learn_specify')
];

// ===================================================================
// ส่วนที่ 5: บันทึกข้อมูลลงฐานข้อมูล
// ===================================================================

$last_id = null;

try {
    // --- เตรียม SQL และ Bind Parameters ---
    $sql = "INSERT INTO patients (hn_number, title, title_other, first_name, middle_name, surname, gender, dob, age, passport_id,
    primary_language, nationality, patient_section, patient_residence, religion, religion_other, claim, claim_other,
    address_street, address_city, address_country, address_postal, tel_home, tel_mobile,
    address_thailand, tel_thailand, mobile_thailand, email, emergency_contact_name, emergency_contact_tel, emergency_contact_relation,
    med_underlying_conditions, med_cerebrovascular, med_hypothyroidism, med_hyperthyroidism, med_tuberculosis, med_asthma, med_rheumatoid, med_lupus, med_epilepsy, med_renal, med_hypertension, med_lung_disease, med_lung_disease_specify, med_heart_disease, med_heart_disease_specify, med_bleeding_disorder, med_bleeding_disorder_specify,
    med_hepatitis, med_hepatitis_specify, med_diabetes, med_diabetes_dm, med_diabetes_glucose, med_diabetes_specify, med_other_condition, med_current_medication, med_current_medication_specify, med_allergy, med_allergy_specify, med_pregnancy, med_pregnancy_specify, med_past_dental_exp, med_past_anesthesia_exp, med_dental_anxiety,
    req_purpose, req_purpose_specify, req_chief_complaint, req_doctor_request, how_learn_about_us, how_learn_other, how_learn_specify, how_learn_recommended, how_learn_recommended_specify)
            VALUES (:hn_number, :title, :title_other, :first_name, :middle_name, :surname, :gender, :dob, :age, :passport_id,
            :primary_language, :nationality, :patient_section, :patient_residence, :religion, :religion_other, :claim, :claim_other,
            :address_street, :address_city, :address_country, :address_postal, :tel_home, :tel_mobile,
            :address_thailand, :tel_thailand, :mobile_thailand, :email, :emergency_contact_name, :emergency_contact_tel, :emergency_contact_relation,
            :med_underlying_conditions, :med_cerebrovascular, :med_hypothyroidism, :med_hyperthyroidism, :med_tuberculosis, :med_asthma, :med_rheumatoid, :med_lupus, :med_epilepsy, :med_renal, :med_hypertension, :med_lung_disease, :med_lung_disease_specify, :med_heart_disease, :med_heart_disease_specify, :med_bleeding_disorder, :med_bleeding_disorder_specify,
            :med_hepatitis, :med_hepatitis_specify, :med_diabetes, :med_diabetes_dm, :med_diabetes_glucose, :med_diabetes_specify, :med_other_condition, :med_current_medication, :med_current_medication_specify, :med_allergy, :med_allergy_specify, :med_pregnancy, :med_pregnancy_specify, :med_past_dental_exp, :med_past_anesthesia_exp, :med_dental_anxiety,
            :req_purpose, :req_purpose_specify, :req_chief_complaint, :req_doctor_request, :how_learn_about_us, :how_learn_other, :how_learn_specify, :how_learn_recommended, :how_learn_recommended_specify)";

    $stmt = $conn->prepare($sql);

    // Bind ทุกค่าจาก Array $patientData
    foreach ($patientData as $key => &$value) {
        $stmt->bindParam(':' . $key, $value);
    }

    // --- Execute DB Query ---
    $stmt->execute();
    $last_id = $conn->lastInsertId();

    // --- กำหนดข้อความสำหรับหน้าจอ Success ---
    $status_title = "Registration Successful!";
    $status_message = "Thank you, your information has been saved successfully.";
    $status_class = "success-box";

} catch (PDOException $e) {
    // --- กำหนดข้อความสำหรับหน้าจอ Error ---
    $status_title = "Registration Failed!";
    $status_message = "Database Error: " . $e->getMessage();
    $status_class = "error-box";
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn = null;

// ===================================================================
// ส่วนที่ 6: แสดงผลหน้าจอ
// ===================================================================
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($status_title); ?></title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f4f7f9;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            max-width: 600px;
            width: 90%;
            margin: auto;
            background: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            text-align: center;
        }
        .status-icon {
            font-size: 5rem;
            line-height: 1;
            margin-bottom: 20px;
        }
        .success-box .status-icon {
            color: #28a745;
        }
        .error-box .status-icon {
            color: #dc3545;
        }
        h1 {
            color: #333;
            margin-bottom: 10px;
        }
        p {
            color: #666;
            font-size: 1.1rem;
            margin-bottom: 30px;
        }
        .actions a {
            display: inline-block;
            margin: 10px;
            padding: 12px 25px;
            text-decoration: none;
            color: #fff;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.2s;
        }
        .actions a:hover {
            transform: translateY(-2px);
        }
        .btn-primary { background-color: #007bff; }
        .btn-primary:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <div class="container <?php echo $status_class; ?>">
        <?php if ($status_class === 'success-box'): ?>
            <div class="status-icon"><svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960" width="48px" fill="#48752C"><path d="M633-80 472-241l43-43 118 118 244-244 43 43L633-80ZM478-527l334-213H144l334 213Zm0 60L140-684v452h256l60 60H140q-24 0-42-18t-18-42v-508q0-24 18-42t42-18h677q24 0 42 18t18 42v244l-60 60v-248L478-467Zm1 9Zm-1-69Zm1 60Z"/></svg></div>
        <?php else: ?>
            <div class="status-icon"><svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960" width="48px" fill="#8C1A10"><path d="M480-440 160-640v400h320q0 21 3 40.5t9 39.5H160q-33 0-56.5-23.5T80-240v-480q0-33 23.5-56.5T160-800h640q33 0 56.5 23.5T880-720v228q-18-9-38.5-15t-41.5-9v-124L480-440Zm0-80 320-200H160l320 200ZM760-40q-83 0-141.5-58.5T560-240q0-83 58.5-141.5T760-440q83 0 141.5 58.5T960-240q0 83-58.5 141.5T760-40ZM640-220h240v-40H640v40Zm-480-20v-480 480Z"/></svg></div>
        <?php endif; ?>

        <h1><?php echo htmlspecialchars($status_title); ?></h1>
        <p><?php echo htmlspecialchars($status_message); ?></p>

        <div class="actions">
            <?php if ($last_id): ?>
                <a href="https://dentalhospitalthailand.com/" target="_blank"  class="btn-primary">Back to BIDH Website</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
