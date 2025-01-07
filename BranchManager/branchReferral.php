<?php
session_start();
include dirname(__DIR__) . "/connection/connection.php";

$dbConnect = new DBConnect();
$conn = $dbConnect->connect(); // Assuming this returns a PDO instance

// Fetch Patients
$patient_query = "SELECT patient_id, first_name, last_name FROM patient_records";
$patient_stmt = $conn->query($patient_query);
$patient_result = $patient_stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch Staff with their associated department
$staff_query = "SELECT staff_id, fname, lname, hospital_department_id FROM staff_records";
$staff_stmt = $conn->query($staff_query);
$staff_result = $staff_stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch Departments
$dept_query = "SELECT hospital_department_id, department_name FROM hospital_branches";
$dept_stmt = $conn->query($dept_query);
$dept_result = $dept_stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch External Associations
$external_query = "SELECT medical_association_id, medical_association_name FROM external_associations";
$external_stmt = $conn->query($external_query);
$external_result = $external_stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>BranchManager Form</title>
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
        .form-group textarea,
        .form-group select {
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
      <?php include dirname(__DIR__) . "/common/branch_sidebar.php"; ?>

      <!-------------------Header------------------->
      <div class="main-content">
          <?php include dirname(__DIR__) . "/common/branch_navbar.php"; ?>
          
          <!------------------Patient Section------------------>
          <section id="referral_form">
              <h2 class="page_title">Referral Form</h2>
              <div class="form-container">
                  <form action="process_referral.php" method="post">
                      <div class="form-group">
                          <label for="patient_id">Patient:</label>
                          <select id="patient_id" name="patient_id" required>
                              <option value="">Select Patient</option>
                              <?php foreach ($patient_result as $patient): ?>
                                  <option value="<?php echo htmlspecialchars($patient['patient_id']); ?>">
                                      <?php echo htmlspecialchars($patient['first_name'] . ' ' . $patient['last_name']); ?>
                                  </option>
                              <?php endforeach; ?>
                          </select>
                      </div>

                      <!-- Staff selection -->
                      <div class="form-group">
                        <label for="staff_id">Staff:</label>
                        <select id="staff_id" name="staff_id" required onchange="updateDepartment()">
                            <option value="">Select Staff</option>
                            <?php foreach ($staff_result as $staff): ?>
                                <option value="<?php echo htmlspecialchars($staff['staff_id']); ?>" data-department-id="<?php echo htmlspecialchars($staff['hospital_department_id']); ?>">
                                    <?php echo htmlspecialchars($staff['fname'] . ' ' . $staff['lname']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="hospital_department_id">Department:</label>
                        <select id="hospital_department_id" name="hospital_department_id" required>
                            <option value="">Select Department</option>
                            <?php foreach ($dept_result as $dept): ?>
                                <option value="<?php echo htmlspecialchars($dept['hospital_department_id']); ?>">
                                    <?php echo htmlspecialchars($dept['department_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>      
                    </div>

                      <div class="form-group">
                        <label for="referral_category">Referral Category:</label>
                        <select id="referral_category" name="referral_category" required onchange="toggleReferralFields()">
                            <option value="">Select Referral Category</option>
                            <option value="internal">Internal Department</option>
                            <option value="external">External Facility</option>
                        </select>
                    </div>

                      <div id="internal_fields" style="display:none;">
                        <div class="form-group">
                            <label for="internal_department">Internal Department:</label>
                            <select id="internal_department" name="internal_department">
                                <option value="">Select Internal Department</option>
                                <?php foreach ($dept_result as $dept): ?>
                                    <option value="<?php echo htmlspecialchars($dept['hospital_department_id']); ?>">
                                        <?php echo htmlspecialchars($dept['department_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div id="external_fields" style="display:none;">
                        <div class="form-group">
                            <label for="external_facility">External Facility:</label>
                            <select id="external_facility" name="external_facility">
                                <option value="">Select External Facility</option> 
                                <?php foreach ($external_result as $external): ?>
                                    <option value="<?php echo htmlspecialchars($external['medical_association_id']); ?>">
                                        <?php echo htmlspecialchars($external['medical_association_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Additional form fields -->
                    <!-- Add other fields here as needed -->

                    <!-- Reason for referral -->
                    <div class="form-group">
                          <label for="reason_for_referral">Reason for Referral:</label>
                          <textarea id="reason_for_referral" name="reason_for_referral" required></textarea>
                      </div>

                      <!-- Hidden field to indicate if external -->
                      <input type="hidden" id="is_external" name="is_external" value="0">

                      <!-- Submit button -->
                      <div class="form-group">
                          <input type="submit" value="Submit Referral">
                      </div>

                  </form>
              </div> <!-- End of form-container -->
          </section>

          <!-- JavaScript to toggle fields -->
          <script>
            function toggleReferralFields() {
                var referralType = document.getElementById('referral_category').value;
                var internalFields = document.getElementById('internal_fields');
                var externalFields = document.getElementById('external_fields');
                var isExternalInput = document.getElementById('is_external');
                var internalDepartment = document.getElementById('internal_department');
                var externalFacility = document.getElementById('external_facility');

                if (referralType === 'internal') {
                    internalFields.style.display = 'block';
                    externalFields.style.display = 'none';
                    isExternalInput.value = '0';
                    internalDepartment.required = true;
                    externalFacility.required = false;
                } else if (referralType === 'external') {
                    internalFields.style.display = 'none';
                    externalFields.style.display = 'block';
                    isExternalInput.value = '1';
                    internalDepartment.required = false;
                    externalFacility.required = true;
                } else {
                    internalFields.style.display = 'none';
                    externalFields.style.display = 'none';
                    isExternalInput.value = '0';
                    internalDepartment.required = false;
                    externalFacility.required = false;
                }
            }
          </script>

          <!-- JavaScript to update department based on selected staff -->
          <script>
              function updateDepartment() {
                  var staffSelect = document.getElementById('staff_id');
                  var departmentSelect = document.getElementById('hospital_department_id');

                  // Get selected option
                  var selectedOption = staffSelect.options[staffSelect.selectedIndex];
                  
                  // Get the department ID from data attribute
                  var departmentId = selectedOption.getAttribute('data-department-id');

                  // Set the department select value
                  if (departmentId) {
                      // Set the selected value in the department dropdown
                      departmentSelect.value = departmentId;
                  } else {
                      // Reset if no department is associated
                      departmentSelect.value = "";
                  }
              }
          </script>

      </body>
</html>

