<?php
session_start();

include '../connection/connection.php';

$current_page = 'patients';

// Check if the user is staff
if ($_SESSION['role'] != 'staff') {
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
    <title>BranchManager Patient Records</title>
    <style>
        .patient_table {
            width: 90%;
            border-collapse: collapse;
            margin-left: 2rem;
            margin-top:2rem;
            margin-bottom: 2rem
        }

        .patient_table thead {
            background-color: #001f3f; /* Dark navy blue */
            color: white; /* White text */
        }
                
        .patient_table th, .patient_table td {
            padding: 12px;
            border: 1px solid #ddd;
        }
                
        .patient_table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .patient_table tr:hover {
            background-color: #ddd;
        }

        .edit-button {
            background-color: #4CAF50; /* Green */
            color: white;
            border: none;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 2px 1px;
            cursor: pointer;
            border-radius: 4px;
        }

        .scrollable-table {
            display: block;
            max-height: 535px; 
            overflow-y: auto;
        }

        .top_container {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            
        }

        .buttons-container {
            display: flex;
            gap: 10px; /* Space between buttons */
        }

        .search_filter {
            display: flex;
            align-items: center;
            margin-right: 100px;
            gap: 5px; /* Space between the icon and input */
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
            
</style>
</head>
<body>
    <div class="container">
      <!--------------------Side Menu------------ -->
         <!--------------------Side Menu------------ -->
      <?php  include("../common/staff_sidebar.php"); ?>

<!-------------------Header------------------->
<div class="main-content">
    
<?php  include("../common/staff_navbar.php"); ?>
            <!------------------Patient Section------------------>
            <div class="inside-content">
                <section class="patient_records_section" id='patient_records'>
                    <h2 class="page_title">Patient Records:</h2>

                    <div class="top_container">
                        <div class="buttons-container">
                            </div>
                                <div class="search_filter">
                                <i class="ri-search-line"></i>  
                                <input type="text" placeholder="search">
                            </div>
            </div>

                   
            <?php 
            $query = "SELECT 
                        a.appointment_id, 
                        CONCAT(p.first_name, ' ', p.last_name) AS patient_name, 
                        a.appointment_time, 
                        a.appointment_type, 
                        a.notes
                    FROM appointments a
                    JOIN patient_records p ON a.patient_id = p.patient_id
                    WHERE a.isActive = 1"; // Only active appointments

            // Execute the query
            $result = $conn->query($query);

            // Check if there are any records
            if ($result->num_rows > 0) {
                $appointments = $result->fetch_all(MYSQLI_ASSOC); // Fetch all rows as associative array
            } else {
                $appointments = []; // No records found
            }
            ?>

            <div class="scrollable-table">
                <table class="appointment_table">
                    <thead>
                        <tr>
                            <th>Appointment ID</th>
                            <th>Patient Name</th>
                            <th>Appointment Time</th>
                            <th>Appointment Type</th>
                            <th>Notes</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        // Loop through the appointment data and display it in the table
                        foreach ($appointments as $appointment) {
                            echo "<tr>";
                            echo "<td>" . $appointment['appointment_id'] . "</td>";
                            echo "<td>" . $appointment['patient_name'] . "</td>";
                            echo "<td>" . $appointment['appointment_time'] . "</td>";
                            echo "<td>" . $appointment['appointment_type'] . "</td>";
                            echo "<td>" . $appointment['notes'] . "</td>";
                            echo "<td><a href='edit_appointment.php?id=" . $appointment['appointment_id'] . "' class='edit-button'>Edit</a></td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            </div>
        </div>
    </div>
</div>

    <script src="assets/js/main.js"></script>
</body>
</html>
