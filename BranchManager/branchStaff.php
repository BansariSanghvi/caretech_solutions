<?php
session_start();

include '../connection/connection.php';

$current_page = 'staff';

// Check if the user is an branch manager
if ($_SESSION['role'] != 'branchManager') {
    header('Location: unauthorized.php');
    exit;
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
    <title>BranchManager Staff Hub</title>
</head>
<style>
.staff_table {
    width: 90%;
    border-collapse: collapse;
    margin-left: 2rem;
    margin-top:2rem;
    margin-bottom: 2rem
}

.staff_table thead {
    background-color: #001f3f; /* Dark navy blue */
    color: white; /* White text */
}
        
.staff_table th, .staff_table td {
    padding: 12px;
    border: 1px solid #ddd;
}
        
.staff_table tr:nth-child(even) {
    background-color: #f2f2f2;
}

.staff_table tr:hover {
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

.add_staff_btn{
    background-color: #4CAF50; 
    color: white;
    padding: 5px 10px;
    border: none;
    font-size: 14px;
    border-radius: 4px;
    margin-left: 30px;
}

.remove_staff_btn{
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

.staff_hub_top_container {
    margin-top: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 10px;
    width 100%;
}

.staff_hub_top_container form {
    display: flex; /* Flexbox for form elements */
    align-items: center; /* Center items vertically */
}

.staff_hub_top_container select {
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

.staff_hub_top_container select:hover {
    background-color: #e6e6e6;
}

.staff_hub_top_container label {
    margin-right: 10px;
    font-weight: bold;
    color: #063478;
}


        
       
</style>
<body>
    <div class="container">
      <!--------------------Side Menu------------ -->
         <!--------------------Side Menu------------ -->
      <?php  include("../common/branch_sidebar.php"); ?>

<!-------------------Header------------------->
<div class="main-content">
    
<?php  include("../common/branch_navbar.php"); ?>
            <!------------------Staff Section------------------>
            <div class="inside-content">
                <section class="staff_hub_section" id='staff_hub'>
                    <h2 class="page_title">Staff Hub:</h2>

                    <div class="staff_hub_top_container">
    <form method="GET" action="">
        <label for="department">Filter by Department:</label>
        <select name="department" id="department" onchange="this.form.submit()">
            <option value="">All Departments</option>
            <?php
            $dept_query = "SELECT hospital_department_id, department_name FROM hospital_branches";
            $dept_result = $conn->query($dept_query);
            while ($row = $dept_result->fetch_assoc()) {
                $selected = ($row['hospital_department_id'] == $_GET['department']) ? 'selected' : '';
                echo "<option value='" . $row['hospital_department_id'] . "' $selected>" . $row['department_name'] . "</option>";
            }
            ?>
        </select>
    </form>
</div>
                   

            <?php 
                $selected_department = isset($_GET['department']) ? $_GET['department'] : '';

                $query = "SELECT staff_id, fname, lname, email, staff_phone_no, role, department_name 
                        FROM staff_records 
                        JOIN hospital_branches ON staff_records.hospital_department_id = hospital_branches.hospital_department_id 
                        WHERE isActive = 1";

                if ($selected_department) {
                    $query .= " AND staff_records.hospital_department_id = " . intval($selected_department);
                }

                $result = $conn->query($query);
                   
                   // Check if there are any records
                   if ($result->num_rows > 0) {
                       $staff_data = $result->fetch_all(MYSQLI_ASSOC); // Fetch all rows as associative array
                   } else {
                       $staff_data = []; // No records found
                   }
                   ?>

                    <div class="scrollable-table">
                    <table class="staff_table">
                    <thead>
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Department</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            // Loop through staff data and display it in the table
                            foreach ($staff_data as $staff) {
                                echo "<tr>";
                                echo "<td>" . $staff['staff_id'] . "</td>";
                                echo "<td>" . $staff['fname'] . "</td>";
                                echo "<td>" . $staff['lname'] . "</td>";
                                echo "<td>" . $staff['email'] . "</td>";
                                echo "<td>" . $staff['staff_phone_no'] . "</td>";
                                echo "<td>" . $staff['role'] . "</td>";
                                echo "<td>" . $staff['department_name'] . "</td>";
                                echo "<td><a href='edit_staff.php?id=" . $staff['staff_id'] . "' class='edit-button'>Edit</a></td>";
                                echo "</tr>";
                            }
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </section>
                        
            </div>
        </div>
    </div>
</div>

    <script src="assets/js/main.js"></script>
</body>
</html>
