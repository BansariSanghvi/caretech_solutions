<?php
session_start();

$current_page = 'forms';

// Check if the user is a staff
if ($_SESSION['role'] != 'staff') {
    header('Location: unauthorized.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/main_theme.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>BranchManager Form2</title>
    <style>
.form-container {
    background-color: #ffffff; 
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-width: 600px;
    margin: 20px auto;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    color: #063478;
}

.form-group input[type="text"],
.form-group textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd; 
    border-radius: 4px;
}

.form-group textarea {
    height: 150px; 
}

.form-group input[type="submit"] {
    background-color: #063478; 
    color: white; 
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
}

.form-group input[type="submit"]:hover {
    background-color: #042456; 
}
</style>
</head>
<body>
    <div class="container">
      <!--------------------Side Menu------------ -->
      <?php  include("../common/staff_sidebar.php"); ?>

<!-------------------Header------------------->
<div class="main-content">
    
<?php  include("../common/staff_navbar.php"); ?>
            <!------------------Patient Section------------------>
            <section id="referral_form">
            <h2 class="page_title">Referral Form</h2>
            <div class="form-container">
        <form action="submit_referral.php" method="post">
            <div class="form-group">
                <label for="patient_name">Patient Name:</label>
                <input type="text" id="patient_name" name="patient_name" required>
            </div>
            <div class="form-group">
                <label for="patient_id">Patient ID:</label>
                <input type="text" id="patient_id" name="patient_id" required>
            </div>
            <div class="form-group">
                <label for="referral_type">Referral Type:</label>
                <select id="referral_type" name="referral_type" required onchange="toggleReferralFields()">
                    <option value="">Select Referral Type</option>
                    <option value="internal">Internal Department</option>
                    <option value="external">External Facility</option>
                </select>
            </div>
            <div id="internal_fields" style="display:none;">
                <div class="form-group">
                    <label for="internal_department">Department:</label>
                    <select id="internal_department" name="internal_department">
                        <option value="">Select Department</option>
                        <option value="Cardiology">Cardiology</option>
                     <option value="Emergency">Emergency</option>
                     <option value="Orthodontics">Orthodontics</option>
                     <option value="Rehabilitation">Rehabilitation</option>
                    </select>
                </div>
            </div>
            <div id="external_fields" style="display:none;">
                <div class="form-group">
                    <label for="external_facility">External Facility:</label>
                    <input type="text" id="external_facility" name="external_facility" placeholder="Hospital or GP Surgery Name">
                </div>
            </div>
            <div class="form-group">
                <label for="reason_for_referral">Reason for Referral:</label>
                <textarea id="reason_for_referral" name="reason_for_referral" required></textarea>
            </div>
            <div class="form-group">
                <input type="submit" value="Submit Referral">
            </div>
        </form>
    </div>
</section>



<script>
function toggleReferralFields() {
    var referralType = document.getElementById('referral_type').value;
    var internalFields = document.getElementById('internal_fields');
    var externalFields = document.getElementById('external_fields');

    if (referralType === 'internal') {
        internalFields.style.display = 'block';
        externalFields.style.display = 'none';
    } else if (referralType === 'external') {
        internalFields.style.display = 'none';
        externalFields.style.display = 'block';
    } else {
        internalFields.style.display = 'none';
        externalFields.style.display = 'none';
    }
}
</script>
</html>
