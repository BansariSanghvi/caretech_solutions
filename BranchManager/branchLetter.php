<?php
session_start();
include dirname(__DIR__) . "../connection/connection.php";

$dbConnect = new DBConnect();
$conn = $dbConnect->connect(); // Assuming this returns a PDO instance

$current_page = 'forms';

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
            background-color: #ffffff; /* White background */
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
            color: #063478; /* Dark blue for labels */
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd; /* Light gray border */
            border-radius: 4px;
        }

        .form-group textarea {
            height: 150px; 
        }

        .form-group input[type="submit"] {
            background-color: #063478; /* Primary color */
            color: white; /* White text */
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-group input[type="submit"]:hover {
            background-color: #042456; /* Darker shade on hover */
        }
    </style>
</head>
<body>
    <div class="container">
      <!--------------------Side Menu------------ -->
      <?php include dirname(__DIR__) . "../common/branch_sidebar.php"; ?>

      <!-------------------Header------------------->
      <div class="main-content">
          <?php include dirname(__DIR__) . "../common/branch_navbar.php"; ?>
          
          <!------------------Patient Section------------------>
          <section id="letter_generation">
              <h2 class="page_title">Letter Generation</h2>
              <div class="form-container">
                  <form action="generate_letter.php" method="post">
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
                        <label for="letter_type">Letter Type:</label>
                        <select id="letter_type" name="letter_type" required>
                            <option value="">Select Letter Type</option>
                            <option value="appointment_confirmation">Appointment Confirmation</option>
                            <option value="discharge_summary">Discharge Summary</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="message">Message:</label>
                        <textarea id="message" name="message" required></textarea>
                    </div>

                    <!-- Submit button -->
                    <div class="form-group">
                        <input type="submit" value="Generate Letter">
                    </div>

                  </form>
              </div> <!-- End of form-container -->
          </section>

          <!-- JavaScript to update department based on selected staff -->
          <script src="assets/js/main.js"></script>

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

