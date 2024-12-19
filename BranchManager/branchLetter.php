<?php
session_start();
include("../connection/connection.php");

$current_page = 'forms';

// Check if the user is an branch manager
if ($_SESSION['role'] != 'branchManager') {
    header('Location: unauthorized.php');
    exit;
}

// Fetch Patients
$patient_query = "SELECT patient_id, first_name, last_name FROM patient_records";
$patient_result = $conn->query($patient_query);

// Fetch Staff with their associated department
$staff_query = "SELECT staff_id, fname, lname, hospital_department_id FROM staff_records";
$staff_result = $conn->query($staff_query);

// Fetch Departments
$dept_query = "SELECT hospital_department_id, department_name FROM hospital_branches";
$dept_result = $conn->query($dept_query);
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
    <title>BranchManager Form1</title>
    
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
         <!--------------------Side Menu------------ -->
      <?php  include("../common/branch_sidebar.php"); ?>

<!-------------------Header------------------->
<div class="main-content">
    
<?php  include("../common/branch_navbar.php"); ?>
            <!------------------Patient Section------------------>
            <section id="letter_generation">
    <h2 class="page_title">Letter Generation</h2>
    <div class="form-container">
        <form action="generate_letter.php" method="post">
        <div class="form-group">
    <label for="patient_id">Patient:</label>
    <select id="patient_id" name="patient_id" required>
        <option value="">Select Patient</option>
        <?php while($patient = $patient_result->fetch_assoc()): ?>
            <option value="<?php echo $patient['patient_id']; ?>">
                <?php echo $patient['first_name'] . ' ' . $patient['last_name']; ?>
            </option>
        <?php endwhile; ?>
    </select>
</div>

<div class="form-group">
    <label for="staff_id">Staff:</label>
    <select id="staff_id" name="staff_id" required onchange="updateDepartment()">
        <option value="">Select Staff</option>
        <?php while($staff = $staff_result->fetch_assoc()): ?>
            <option value="<?php echo $staff['staff_id']; ?>" data-department-id="<?php echo $staff['hospital_department_id']; ?>">
                <?php echo $staff['fname'] . ' ' . $staff['lname']; ?>
            </option>
        <?php endwhile; ?>
    </select>
</div>

<div class="form-group">
    <label for="hospital_department_id">Department:</label>
    <select id="hospital_department_id" name="hospital_department_id" required>
        <option value="">Select Department</option>
        <?php while($dept = $dept_result->fetch_assoc()): ?>
            <option value="<?php echo $dept['hospital_department_id']; ?>">
                <?php echo $dept['department_name']; ?>
            </option>
        <?php endwhile; ?>
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

        <div class="form-group">
            <input type="submit" value="Generate Letter">
        </div>
    </form>
</div>
</section>



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
