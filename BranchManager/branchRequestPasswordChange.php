<?php
session_start();
include dirname(__DIR__) . "../connection/connection.php";

$dbConnect = new DBConnect();
$conn = $dbConnect->connect(); // Assuming this returns a PDO instance

$current_page = 'settings';

// Fetch staff list for dropdown
$staff_query = "SELECT staff_id, fname, lname, role FROM staff_records";
$staff_stmt = $conn->query($staff_query);
$staff_list = $staff_stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $staff_id = $_POST['staff_id'];
    $urgency_value = $_POST['urgency_value'];
    $problem_description = "Password change request";

    // Get staff details
    $staff_query = "SELECT fname, lname, role, hospital_department_id FROM staff_records WHERE staff_id = :staff_id";
    $stmt = $conn->prepare($staff_query);
    $stmt->bindParam(':staff_id', $staff_id, PDO::PARAM_INT);
    $stmt->execute();
    $staff_data = $stmt->fetch(PDO::FETCH_ASSOC);

    // Insert request into problems table
    $insert_query = "INSERT INTO problems (problem_catagory, problem_description, staff_id, staff_fname, staff_lname, hospital_department_id, staff_role, urgency_value) 
                     VALUES (:problem_category, :problem_description, :staff_id, :staff_fname, :staff_lname, :hospital_department_id, :staff_role, :urgency_value)";
    
    $stmt = $conn->prepare($insert_query);
    
    $problem_category = "Password Change";
    
    // Bind parameters
    $stmt->bindParam(':problem_category', $problem_category);
    $stmt->bindParam(':problem_description', $problem_description);
    $stmt->bindParam(':staff_id', $staff_id);
    $stmt->bindParam(':staff_fname', $staff_data['fname']);
    $stmt->bindParam(':staff_lname', $staff_data['lname']);
    $stmt->bindParam(':hospital_department_id', $staff_data['hospital_department_id']);
    $stmt->bindParam(':staff_role', $staff_data['role']);
    $stmt->bindParam(':urgency_value', $urgency_value);

    if ($stmt->execute()) {
        $message = "Password change request submitted successfully.";
    } else {
        // Use errorInfo() to get more details about the error
        $errorInfo = $stmt->errorInfo();
        $error = "Error submitting request: " . implode(", ", $errorInfo);
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
      <?php include dirname(__DIR__) . "../common/branch_sidebar.php"; ?>

      <!-------------------Header------------------->
      <div class="main-content">
        <?php include dirname(__DIR__) . "../common/branch_navbar.php"; ?>
        
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
                                <?php foreach ($staff_list as $staff): ?>
                                    <option value="<?php echo htmlspecialchars($staff['staff_id']); ?>">
                                        <?php echo htmlspecialchars($staff['fname'] . " " . $staff['lname'] . " (" . htmlspecialchars($staff['role']) . ")"); ?>
                                    </option>
                                <?php endforeach; ?>
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

