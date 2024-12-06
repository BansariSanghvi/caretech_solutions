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
         <!--------------------Side Menu------------ -->
      <?php  include("../common/staff_sidebar.php"); ?>

<!-------------------Header------------------->
<div class="main-content">
    
<?php  include("../common/staff_navbar.php"); ?>
            <!------------------Patient Section------------------>
            <section id="referral_form">
            <h2 class="page_title">Referral Form</h2>
            <div class="form-container">
        <form action="process_referral.php" method="post">
            <div class="form-group">
                <label for="patient_name">Patient Name:</label>
                <input type="text" id="patient_name" name="patient_name" required>
            </div>
            <div class="form-group">
                <label for="patient_id">Patient ID:</label>
                <input type="text" id="patient_id" name="patient_id" required>
            </div>
            <div class="form-group">
                <label for="specialist">Specialist:</label>
                <input type="text" id="specialist" name="specialist" required placeholder="Name of the specialist">
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



    <script src="assets/js/main.js"></script>
</body>
</html>
