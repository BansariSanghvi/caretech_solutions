<?php
session_start();

// Check if the user is an admin
if ($_SESSION['role'] != 'staff') {
    header('Location: unauthorized.php');
    exit;
}

include '../connection/connection.php';

// Check if staff ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Invalid request. Staff ID is missing.";
    exit;
}

$staff_id = intval($_GET['id']);

// Fetch staff details based on ID
$query = "SELECT staff_records.staff_id, 
                 staff_records.fname, 
                 staff_records.lname, 
                 staff_records.email, 
                 staff_records.staff_phone_no, 
                 staff_records.role, 
                 staff_records.address,
                 hospital_branches.department_name, 
                 staff_records.isActive
          FROM staff_records
          INNER JOIN hospital_branches 
          ON staff_records.hospital_department_id = hospital_branches.hospital_department_id
          WHERE staff_records.staff_id = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param('i', $staff_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the staff member exists
if ($result->num_rows === 0) {
    echo "Staff member not found.";
    exit;
}

$staff = $result->fetch_assoc();
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
    <title>View Staff</title>
    <style>
        .staff-details {
            width: 80%;
            padding: 20px;
            margin-right: 40px;
        }

        .staff-details h2 {
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
        <?php include("../common/staff_sidebar.php"); ?>

        <!-- Header -->
        <div class="main-content">
            <?php include("../common/staff_navbar.php"); ?>

            <!-- Staff Details Section -->
            <div class="staff-details">
            <h2 class="page_title">Staff Details:</h2>

                <div class="detail-row">
                    <div class="label">ID:</div>
                    <div class="value"><?php echo $staff['staff_id']; ?></div>
                </div>
                <div class="detail-row">
                    <div class="label">First Name:</div>
                    <div class="value"><?php echo $staff['fname']; ?></div>
                </div>
                <div class="detail-row">
                    <div class="label">Last Name:</div>
                    <div class="value"><?php echo $staff['lname']; ?></div>
                </div>
                <div class="detail-row">
                    <div class="label">Email:</div>
                    <div class="value"><?php echo $staff['email']; ?></div>
                </div>
                <div class="detail-row">
                    <div class="label">Address:</div>
                    <div class="value"><?php echo $staff['address']; ?></div>
                </div>
                <div class="detail-row">
                    <div class="label">Phone Number:</div>
                    <div class="value"><?php echo $staff['staff_phone_no']; ?></div>
                </div>
                <div class="detail-row">
                    <div class="label">Role:</div>
                    <div class="value"><?php echo $staff['role']; ?></div>
                </div>
                <div class="detail-row">
                    <div class="label">Department:</div>
                    <div class="value"><?php echo $staff['department_name']; ?></div>
                </div>
                <div class="detail-row">
                    <div class="label">Status:</div>
                    <div class="value"><?php echo $staff['isActive'] ? 'Active' : 'Inactive'; ?></div>
                </div>

            </div>
            <a href="staff_staffhub.php" class="back-button">Back to Staff Hub</a>
        </div>
    </div>
</body>
</html>

