<?php
session_start();
include dirname(__DIR__).("/connection/connection.php");

$dbConnect = new DBConnect();
$conn = $dbConnect->connect();


// Check if patient ID is provided
if (!isset($_GET['patient_id'])) {
    header('Location: branchPatients.php'); // Redirect if no patient ID is provided
    exit;
}

$patient_id = $_GET['patient_id'];

// Fetch existing patient data
$query = "SELECT * FROM patient_records WHERE patient_id = :patient_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':patient_id', $patient_id, PDO::PARAM_INT);
$stmt->execute();
$patient = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$patient) {
    // Redirect if no patient found
    header('Location: branchPatients.php');
    exit;
}

// Handle form submission for updating the record
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get updated values from form
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_no = $_POST['phone_no'];
    $date_of_birth = $_POST['date_of_birth'];
    $emergency_contact = $_POST['emergency_contact'];
    $emergency_contact_name = $_POST['emergency_contact_name'];
    $patient_history = $_POST['patient_history'];
    $isRegistered_NHS = isset($_POST['isRegistered_NHS']) ? 1 : 0;
    $last_seen_date = $_POST['last_seen_date'];

    // Update patient record in the database
    $update_query = "UPDATE patient_records SET first_name=?, last_name=?, email=?, phone_no=?, date_of_birth=?, emergency_contact=?, emergency_contact_name=?, patient_history=?, isRegistered_NHS=?, last_seen_date=? WHERE patient_id=?";
    
    $stmt = $conn->prepare($update_query);
    
    // Bind parameters
    $stmt->bindParam(1, $first_name);
    $stmt->bindParam(2, $last_name);
    $stmt->bindParam(3, $email);
    $stmt->bindParam(4, $phone_no);
    $stmt->bindParam(5, $date_of_birth);
    $stmt->bindParam(6, $emergency_contact);
    $stmt->bindParam(7, $emergency_contact_name);
    $stmt->bindParam(8, $patient_history);
    $stmt->bindParam(9, $isRegistered_NHS);
    $stmt->bindParam(10, $last_seen_date);
    $stmt->bindParam(11, $patient_id);

    if ($stmt->execute()) {
        // Redirect or show success message
        header('Location: branchPatients.php?message=Patient updated successfully');
        exit;
    } else {
        // Handle error
        $errorInfo = $stmt->errorInfo();
        $error = "Error updating record: " . implode(", ", $errorInfo);
    }
}
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
    <title>Edit Patient</title>
<style>
.form-container {
    background-color: #ffffff;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-width: 500px;
    margin: 20px auto;
}

.form-group {
    margin-bottom: 10px;
}

.form-group label {
    width: 120px; /* Fixed width for labels */
}

.form-group input[type="text"],
.form-group input[type="email"],
.form-group input[type="tel"],
.form-group input[type="date"],
.form-group select {
    flex: 1;
}

.form-group input[type="submit"],
.form-group button {
   color: white;
   padding: 10px 20px;
   font-size: 16px;
   font-weight: bold;
   border: none;
   border-radius: 6px;
   cursor: pointer;
   background-color: #063478; /* Primary color */
}

.form-group input[type="submit"]:hover,
.form-group button:hover {
   background-color: #042456; /* Darker shade on hover */
}
</style>

</head>
<body>
<div class="container">
      <?php include (__DIR__).("/common/branch_sidebar.php"); ?>
      <div class="main-content">
        <?php include (__DIR__).("/common/branch_navbar.php"); ?>
        <div class="inside-content">
            <section class="patient_records_section" id='patient_records'>
                <h3 class="page_title">Edit Patient:</h3>
                <div class="form-container">
                    <?php if (isset($error)): ?>
                        <p class='error'><?php echo htmlspecialchars($error); ?></p>
                    <?php endif; ?>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?patient_id=' . htmlspecialchars($patient_id); ?>" method="POST">
                        <div class="form-group">
                            <label for="first_name">First Name:</label>
                            <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($patient['first_name']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="last_name">Last Name:</label>
                            <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($patient['last_name']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($patient['email']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="phone_no">Phone Number:</label>
                            <input type="tel" id="phone_no" name="phone_no" value="<?php echo htmlspecialchars($patient['phone_no']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="date_of_birth">Year of Birth:</label>
                            <input type="number" id="date_of_birth" name="date_of_birth" value="<?php echo htmlspecialchars($patient['date_of_birth']); ?>" min="1900" max="<?php echo date('Y'); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="emergency_contact">Emergency Contact:</label>
                            <input type="tel" id="emergency_contact" name="emergency_contact" value="<?php echo htmlspecialchars($patient['emergency_contact']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="emergency_contact_name">Emergency Contact Name:</label>
                            <input type="text" id="emergency_contact_name" name="emergency_contact_name" value="<?php echo htmlspecialchars($patient['emergency_contact_name']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="patient_history">Patient History:</label>
                            <textarea id="patient_history" name="patient_history"><?php echo htmlspecialchars($patient['patient_history']); ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="last_seen_date">Last Seen Year:</label>
                            <input type="number" id="last_seen_date" name="last_seen_date" value="<?php echo htmlspecialchars($patient['last_seen_date']); ?>" min="1900" max="<?php echo date('Y'); ?>">
                        </div>

                        <div class="form-group">
                            <div class='button-container'>
                                <button type='submit'>Update Patient</button>
                                <button type='button' onclick='window.location.href="branchPatients.php"' >Cancel</button>
                            </div>
                        </div>
                    </form>
                </div> <!-- End of form-container -->
            </section>
        </div>
      </div>
</div>

<script src="../assets/js/main.js"></script>
</body>
</html>