<?php
session_start();

// Check if the user is an admin
if ($_SESSION['role'] != 'admin') {
    header('Location: unauthorized.php');
    exit;
}

include '../connection/connection.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/branch_theme.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Referral Form</title>
    <style>
        .form-container {
            padding: 20px;
            max-width: 600px;
            margin-left: 20px;
        }

        .form-group {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .form-group label {
            flex: 1; /* Allows labels to take up equal space */
            color: black;
            font-weight: bold;
            margin-right: 20px;
        }
        .form-group input[type="text"],
        .form-group textarea,
        .form-group select {
            flex: 2; /* Allows input fields to be wider */
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .form-group textarea {
            height: 80px;
        }


        .form-group input[type="submit"] {
            background-color: green;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-group input[type="submit"]:hover {
            background-color: #042456;
        }

        #internal_fields,
        #external_fields {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!--------------------Side Menu------------ -->
        <?php include("../common/sidebar.php"); ?>

        <!-------------------Header------------------->
        <div class="main-content">
            <?php include("../common/navbar.php"); ?>
            <!------------------Patient Section------------------>
            <section id="referral_form">
                <h2 class="page_title">Admin Referral Form:</h2>
                <div class="form-container">
                    <form action="admin_process_referral.php" method="post">
                        <div class="form-group">
                            <label for="patient_name">Patient Name:</label>
                            <input type="text" id="patient_name" name="patient_name" required>
                        </div>

                        <div class="form-group">
                            <label for="patient_id">Patient ID:</label>
                            <input type="text" id="patient_id" name="patient_id" required>
                        </div>

                        <div class="form-group">
                            <label for="department_from">Department Selected:</label>
                            <?php
                                $result = $conn->query("SELECT hospital_department_id, department_name FROM `hospital_branches`;");
                                if ($result->num_rows > 0) {
                                    echo '<select id="hospital_department_id" name="hospital_department_id" required>';
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value="' . $row['hospital_department_id'] . '">' . $row['department_name'] . '</option>';
                                    }
                                    echo '</select>';
                                } else {
                                    echo '<p>No departments available</p>';
                                }
                            ?>
                        </div>

                        <div class="form-group">
                            <label for="referral_type">Referral Destination:</label>
                            <select id="referral_type" name="referral_type" required onchange="toggleReferralFields()">
                                <option value="internal">Internal Department</option>
                                <option value="external">External Facility</option>
                            </select>
                        </div>

                        <div id="internal_fields" style="display:none;">
                            <div class="form-group">
                                <label for="internal_department">Department:</label>
                                <?php
                                    $result = $conn->query("SELECT hospital_department_id, department_name FROM `hospital_branches`;");
                                    if ($result->num_rows > 0) {
                                        echo '<select id="hospital_department_id" name="hospital_department_id" required>';
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<option value="' . $row['hospital_department_id'] . '">' . $row['department_name'] . '</option>';
                                        }
                                        echo '</select>';
                                    } else {
                                        echo '<p>No departments available</p>';
                                    }
                                ?>
                            </div>
                        </div>

                        <div id="external_fields" style="display:none;">
                            <div class="form-group">
                                <label for="external_facility">External Facility:</label>
                                <?php
                                    $result = $conn->query("SELECT medical_association_id, medical_association_name FROM `external_associations`;");
                                    if ($result->num_rows > 0) {
                                        echo '<select id="medical_association_id" name="medical_association_id" required>';
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<option value="' . $row['medical_association_id'] . '">' . $row['medical_association_name'] . '</option>';
                                        }
                                        echo '</select>';
                                    } else {
                                        echo '<p>No Associations available</p>';
                                    }
                                ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="priority_id">Priority Level:</label>
                            <select id="p_type" name="p_type">
                                <option value="urgent">Urgent</option>
                                <option value="standard">Standard</option>
                                <option value="non-priority">Non-Priority</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="notes">Extra Notes:</label>
                            <textarea id="notes" name="notes" required></textarea>
                        </div>

                        <div class="form-group">
                            <input type="submit" value="Submit Referral">
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>

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
</body>
</html>
