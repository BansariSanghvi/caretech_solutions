<?php
session_start();

// Check if the user is an admin
if ($_SESSION['role'] != 'staff') {
    header('Location: unauthorized.php');
    exit;
}

include '../connection/connection.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch Total Staff
$staffQuery = "SELECT COUNT(*) AS total FROM staff_records;"; 
$staffResult = $conn->query($staffQuery);
if ($staffResult->num_rows > 0) {
    $row = $staffResult->fetch_assoc();
    $totalStaff = $row['total'];
}

// Fetch Total appointments
$appointmentsQuery = "SELECT COUNT(*) AS total FROM appointments"; 
$appointmentsResult = $conn->query($appointmentsQuery);
if ($appointmentsResult->num_rows > 0) {
    $row = $appointmentsResult->fetch_assoc();
    $totalAppointments = $row['total'];
}

// Fetch Total Patients
$patientsQuery = "SELECT COUNT(*) AS total FROM patient_records"; 
$patientsResult = $conn->query($patientsQuery);
if ($patientsResult->num_rows > 0) {
    $row = $patientsResult->fetch_assoc();
    $totalPatients = $row['total'];
}

// Fetch Total Referrals
$referralsQuery = "SELECT COUNT(*) AS total FROM referral_form WHERE isViewed = 'Pending'"; 
$referralsResult = $conn->query($referralsQuery);
if ($referralsResult->num_rows > 0) {
    $row = $referralsResult->fetch_assoc();
    $totalReferrals = $row['total'];
}

// Fetch Announcements
$announcementQuery = "SELECT announcement_description FROM announcements;"; 
$announcementResult = $conn->query($announcementQuery);
$announcements = []; // Array to store the announcement descriptions

if ($announcementResult->num_rows > 0) {
    while ($row = $announcementResult->fetch_assoc()) {
        $announcements[] = $row['announcement_description']; // Collect each announcement description
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
    <link rel="stylesheet" href="../css/main_theme.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Staff Dashboard</title>

    <style>
        /* General Styles */
        .container-fluid {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .count-box {
            background-color: #ffffff;
            padding: 5px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            height: 120px;
            width: 265px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .count-box:hover {
            transform: translateY(-5px); 
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
        }

        .count-box h5 i {
            font-size: 24px;
            color: #4a90e2; 
            margin-right: 8px;
            vertical-align: middle;
        }

        .count-box h5 {
            font-size: 18px;
            color: #333;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .count-box h6 {
            font-size: 24px;
            font-weight: 700;
            color: #27ae60;
        }

        /* Quick Actions Styles */
        .card-header {
            background-color: #063478;
            color: white;
            text-align: center;
            font-weight: bold;
            height: 30px;
        }

        .tag-container {
            display: flex;
            flex-wrap: wrap;
            height: 80px;
            padding: 10px;
            justify-content: space-between;
            background-color: white;
        }

        .big-button {
            font-size: 16px;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: white;
            border: none;
            padding: 10px 20px;
            margin: 5px;
            transition: transform 0.3s ease;
        }

        .big-button:hover {
            transform: scale(1.05);
            background-color: #f1f1f1;
        }

        .big-button i {
            margin-right: 8px;
            font-size: 20px;
        }

        .graph-container {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin: 5px 0px;
            height: 320px;
        }

        .graph-container .graph {
            flex: 1;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        canvas {
            width: 100% !important;
            height: 260px !important;
        }

        .appointment_table {
            width: 100%;
            border-collapse: collapse;
            margin: 2rem;
        }

        .appointment_table thead {
            background-color: #001f3f;
            color: white;
        }

        .appointment_table th, .appointment_table td {
            padding: 30px;
            border: 1px solid #ddd;
        }

        .appointment_table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .appointment_table tr:hover {
            background-color: #ddd;
        }

        .edit-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 4px;
        }

        .scrollable-table {
            max-height: 250px; 
            overflow-y: auto;
        }

        .staff_hub_top_container {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
        }

        .buttons-container {
            display: flex;
            gap: 10px;
        }

        .search_filter {
            display: flex;
            align-items: center;
            margin-right: 100px;
            gap: 5px;
        }

        .search_filter input {
            padding: 5px 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .search_filter i {
            color: #888;
            font-size: 20px;
        }
        .announcement_box {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            height: 250px;
            width: 550px;
            margin-right: 25px;
        }
    </style>

    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <!-- Side Menu -->
        <?php include("../common/staff_sidebar.php"); ?>

        <!-- Main Content -->
        <div class="main-content">
            <?php include("../common/staff_navbar.php"); ?>

            <!-- Dashboard Section -->
            <div class="inside-content">
                <section class="dashboard_section" id="dashboard">
                    <h2 class="page_title">Dashboard:</h2>
                    
                    <!-- Top Metrics -->
                    <div class="container-fluid">
                        <div class="row">
                            <!-- Metric Boxes -->
                            <div class="count-box">
                                <h5><i class='bx bx-street-view'></i>Total Staff</h5>
                                <h6><?php echo $totalStaff ?></h6>
                            </div>
                            <div class="count-box">
                                <h5><i class='bx bx-clipboard'></i>Pending Referrals</h5>
                                <h6><?php echo $totalReferrals ?></h6>
                            </div>
                            <div class="count-box">
                                <h5><i class="ri-hospital-line"></i>Appointments</h5>
                                <h6><?php echo $totalAppointments ?></h6>
                            </div>
                            <div class="count-box">
                                <h5><i class="ri-user-fill"></i>Total Patients</h5>
                                <h6><?php echo $totalPatients ?></h6>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions Tab -->
                    <div class="container-fluid">
                        <div class="card">
                            <div class="card-header">Quick Actions</div>
                            <div class="card-body">
                                <div class="tag-container">
                                    <button class="big-button" onclick="window.location.href='staff_forms.php'">
                                        <i class="ri-folder-4-fill"></i> Forms
                                    </button>
                                    <button class="big-button" onclick="window.location.href='staff_staffhub.php'">
                                        <i class="ri-group-2-fill"></i> Staff Hub
                                    </button>
                                    <button class="big-button" onclick="window.location.href='staff_patient_records.php'">
                                        <i class="ri-user-fill"></i> Patient Records
                                    </button>
                                    <button class="big-button" onclick="window.location.href='staff_request_form.php'">
                                        <i class="ri-hospital-fill"></i> Equipment Requests
                                    </button>
                                    <button class="big-button" onclick="window.location.href='staff_settings.php'">
                                        <i class="bx bxs-cog"></i> Settings
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php 
                    $query = "SELECT appointment_id, appointment_date, appointment_time
                              FROM appointments";
                    
                    $result = $conn->query($query);

                    // Check if there are any records
                    if ($result->num_rows > 0) {
                        $appointment_data = $result->fetch_all(MYSQLI_ASSOC); // Fetch all rows as associative array
                    } else {
                        $appointment_data = []; // No records found
                    }
                    ?>
                    
                    <!-- Appointment Table -->
                    <div class="graph-container">
                        <!-- Left Graph: Appointments per Month -->
                        <div class="scrollable-table">
                        <table class="appointment_table">
                            <thead>
                                <tr>
                                    <th>Patient ID</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Loop through patient data and display it in the table
                                foreach ($appointment_data as $appointment) {
                                    echo "<tr>";
                                    echo "<td>" . $appointment['appointment_id'] . "</td>";
                                    echo "<td>" . $appointment['appointment_date'] . "</td>";
                                    echo "<td>" . $appointment['appointment_time'] . "</td>";
                                    echo "<td><a href='edit_patient.php?id=" . $appointment['appointment_id'] . "' class='edit-button'>View</a></td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                        </div>

                        <!-- Right: Announcements-->
                        <div class="announcement_box">
                            <h5>Announcements</h5>
                            <?php
                            // Display Announcements
                            if (!empty($announcements)) {
                                foreach ($announcements as $announcement) {
                                    echo "<p>$announcement</p>"; // Display each announcement in a paragraph
                                }
                            } else {
                                echo "<p>No announcements available.</p>";
                            }
                            ?>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <script>
        // JavaScript for Chart.js or other interactive elements goes here
    </script>
</body>
</html>