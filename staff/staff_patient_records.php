<?php
session_start();

// Check if the user is an admin
if ($_SESSION['role'] != 'gp') {
    header('Location: unauthorized.php');
    exit;
}

include '../connection/connection.php';

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
    <title>Patient Records</title>

    <style>
/* Your existing styles */
.patient_table {
    width: 90%;
    border-collapse: collapse;
    margin-left: 2rem;
    margin-top: 2rem;
    margin-bottom: 2rem;
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

.patient_hub_top_container {
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
        <!-------------------- Side Menu ------------ -->
        <?php include("../common/staff_sidebar.php"); ?>

        <!------------------- Header ------------------->
        <div class="main-content">
            <?php include("../common/staff_navbar.php"); ?>

            <!------------------ Dashboard Section ------------------>
            <div class="inside-content">
                <section class="patient_records_section" id="patient_hub">
                    <h2 class="page_title">Patient Records:</h2>

                    <div class="patient_records_b_top_container">
                        <div class="buttons-container">
                            <!-- Add buttons if needed -->
                        </div>
                        <div class="search_filter">
                            <i class="ri-search-line"></i>
                            <input type="text" placeholder="Search">
                        </div>
                    </div> <!-- End of patient_records_b_top_container -->

                    <?php 
                    $query = "SELECT patient_id, firstName, lastName, email, phone_no, dateOfBirth, emergency_contact, emergency_contact_name 
                              FROM patient_records";
                    $result = $conn->query($query);

                    // Check if there are any records
                    if ($result->num_rows > 0) {
                        $patient_data = $result->fetch_all(MYSQLI_ASSOC); // Fetch all rows as associative array
                    } else {
                        $patient_data = []; // No records found
                    }
                    ?>

                    <div class="scrollable-table">
                        <table class="patient_table">
                            <thead>
                                <tr>
                                    <th>Patient ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Date Of Birth</th>
                                    <th>Contact No</th>
                                    <th>Emergency Contact No</th>
                                    <th>Emergency Contact Name</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                // Loop through patient data and display it in the table
                                foreach ($patient_data as $patient) {
                                    echo "<tr>";
                                    echo "<td>" . $patient['patient_id'] . "</td>";
                                    echo "<td>" . $patient['firstName'] . "</td>";
                                    echo "<td>" . $patient['lastName'] . "</td>";
                                    echo "<td>" . $patient['email'] . "</td>";
                                    echo "<td>" . $patient['dateOfBirth'] . "</td>";
                                    echo "<td>" . $patient['phone_no'] . "</td>";
                                    echo "<td>" . $patient['emergency_contact'] . "</td>";
                                    echo "<td>" . $patient['emergency_contact_name'] . "</td>";
                                    echo "<td><a href='edit_patient.php?id=" . $patient['patient_id'] . "' class='edit-button'>Edit</a></td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div> <!-- End of scrollable-table -->
                </section> <!-- End of patient_records_section -->
            </div> <!-- End of inside-content -->
        </div> <!-- End of main-content -->
    </div> <!-- End of container -->

    <script src="assets/js/main.js"></script>
</body>
</html>
