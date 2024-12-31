<?php
session_start();

// Check if the user is staff
if ($_SESSION['role'] != 'staff') {
    header('Location: unauthorized.php');
    exit;
}

include '../connection/connection.php';

// Check if patient ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Invalid request. Patient ID is missing.";
    exit;
}

$patient_id = intval($_GET['id']);

// Fetch patient details based on ID
$query = "SELECT patient_records.patient_id, 
                 patient_records.first_name, 
                 patient_records.last_name, 
                 patient_records.email, 
                 patient_records.phone_no, 
                 patient_records.date_of_birth, 
                 patient_records.emergency_contact, 
                 patient_records.emergency_contact_name, 
                 patient_records.patient_history, 
                 patient_records.isRegistered_NHS, 
                 staff_records.fname AS staff_fname, 
                 staff_records.lname AS staff_lname, 
                 hospital_info.hospital_name, 
                 external_associations.association_name, 
                 patient_records.last_seen_date
          FROM patient_records
          INNER JOIN staff_records ON patient_records.staff_id = staff_records.staff_id
          INNER JOIN hospital_info ON patient_records.hospital_id = hospital_info.hospital_id
          INNER JOIN external_associations ON patient_records.medical_association_id = external_associations.medical_association_id
          WHERE patient_records.patient_id = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param('i', $patient_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the patient exists
if ($result->num_rows === 0) {
    echo "Patient not found.";
    exit;
}

$patient = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/img/favicon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/main_theme.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>View Patient</title>
    <style>
        .patient-details {
            width: 80%;
            padding: 20px;
            margin-right: 40px;
        }

        .patient-details h2 {
            margin-bottom: 20px;
            text-align: left;
            font-size: 24px;
            color: black;
        }

        .detail-row {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .label {
            width: 30%;
            font-weight: bold;
            color: black;
            text-align: left;
            padding-right: 10px;
            margin-left: 30px;
        }

        .value {
            width: 70%;
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 10px 15px;
            border-radius: 4px;
            color: #333;
        }

        .back-button {
            display: inline-block;
            margin: 20px auto 0;
            padding: 10px 20px;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
            margin-left: 40px;
            margin-bottom: 30px;
        }

        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Side Menu -->
        <?php include("../common/sidebar.php"); ?>

        <!-- Header -->
        <div class="main-content">
            <?php include("../common/navbar.php"); ?>

            <!-- Patient Details Section -->
            <div class="patient-details">
                <h2 class="page_title">Patient Details:</h2>

                <div class="detail-row">
                    <div class="label">ID:</div>
                    <div class="value"><?php echo $patient['patient_id']; ?></div>
                </div>
                <div class="detail-row">
                    <div class="label">First Name:</div>
                    <div class="value"><?php echo $patient['first_name']; ?></div>
                </div>
                <div class="detail-row">
                    <div class="label">Last Name:</div>
                    <div class="value"><?php echo $patient['last_name']; ?></div>
                </div>
                <div class="detail-row">
                    <div class="label">Email:</div>
                    <div class="value"><?php echo $patient['email']; ?></div>
                </div>
                <div class="detail-row">
                    <div class="label">Phone Number:</div>
                    <div class="value"><?php echo $patient['phone_no']; ?></div>
                </div>
                <div class="detail-row">
                    <div class="label">Date of Birth:</div>
                    <div class="value"><?php echo $patient['date_of_birth']; ?></div>
                </div>
                <div class="detail-row">
                    <div class="label">Emergency Contact:</div>
                    <div class="value"><?php echo $patient['emergency_contact']; ?></div>
                </div>
                <div class="detail-row">
                    <div class="label">Emergency Contact Name:</div>
                    <div class="value"><?php echo $patient['emergency_contact_name']; ?></div>
                </div>
                <div class="detail-row">
                    <div class="label">Patient History:</div>
                    <div class="value"><?php echo $patient['patient_history']; ?></div>
                </div>
                <div class="detail-row">
                    <div class="label">NHS Registered:</div>
                    <div class="value"><?php echo $patient['isRegistered_NHS'] ? 'Yes' : 'No'; ?></div>
                </div>
                <div class="detail-row">
                    <div class="label">Assigned Staff:</div>
                    <div class="value"><?php echo $patient['staff_fname'] . " " . $patient['staff_lname']; ?></div>
                </div>
                <div class="detail-row">
                    <div class="label">Hospital:</div>
                    <div class="value"><?php echo $patient['hospital_name']; ?></div>
                </div>
                <div class="detail-row">
                    <div class="label">Medical Association:</div>
                    <div class="value"><?php echo $patient['association_name']; ?></div>
                </div>
                <div class="detail-row">
                    <div class="label">Last Seen Date:</div>
                    <div class="value"><?php echo $patient['last_seen_date']; ?></div>
                </div>

            </div>
            <a href="patient_hub.php" class="back-button">Back to Patient Hub</a>
        </div>
    </div>
</body>
</html>
