<?php
session_start();

// Check if the user is an admin
if ($_SESSION['role'] != 'admin') {
    header('Location: unauthorized.php');
    exit;
}

include '../connection/connection.php';

// Check if the `id` parameter is provided
if (!isset($_GET['id'])) {
    die("No Referral ID specified.");
}

$referral_id = intval($_GET['id']);

// Fetch referral details
$query = "SELECT referral_form.request_id, referral_form.patient_id, patient_records.first_name, patient_records.last_name, request_type, summary_notes, priority_category, referral_form.staff_id, referral_form.hospital_department_id, department_name,sending_department_id, is_external, isViewed, created_at
          FROM referral_form 
          LEFT JOIN hospital_branches ON referral_form.hospital_department_id = hospital_branches.hospital_department_id 
          LEFT JOIN patient_records ON referral_form.patient_id = patient_records.patient_id 
          LEFT JOIN staff_records ON referral_form.staff_id = staff_records.staff_id 
          WHERE request_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $referral_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Referral not found.");
}

$referral = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_status = $_POST['referral_status'];

    // Update referral status
    $update_query = "UPDATE referral_form SET isViewed = ? WHERE request_id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("si", $new_status, $referral_id);

    if ($update_stmt->execute()) {
        header("Location: admin_referal_view.php");
        exit;
    } else {
        die("Error updating referral status: " . $conn->error);
    }
}
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
    <title>Update Referral Status</title>
    <style>
        .update-container {
            width: 80%;
            padding: 20px;
            margin-left: 20px;
            margin-top: 20px;
        }

        .update-container h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .update-container form label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .update-container form select, 
        .update-container form button {
            width: 100%;
            max-width: 400px;
            padding: 10px;
            margin: 10px 0;
            font-size: 16px;
        }

        .update-container form button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            width: auto;
        }

        .update-container form button:hover {
            background-color: #45a049;
        }

        .back-link {
            text-decoration: none;
            color: #007bff;
            font-size: 14px;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Side Menu -->
        <?php include("../common/sidebar.php"); ?>

        <!-- Main Content -->
        <div class="main-content">
            <?php include("../common/navbar.php"); ?>

            <div class="update-container">
                <h2>Update Referral Status:</h2>
                <p><strong>Referral ID:</strong> <?php echo htmlspecialchars($referral['request_id']); ?></p>
                <p><strong>Patient ID:</strong> <?php echo htmlspecialchars($referral['patient_id']); ?></p>
                <p><strong>Patient Name:</strong> <?php echo htmlspecialchars($referral['first_name']); ?> <?php echo htmlspecialchars($referral['last_name']); ?> </p>
                <p><strong>Request Type:</strong> <?php echo htmlspecialchars($referral['request_type']); ?></p>
                <p><strong>Sending Department:</strong> <?php echo htmlspecialchars($referral['sending_department_id']); ?></p>
                <p><strong>Destination Department:</strong> <?php echo htmlspecialchars($referral['department_name']); ?></p>
                <p><strong>Notes:</strong> <?php echo htmlspecialchars($referral['summary_notes']); ?></p>
                <p><strong>Request Date Submitted:</strong> <?php echo htmlspecialchars($referral['created_at']); ?></p>


                <form method="POST">
                    <label for="referral_status">Status:</label>
                    <select name="referral_status" id="referral_status">
                        <option value="Pending" <?php echo $referral['isViewed'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                        <option value="Reviewed" <?php echo $referral['isViewed'] === 'Reviewed' ? 'selected' : ''; ?>>Reviewed</option>
                        <option value="Completed" <?php echo $referral['isViewed'] === 'Completed' ? 'selected' : ''; ?>>Completed</option>
                        <option value="Rejected" <?php echo $referral['isViewed'] === 'Rejected' ? 'selected' : ''; ?>>Rejected</option>
                    </select>

                    <div class="action-buttons">
                        <button type="submit">Update</button>
                        <button style="background-color: grey;" onclick = "window.location.href='admin_referal_view.php'" class="back-link">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<script>
if (window.location.search.includes("update=success")) {
    alert("Referral status updated successfully!");
}
</script>
