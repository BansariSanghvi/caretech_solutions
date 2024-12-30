<?php
session_start();
include("../connection/connection.php");

$current_page = 'settings';

// Check if the user is an branch manager
if ($_SESSION['role'] != 'branchManager') {
    header('Location: unauthorized.php');
    exit;
}

// Fetch staff list for dropdown
$staff_query = "SELECT staff_id, fname, lname, role FROM staff_records";
$staff_result = $conn->query($staff_query);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $staff_id = $_POST['staff_id'];
    $urgency_value = $_POST['urgency_value'];
    $problem_description = "Password change request";

    // Get staff details
    $staff_query = "SELECT fname, lname, role, hospital_department_id FROM staff_records WHERE staff_id = ?";
    $stmt = $conn->prepare($staff_query);
    $stmt->bind_param("i", $staff_id);
    $stmt->execute();
    $staff_result = $stmt->get_result();
    $staff_data = $staff_result->fetch_assoc();

    // Insert request into problems table
    $insert_query = "INSERT INTO problems (problem_catagory, problem_description, staff_id, staff_fname, staff_lname, hospital_department_id, staff_role, urgency_value) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_query);
    $problem_category = "Password Change";
    $stmt->bind_param("ssisssss", $problem_category, $problem_description, $staff_id, $staff_data['fname'], $staff_data['lname'], $staff_data['hospital_department_id'], $staff_data['role'], $urgency_value);

    if ($stmt->execute()) {
        $message = "Password change request submitted successfully.";
    } else {
        $error = "Error submitting request: " . $conn->error;
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
    <title>Request Password Change</title>
    <style>
        .form-container {
            width: 50%;
            margin: 20px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        select, input[type="email"], input[type="submit"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .message {
            color: green;
            font-weight: bold;
        }
        .error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
      <!--------------------Side Menu------------ -->
      <?php include("../common/branch_sidebar.php"); ?>

      <!-------------------Header------------------->
      <div class="main-content">
        <?php include("../common/branch_navbar.php"); ?>
        <!------------------Inner Section------------------>
        <div class="inside-content">
            <section class="settings_section" id="settings_hub">
                <h2 class="page_title">Request Password Change:</h2>

                <div class="form-container">
                    <?php
                    if (isset($message)) {
                        echo "<p class='message'>$message</p>";
                    }
                    if (isset($error)) {
                        echo "<p class='error'>$error</p>";
                    }
                    ?>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label for="staff_id">Select Staff:</label>
                            <select name="staff_id" id="staff_id" required>
                                <option value="">Select a staff member</option>
                                <?php
                                while ($staff = $staff_result->fetch_assoc()) {
                                    echo "<option value='" . $staff['staff_id'] . "'>" . $staff['fname'] . " " . $staff['lname'] . " (" . $staff['role'] . ")</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="urgency_value">Urgency:</label>
                            <select name="urgency_value" id="urgency_value" required>
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Submit Request">
                        </div>
                    </form>
                </div>
            </section>
        </div>
      </div>
    </div>

    <script src="assets/js/main.js"></script>
</body>
</html>