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

        .add_btn{
            background-color: #4CAF50; 
            color: white;
            padding: 5px 10px;
            border: none;
            font-size: 14px;
            border-radius: 4px;
            margin-left: 30px;
        }

        .remove_btn{
            background-color: #4CAF50; 
            color: white;
            padding: 5px 10px;
            border: none;
            font-size: 14px;
            border-radius: 4px;
        }

        .upload_btn {
            background-color: #ff5733; 
            color: white;
            padding: 5px 10px;
            border: none;
            font-size: 14px;
            border-radius: 4px;
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
                            <div class="add_box">
                                <button class = "add_btn" onclick="window.location.href='add_branchPatients.php'"><i class="ri-user-add-line"></i>   Add Patient</button>
                            </div>
                            <div class="remove_box">
                                <button class="remove_btn" onclick="window.location.href='remove_branchPatients.php'"><i class='bx bxs-minus-square'></i> Remove Patient</button>
                            </div>

                            <div class="upload_box">
                                <button class="upload_btn" onclick="window.location.href='upload_branchPatients.php'"><i class="ri-file-upload-fill"></i> Upload CVS File</button>
                            </div>

                            </div>
                                <div class="search_filter">
                                <i class="ri-search-line"></i>  
                                <input type="text" placeholder="search">
                            </div>
            </div>

                   
            <?php 
                    $query = "SELECT patient_id, first_name, last_name, email, phone_no, date_of_birth, emergency_contact, emergency_contact_name 
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
                                    <th>ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>DOB</th>
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
                                    echo "<td>" . $patient['first_name'] . "</td>";
                                    echo "<td>" . $patient['last_name'] . "</td>";
                                    echo "<td>" . $patient['email'] . "</td>";
                                    echo "<td>" . $patient['date_of_birth'] . "</td>";
                                    echo "<td>" . $patient['phone_no'] . "</td>";
                                    echo "<td>" . $patient['emergency_contact'] . "</td>";
                                    echo "<td>" . $patient['emergency_contact_name'] . "</td>";
                                    echo "<td><a href='edit_patient.php?id=" . $patient['patient_id'] . "' class='edit-button'>View</a></td>";
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
