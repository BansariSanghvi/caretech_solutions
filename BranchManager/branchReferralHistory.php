<?php
session_start();

include '../connection/connection.php';

$current_page = 'referral_history';

// Check if the user is a branch manager
if ($_SESSION['role'] != 'branchManager') {
    header('Location: unauthorized.php');
    exit;
}
// Get filter values
$selected_department = isset($_GET['department']) ? $_GET['department'] : '';
$referral_type = isset($_GET['referral_type']) ? $_GET['referral_type'] : 'all';

// Construct the query
$query = "SELECT r.request_id, r.request_type, r.summary_notes, r.is_external,
                 p.first_name AS patient_fname, p.last_name AS patient_lname,
                 sd.department_name AS sending_department,
                 hd.department_name AS receiving_department,
                 ea.medical_association_name,
                 s.fname AS staff_fname, s.lname AS staff_lname
          FROM referral_form r
          LEFT JOIN patient_records p ON r.patient_id = p.patient_id
          LEFT JOIN hospital_branches sd ON r.sending_department_id = sd.hospital_department_id
          LEFT JOIN hospital_branches hd ON r.hospital_department_id = hd.hospital_department_id
          LEFT JOIN external_associations ea ON r.medical_association_id = ea.medical_association_id
          LEFT JOIN staff_records s ON r.staff_id = s.staff_id
          WHERE r.isViewed = 'Approved'";

if ($selected_department) {
    $query .= " AND r.sending_department_id = " . intval($selected_department);
}

if ($referral_type !== 'all') {
    $is_external = ($referral_type === 'external') ? 1 : 0;
    $query .= " AND r.is_external = $is_external";
}

$query .= " ORDER BY r.created_at DESC";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    $referral_data = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $referral_data = [];
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/img/favicon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/branch_theme.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>BranchManager Referral History</title>
    <style>
        .referral_table {
            width: 90%;
            border-collapse: collapse;
            margin-left: 2rem;
            margin-top: 2rem;
            margin-bottom: 2rem;
        }

        .referral_table thead {
            background-color: #001f3f;
            color: white;
        }
        
        .referral_table th, .referral_table td {
            padding: 12px;
            border: 1px solid #ddd;
        }
        
        .referral_table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .referral_table tr:hover {
            background-color: #ddd;
        }

        .scrollable-table {
            display: block;
            max-height: 535px; 
            overflow-y: auto;
        }

        .referral_history_top_container {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px;
            width: 100%;
        }

        .referral_history_top_container form {
            display: flex;
            align-items: center;
        }

        .referral_history_top_container select {
            appearance: none;
            width: 200px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #f9f9f9;
            font-size: 16px;
            color: #333;
            cursor: pointer;
        }

        .referral_history_top_container select:hover {
            background-color: #e6e6e6;
        }

        .referral_history_top_container label {
            margin-right: 10px;
            font-weight: bold;
            color: #063478;
        }

    .filter-container {
        display: flex;
        margin-bottom: 20px;
        justify-content: center;
        align-items: center;
        width: 100%;
    }

    .filter-container select {
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color: #f9f9f9;
        margin-right: 10px;
    }

    .filter-container button {
        padding: 10px 15px;
        font-size: 16px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .filter-container button:hover {
        background-color: #45a049;
    }
</style>


</head>
<body>
    <div class="container">
        <?php include("../common/branch_sidebar.php"); ?>
        <div class="main-content">
            <?php include("../common/branch_navbar.php"); ?>
            <div class="inside-content">
                <section class="referral_history_section" id='referral_history'>
                    <h2 class="page_title">Referral History:</h2>

                    <div class="filter-container">
                        <select id="departmentFilter" name="department" onchange="applyFilters()">
                            <option value="">All Departments</option>
                            <?php
                            $dept_query = "SELECT hospital_department_id, department_name FROM hospital_branches";
                            $dept_result = $conn->query($dept_query);
                            while ($row = $dept_result->fetch_assoc()) {
                                $selected = (isset($_GET['department']) && $row['hospital_department_id'] == $_GET['department']) ? 'selected' : '';
                                echo "<option value='" . $row['hospital_department_id'] . "' $selected>" . $row['department_name'] . "</option>";
                            }
                            ?>
                        </select>
                        <select id="referralTypeFilter" name="referral_type" onchange="applyFilters()">
                            <option value="all" <?php echo $referral_type == 'all' ? 'selected' : ''; ?>>All Referrals</option>
                            <option value="internal" <?php echo $referral_type == 'internal' ? 'selected' : ''; ?>>Internal</option>
                            <option value="external" <?php echo $referral_type == 'external' ? 'selected' : ''; ?>>External</option>
                        </select>
                    </div>

                    <div class="scrollable-table">
                        <table class="referral_table">
                            <thead>
                                <tr>
                                    
                                    <th>Patient Name</th>
                                    <th>Request Type</th>
                                    <th>Summary Notes</th>
                                    <th>Referring Department</th>
                                    <th>Receiving Department/Facility</th>
                                    <th>Referring Staff</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                foreach ($referral_data as $referral) {
                                    echo "<tr>";
                                    echo "<td>" . $referral['patient_fname'] . " " . $referral['patient_lname'] . "</td>";
                                    echo "<td>" . $referral['request_type'] . "</td>";
                                    echo "<td>" . $referral['summary_notes'] . "</td>";
                                    echo "<td>" . $referral['sending_department'] . "</td>";
                                    echo "<td>" . ($referral['is_external'] ? $referral['medical_association_name'] : $referral['receiving_department']) . "</td>";
                                    echo "<td>" . $referral['staff_fname'] . " " . $referral['staff_lname'] . "</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <script>
        function applyFilters() {
            var department = document.getElementById('departmentFilter').value;
            var referralType = document.getElementById('referralTypeFilter').value;
            window.location.href = '?department=' + department + '&referral_type=' + referralType;
     }
</script>
</body>
</html>