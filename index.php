<?php
// --- view_patients.php ---
require_once 'db_connect.php';

// ดึงข้อมูลคนไข้ทั้งหมด เรียงจากล่าสุดไปเก่าสุด
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Patient Registration Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
      <form action="process_form.php" method="post" id="patientForm">
          <header class="form-header">
              <div class="logo">
                  <!-- add logo -->
                  <img src="https://register.dentalhospitalthailand.com/images/Logo-Dental-Hospital-BIDH.webp" alt="BIDC Logo" style="max-height: 90px;" align="center">
              </div>
              <div class="form-title">
                  <h1>New Patient Registration Form</h1>
              </div>
              <div class="logo">
            </div>

          </header>

          <h4>Dear Sir/Madam,</h4>
          <p class="intro-text">
              Welcome to Bangkok International Dental Hospital. As a new patient, we need you to answer a few questions in order for us to serve you more effectively.  If possible, please complete all fields. At a minimum, please fill in the mandatory fields marked with an asterisk (*). We need this information to provide the quality of service you deserve.
          </p>

          <!-- ======================= Personal Information ======================= -->
          <fieldset>
              <legend>Personal Information</legend>
              <div class="row">
                  <div class="form-group radio-group">

                      <input type="radio" id="title_mr" name="title" value="Mr." required=""><label for="title_mr">Mr.</label>
                      <input type="radio" id="title_master" name="title" value="Master"><label for="title_master">Master</label>
                      <input type="radio" id="title_mrs" name="title" value="Mrs."><label for="title_mrs">Mrs.</label>
                      <input type="radio" id="title_ms" name="title" value="Ms."><label for="title_ms">Ms.</label>
                      <input type="radio" id="title_other" name="title" value="Other"><label for="title_other">Others</label>

                  </div>
              <div class="form-group" style="flex: 2;">
                      <input type="text" id="title_other" name="title_other" placeholder="others...">
                  </div></div>
              <div class="row">
                  <div class="form-group"><label for="first_name">First name*</label><input type="text" id="first_name" name="first_name" placeholder="first name" required=""></div>
                  <div class="form-group"><label for="middle_name">Middle name</label><input type="text" id="middle_name" name="middle_name" placeholder="middle name"></div>
                  <div class="form-group"><label for="surname">Surname*</label><input type="text" id="surname" name="surname" placeholder="surname" required=""></div>
              </div>
              <div class="row">
                 <div class="form-group radio-group">
                     <label>Gender*</label>
                     <input type="radio" id="gender_male" name="gender" value="Male" required=""><label for="gender_male">Male</label>
                 <input type="radio" id="gender_female" name="gender" value="Female"><label for="gender_female">Female</label><input type="radio" id="gender_not" name="gender" value="Not Specify"><label for="gender_not">Not Specify</label></div>
                 <div class="form-group"><label for="dob">Date of Birth*</label><input type="date" id="dob" name="dob" required=""></div>
                 <div class="form-group"><label for="age">Age</label><input type="number" id="age" name="age" placeholder="age" style="width: 150px;"></div>
             </div>
              <div class="row">
                  <div class="form-group"><label for="passport_id">Passport or I.D. No.</label><input type="text" id="passport_id" name="passport_id" placeholder="passport or I.D. No."></div>
                  <div class="form-group"><label for="primary_language">Primary Language*</label><input type="text" id="primary_language" name="primary_language" placeholder="primary language" required=""></div>
                  <div class="form-group"><label for="nationality">Nationality*</label><input type="text" id="nationality" name="nationality" placeholder="nationality" required=""></div>
              </div>
              <div class="row">
                  <div class="form-group checkbox-group">
                      <label>Patient Section</label>
                      <input type="checkbox" id="ps_expat" name="patient_section[]" value="Expat"><label for="ps_expat">Expat</label>
                      <input type="checkbox" id="ps_flyin" name="patient_section[]" value="Fly-in"><label for="ps_flyin">Fly-in</label>
                  </div>
                  <div class="form-group"><label for="patient_residence">Country of Residence</label><input type="text" id="patient_residence" name="patient_residence" placeholder="country of residence"></div>
              </div>
              <div class="row">
                   <div class="form-group checkbox-group-long">
                      <label>Religion</label>
                      <input type="checkbox" id="rel_buddhist" name="religion[]" value="Buddhist"><label for="rel_buddhist">Buddhist</label>
                      <input type="checkbox" id="rel_christian" name="religion[]" value="christian"><label for="rel_christian">Christian</label>
                      <input type="checkbox" id="rel_catholic" name="religion[]" value="Catholic"><label for="rel_catholic">Catholic</label>
                      <input type="checkbox" id="rel_islam" name="religion[]" value="islam"><label for="rel_islam">Islam</label>
                      <input type="checkbox" id="rel_hindu" name="religion[]" value="Hindu"><label for="rel_hindu">Hindu</label>
                      <input type="checkbox" id="rel_other" name="religion[]" value="Other"><label for="rel_other">Others</label>
                      <input type="text" name="religion_other" placeholder="others...">
                  </div>
              </div>
               <div class="row">
                   <div class="form-group checkbox-group-long">
                      <label>Any Claim</label>
                      <input type="checkbox" id="claim_sss" name="claim[]" value="Social Security Scheme"><label for="claim_sss">Social Security Scheme</label>
                      <input type="checkbox" id="claim_health" name="claim[]" value="Health Insurance"><label for="claim_health">Health Insurance</label>
                      <input type="checkbox" id="claim_self" name="claim[]" value="Self-pay"><label for="claim_self">Self-pay</label>
                      <input type="checkbox" id="claim_other" name="claim[]" value="Other"><label for="claim_other">Others</label>
                      <input type="text" name="claim_other" placeholder="others...">
                  </div>
              </div>
          </fieldset>

          <!-- ======================= Contact Information ======================= -->
          <fieldset>
              <legend>Contact Information</legend>
              <div class="row"><label>Where do you live now ? (Mailing address)*</label></div>
              <div class="row">
                  <div class="form-group" style="flex: 2;"><label for="address_street">No./Street/Road</label><input type="text" id="address_street" name="address_street" required="" placeholder="1234 Main St."></div>
                  <div class="form-group" style="flex: 1;"><label for="address_city">City/State/Province</label><input type="text" id="address_city" name="address_city" required="" placeholder="city / state / province"></div>
              </div>
               <div class="row">
                  <div class="form-group"><label for="address_country">Country</label><input type="text" id="address_country" name="address_country" required="" placeholder="country"></div>
                  <div class="form-group"><label for="address_postal">Postal Code</label><input type="text" id="address_postal" name="address_postal" placeholder="postal / zip code"></div>
                  <div class="form-group"><label for="tel_home">Home Tel.</label><input type="tel" id="tel_home" name="tel_home" placeholder="+xxx-xxx-xxx"></div>
                  <div class="form-group"><label for="tel_mobile">Mobile Tel.</label><input type="tel" id="tel_mobile" name="tel_mobile" placeholder="+xxx-xxx-xxx"></div>
              </div>
               <div class="row">
                  <div class="form-group" style="flex: 2;"><label for="address_thailand">Address in Thailand (Temporary address for Visitors only)</label><input type="text" id="address_thailand" name="address_thailand" placeholder="(temporary address for visitors only)"></div>
                  <div class="form-group" style="flex: 1;"><label for="tel_thailand">Tel.</label><input type="tel" id="tel_thailand" name="tel_thailand" placeholder="+xxx-xxx-xxx"></div>
              <div class="form-group" style="flex: 1;"><label for="mobile_thailand">Mobile Tel.*</label><input type="tel" id="mobile_thailand" name="mobile_thailand" placeholder="+xxx-xxx-xxx" required=""></div></div>
              <div class="row">
                  <div class="form-group"><label for="email">E-Mail*</label><input type="email" id="email" name="email" required="" placeholder="user@example.com"></div>
              </div>
              <div class="row"><label>Emergency Contact Person: Full Name (Mr.,Mrs., Ms., Miss, Others)*</label>
                <div class="form-group" style="flex: 2;"><input type="text" id="emergency_contact_name" name="emergency_contact_name" required="" placeholder="please specify details"></div>
              </div>
              <div class="row">
                  <div class="form-group" style="flex: 1;"><label for="emergency_contact_tel">Tel.</label><input type="tel" id="emergency_contact_tel" name="emergency_contact_tel" required="" placeholder="+xxx-xxx-xxx"></div>
                  <div class="form-group" style="flex: 1;"><label for="emergency_contact_relation">Relationship to Patient</label><input type="text" id="emergency_contact_relation" name="emergency_contact_relation" required="" placeholder="please specify details"></div>
              </div>
          </fieldset>

          <!-- ======================= Medical History ======================= -->
          <fieldset>
              <legend>Medical History</legend>
              <div class="row condition-header">
                  <label>Do you have any underlying conditions?*</label>
                  <div>
                      <input type="radio" id="uc_yes" name="med_underlying_conditions" value="Yes" required=""><label for="uc_yes">Yes</label>
                      <input type="radio" id="uc_no" name="med_underlying_conditions" value="No"><label for="uc_no">No</label>
                  </div>
              </div>
              <!-- This section will be shown/hidden by JavaScript -->
              <div>
                  <div class="two-column">
                      <div class="column">
                          <div class="condition-item"><label>Cerebrovascular Disease</label><div><input type="radio" name="med_cerebrovascular" value="Yes"><label>Yes</label><input type="radio" name="med_cerebrovascular" value="No" checked=""><label>No</label></div></div>
                          <div class="condition-item"><label>Hypothyroidism</label><div><input type="radio" name="med_hypothyroidism" value="Yes"><label>Yes</label><input type="radio" name="med_hypothyroidism" value="No" checked=""><label>No</label></div></div>
                          <div class="condition-item"><label>Hyperthyroidism</label><div><input type="radio" name="med_hyperthyroidism" value="Yes"><label>Yes</label><input type="radio" name="med_hyperthyroidism" value="No" checked=""><label>No</label></div></div>
                          <div class="condition-item"><label>Tuberculosis</label><div><input type="radio" name="med_tuberculosis" value="Yes"><label>Yes</label><input type="radio" name="med_tuberculosis" value="No" checked=""><label>No</label></div></div>
                          <div class="condition-item"><label>Asthma</label><div><input type="radio" name="med_asthma" value="Yes"><label>Yes</label><input type="radio" name="med_asthma" value="No" checked=""><label>No</label></div></div>
                      </div>
                      <div class="column">
                          <div class="condition-item"><label>Rheumatoid arthritis</label><div><input type="radio" name="med_rheumatoid" value="Yes"><label>Yes</label><input type="radio" name="med_rheumatoid" value="No" checked=""><label>No</label></div></div>
                          <div class="condition-item"><label>Systemic Lupus Erythematosus</label><div><input type="radio" name="med_lupus" value="Yes"><label>Yes</label><input type="radio" name="med_lupus" value="No" checked=""><label>No</label></div></div>
                          <div class="condition-item"><label>Epilepsy</label><div><input type="radio" name="med_epilepsy" value="Yes"><label>Yes</label><input type="radio" name="med_epilepsy" value="No" checked=""><label>No</label></div></div>
                          <div class="condition-item"><label>Renal Disease</label><div><input type="radio" name="med_renal" value="Yes"><label>Yes</label><input type="radio" name="med_renal" value="No" checked=""><label>No</label></div></div>
                          <div class="condition-item"><label>Hypertension</label><div><input type="radio" name="med_hypertension" value="Yes"><label>Yes</label><input type="radio" name="med_hypertension" value="No" checked=""><label>No</label></div></div>
                      </div>
                  </div>
                   <hr>
                  <!-- Items with specify fields -->
                  <br><div class="row">
                      <div class="form-group" style="flex: 1;">
                          <label>Lung Disease (others)&nbsp;&nbsp;</label>

                      </div>
                  <div class="form-group" style="flex: 2;">

                          <div><input type="radio" name="med_lung_disease" value="Yes" class="specify-trigger"><label>Yes (Please Specify)</label></div>
                      </div><div class="form-group" style="flex: 1.5;">

                          <div>

                              <input type="text" name="med_lung_disease_specify" placeholder="please specify">

                          </div>
                      </div><div class="form-group" style="flex: 0.5;">

                          <div>


                              <input type="radio" name="med_lung_disease" value="No" checked="" class="specify-trigger"><label>No</label>
                          </div>
                      </div></div>
                      <div class="row">
                          <div class="form-group" style="flex: 1;">
                              <label>Heart Disease (HD)</label>

                          </div>

                      <div class="form-group" style="flex: 2;">

                               <div>
                                  <input type="radio" name="med_heart_disease" value="Yes" class="specify-trigger"><label>Yes : 1) Congenital HD 2) Vulvular HD 3) Rheumatic HD 4) Myocardial Infarction 5) Ischemic HD/CAD 6) Other HD (Please Specify)</label>


                              </div>
                          </div><div class="form-group" style="flex: 1.5;">

                               <div>

                                  <input type="text" name="med_heart_disease_specify" placeholder="please specify">

                              </div>
                          </div><div class="form-group" style="flex: 0.5;">

                               <div>


                                  <input type="radio" name="med_heart_disease" value="No" checked="" class="specify-trigger"><label>No</label>
                              </div>
                          </div></div>
                          <div class="row">
                              <div class="form-group" style="flex: 1;">
                                   <label>Hematologic/Bleeding Disorder</label>

                              </div>

                          <div class="form-group" style="flex: 2;">

                                   <div>
                                      <input type="radio" name="med_bleeding_disorder" value="Yes" class="specify-trigger"><label>Yes (Please Specify)</label>


                                  </div>
                              </div><div class="form-group" style="flex: 1.5;">

                                   <div>

                                      <input type="text" name="med_bleeding_disorder_specify" placeholder="please specify">

                                  </div>
                              </div><div class="form-group" style="flex: 0.5;">

                                   <div>


                                      <input type="radio" name="med_bleeding_disorder" value="No" checked="" class="specify-trigger"><label>No</label>
                                  </div>
                              </div></div>
                              <div class="row">
                                 <div class="form-group" style="flex: 1;">
                                     <label>Hepatitis</label>
                                 </div>
                             <div class="form-group" style="flex: 2;">
                                      <div>
                                         <input type="radio" name="med_hepatitis" value="Yes" class="specify-trigger"><label>Yes : Type</label>
                                     </div>
                                 </div><div class="form-group" style="flex: 1.5;">
                                      <div>
                                         <input type="text" name="med_hepatitis_specify" placeholder="type">
                                     </div>
                                 </div><div class="form-group" style="flex: 0.5;">
                                      <div>
                                         <input type="radio" name="med_hepatitis" value="No" checked="" class="specify-trigger"><label>No</label>
                                     </div>
                                 </div></div>
                                 <div class="row">
                                     <div class="form-group" style="flex: 1.8;">
                                         <label>Diabetes Mellitus (DM)</label>
                                     </div>
                                 <div class="form-group" style="flex: 1.2;">
                                          <div>
                                             <input type="radio" name="med_diabetes" value="Yes" class="specify-trigger"><label>Yes : DM Type</label>
                                         </div>
                                     </div><div class="form-group" style="flex: 2;">
                                          <div>
                                             <input type="checkbox" id="med_diabetes_dm_1" name="med_diabetes_dm[]" value="1"><label for="med_diabetes_dm_1">1</label>
                                             <input type="checkbox" id="med_diabetes_dm_2" name="med_diabetes_dm[]" value="2"><label for="med_diabetes_dm_2">2</label>
                                             <label>Last blood glucose</label>
                                         </div>
                                     </div><div class="form-group" style="flex: 0.5;">
                                          <div>
                                             <input type="text" name="med_diabetes_specify" placeholder="xx">
                                         </div>
                                     </div><div class="form-group" style="flex: 2.5;">
                                          <div>
                                             <label>mg/dl : </label>
                                             <input type="checkbox" id="med_diabetes_glucose_FPG" name="med_diabetes_glucose[]" value="FPG"><label for="med_diabetes_glucose_FPG">FPG</label>
                                             <input type="checkbox" id="med_diabetes_glucose_HbA1C" name="med_diabetes_glucose[]" value="HbA1C"><label for="med_diabetes_glucose_HbA1C">HbA1C</label>
                                             <input type="checkbox" id="med_diabetes_glucose_DTX" name="med_diabetes_glucose[]" value="DTX"><label for="med_diabetes_glucose_DTX">DTX</label>
                                         </div>
                                     </div><div class="form-group" style="flex: 0.5;">
                                          <div>
                                             <input type="radio" name="med_diabetes" value="No" checked="" class="specify-trigger"><label>No</label>
                                         </div>
                                     </div></div>
                                    <div class="row">
                  <div class="form-group" style="flex: 1;">
                                        <label>Other underlying condition (Please Specify)</label>
                                    </div><div class="form-group" style="flex: 2;">
                                        <input type="text" name="med_other_condition" placeholder="please specify">
                                    </div></div>
                                    <div class="row">
                                       <div class="form-group" style="flex: 1;">
                                           <label>Current Medication</label>
                                       </div>
                                   <div class="form-group" style="flex: 2;">
                                           <div>
                                               <input type="radio" name="med_current_medication" value="Yes" class="specify-trigger"><label>Yes (Please Specify)</label>
                                           </div>
                                       </div><div class="form-group" style="flex: 1.5;">
                                           <div>
                                               <input type="text" name="med_current_medication_specify" placeholder="please specify">
                                           </div>
                                       </div><div class="form-group" style="flex: 0.5;">
                                           <div>
                                               <input type="radio" name="med_current_medication" value="No" checked="" class="specify-trigger"><label>No</label>
                                           </div>
                                       </div></div>
                                       <div class="row">
                                           <div class="form-group" style="flex: 1;">
                                               <label>Drug/Food/Others Allergy*</label>
                                           </div>
                                       <div class="form-group" style="flex: 2;">
                                                <div>
                                                   <input type="radio" name="med_allergy" value="Yes" required="" class="specify-trigger"><label>Yes (Please Specify)</label>
                                               </div>
                                           </div><div class="form-group" style="flex: 1.5;">
                                                <div>
                                                   <input type="text" name="med_allergy_specify" placeholder="please specify">
                                               </div>
                                           </div><div class="form-group" style="flex: 0.5;">
                                                <div>
                                                   <input type="radio" name="med_allergy" value="No" class="specify-trigger"><label>No</label>
                                               </div>
                                           </div></div>
                                           <div class="row">
                                              <div class="form-group" style="flex: 1.4;">
                                                  <label>Pregnancy</label>
                                              </div>
                                          <div class="form-group" style="flex: 2;">
                                                  <div>
                                                      <input type="radio" name="med_pregnancy" value="Yes" class="specify-trigger"><label>Yes  : GA</label>
                                                  </div>
                                              </div><div class="form-group" style="flex: 1.5;">
                                                  <div>
                                                      <input type="text" name="med_pregnancy_specify" placeholder="xx">
                                                  </div>
                                              </div><div class="form-group" style="flex: 1.5;">
                                                  <div>
                                                      <label>wk(s)</label>
                                                  </div>
                                              </div><div class="form-group" style="flex: 0.5;">
                                                  <div>
                                                      <input type="radio" name="med_pregnancy" value="No" checked="" class="specify-trigger"><label>No</label>
                                                  </div>
                                              </div></div>
                  <div class="condition-item"><label>Past Dental Experience</label><div><input type="radio" name="med_past_dental_exp" value="Yes"><label>Yes</label><input type="radio" name="med_past_dental_exp" value="No" checked=""><label>No</label></div></div>
                  <div class="condition-item"><label>Past Local Anesthesia Experience</label><div><input type="radio" name="med_past_anesthesia_exp" value="Yes"><label>Yes</label><input type="radio" name="med_past_anesthesia_exp" value="No" checked=""><label>No</label></div></div>
                  <div class="condition-item"><label>Having Dental Anxiety</label>
                      <div>
                          <input type="radio" name="med_dental_anxiety" value="Yes"><label>Yes</label>
                          <input type="radio" name="med_dental_anxiety" value="Not sure"><label>Not sure</label>
                          <input type="radio" name="med_dental_anxiety" value="No" checked=""><label>No</label>
                      </div>
                  </div>
              </div>
          </fieldset>

          <!-- ======================= Requirement ======================= -->
          <fieldset>
              <legend>Requirement</legend>
              <div class="row">
                  <div class="form-group checkbox-group">
                      <label>Purpose</label>
                      <input type="checkbox" id="pur_consult" name="req_purpose[]" value="Consult"><label for="pur_consult">Consult</label>
                      <input type="checkbox" id="pur_checkup" name="req_purpose[]" value="Dental Check-up"><label for="pur_checkup">Dental Check-up</label>
                      <input type="checkbox" id="pur_other" name="req_purpose[]" value="Others"><label for="pur_other">Others</label>
                      <input type="text" id="pur_other" name="req_purpose_specify" placeholder="others">
                  </div>
              </div>
               <div class="row">
                  <div class="form-group" style="flex:1;"><label for="req_chief_complaint">Chief Complaint</label><input type="text" id="req_chief_complaint" name="req_chief_complaint" placeholder="chief complaint"></div>
                  <div class="form-group" style="flex:1;"><label for="req_doctor_request">Doctor Request</label><input type="text" id="req_doctor_request" name="req_doctor_request" placeholder="doctor request"></div>
              </div>
          </fieldset>

          <!-- ======================= How did you learn about us ======================= -->
          <fieldset>
                <legend>How did you learn about us? You may select more than one answer* (please specify details)</legend>
                <div class="form-group checkbox-group">
                    <input type="checkbox" id="learn_google" name="how_learn_about_us[]" value="Google"><label for="learn_google">Google</label>
                    <input type="checkbox" id="learn_yahoo" name="how_learn_about_us[]" value="Yahoo"><label for="learn_yahoo">Yahoo</label>
                    <input type="checkbox" id="learn_facebook" name="how_learn_about_us[]" value="Facebook"><label for="learn_facebook">Facebook</label>
                    <input type="checkbox" id="learn_twitter" name="how_learn_about_us[]" value="Twitter"><label for="learn_twitter">Twitter</label>
                    <input type="checkbox" id="learn_bing" name="how_learn_about_us[]" value="Bing"><label for="learn_bing">Bing</label>
                    <input type="checkbox" id="learn_thaivisa" name="how_learn_about_us[]" value="Thai visa"><label for="learn_thaivisa">Thai visa</label>
                    <input type="checkbox" id="learn_tripadvisor" name="how_learn_about_us[]" value="Trip advisor"><label for="learn_tripadvisor">Trip advisor</label>
                </div>
                <br><div class="row">
  <div class="form-group checkbox-group">
                  <input type="checkbox" id="learn_recommended" name="how_learn_recommended[]" value="Recommended"><label for="learn_recommended">Recommended by someone or Informed by friends or other individuals</label><div class="form-group" style="flex: 2;"><input type="text" name="how_learn_recommended_specify" placeholder="please specify details"></div>

  </div>
</div>

                <div class="row">
  <div class="form-group checkbox-group">
       <input type="checkbox" id="learn_other" name="how_learn_other[]" value="Others">
  <label for="learn_other">Others</label><div class="form-group" style="flex: 1;"><input type="text" name="how_learn_specify" placeholder="please specify details"></div>

</div>
</div>
            </fieldset>

          <div class="submit-button-container">
              <button type="submit" class="submit-button">Submit Registration Form</button>
          </div>
      </form>
    </div>

    <!-- ======================= JavaScript ======================= -->

</body>
</html>
