<?php
session_start();

// Check if the user is an admin
if ($_SESSION['role'] != 'gp') {
    header('Location: unauthorized.php');
    exit;
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
            width: 93%;
            border-collapse: collapse;
            margin: 2rem;
        }

        .appointment_table thead {
            background-color: #001f3f;
            color: white;
        }

        .appointment_table th, .appointment_table td {
            padding: 12px;
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
            width: 300px;
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
                                <h5><i class="ri-currency-fill"></i>Appointments Done</h5>
                                <h6>10</h6>
                            </div>
                            <div class="count-box">
                                <h5><i class="ri-user-fill"></i>Appointments Pending</h5>
                                <h6>1,200</h6>
                            </div>
                            <div class="count-box">
                                <h5><i class="ri-hospital-line"></i>Appointments</h5>
                                <h6>18</h6>
                            </div>
                            <div class="count-box">
                                <h5><i class="ri-user-fill"></i>Total Patients</h5>
                                <h6>1,200</h6>
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
                                    <button class="big-button" onclick="window.location.href='staff_staff_hub.php'">
                                        <i class="ri-group-2-fill"></i> Staff Hub
                                    </button>
                                    <button class="big-button" onclick="window.location.href='staff_patient_records.php'">
                                        <i class="ri-user-fill"></i> Patient Records
                                    </button>
                                    <button class="big-button" onclick="window.location.href='staff_patient_records.php'">
                                        <i class="ri-hospital-fill"></i> Manager Approval
                                    </button>
                                    <button class="big-button" onclick="window.location.href='staff_settings.php'">
                                        <i class="bx bxs-cog"></i> Settings
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Appointment Table -->
                    <div class="graph-container">
                        <!-- Left Graph: Appointments per Month -->
                        <div class="scrollable-table">
                        <table class="appointment_table">
                            <thead>
                                <tr>
                                    <th>Patient Name</th>
                                    <th>Time</th>
                                    <th>Appointment Type</th>
                                    <th>Notes</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Sample Data -->
                                <?php
                                $appointments = [
                                    ["3001", "Paracetamol", "Painkiller", "Headache, Dizziness"],
                                    ["3002", "Amoxicillin", "Antibiotic", "Nausea, Diarrhea"],
                                    ["3003", "Ibuprofen", "Painkiller", "Stomach upset, Dizziness"],
                                    ["3004", "Loratadine", "Antihistamine", "Dry mouth, Drowsiness"],
                                    ["3005", "Aspirin", "Painkiller", "Gastric discomfort, Nausea"],
                                    ["3006", "Metformin", "Antidiabetic", "Stomach upset, Lactic acidosis"],
                                    ["3007", "Salbutamol", "Bronchodilator", "Shaky hands, Increased heart rate"],
                                    ["3008", "Omeprazole", "Proton pump inhibitor", "Headache, Diarrhea"],
                                    ["3009", "Warfarin", "Anticoagulant", "Bleeding, Bruising"],
                                ];
                                foreach ($appointments as $appointment) {
                                    echo "<tr>
                                        <td>{$appointment[0]}</td>
                                        <td>{$appointment[1]}</td>
                                        <td>{$appointment[2]}</td>
                                        <td>{$appointment[3]}</td>
                                        <td><button class='edit-button'>Edit</button></td>
                                    </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                        </div>

                        <!-- Right Graph: Revenue per Quarter -->
                        <div class="announcement_box">
                            <h5>Announcements</h5>
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
