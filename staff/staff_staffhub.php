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
    <title>Staff Hub</title>

    <style>
/* Your existing styles */
.staff_table {
    width: 90%;
    border-collapse: collapse;
    margin-left: 2rem;
    margin-top: 2rem;
    margin-bottom: 2rem;
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

.staff_hub_top_container {
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

.add_staff_btn {
    background-color: #4CAF50;
    color: white;
    padding: 5px 10px;
    border: none;
    font-size: 14px;
    border-radius: 4px;
    margin-left: 30px;
}

.remove_staff_btn {
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
        <!-------------------- Side Menu ------------------>
        <?php include("../common/staff_sidebar.php"); ?>

        <!------------------- Header ------------------->
        <div class="main-content">
            <?php include("../common/staff_navbar.php"); ?>

            <!------------------ Dashboard Section ------------------>
            <div class="inside-content">
                <section class="staff_hub_section" id="staff_hub">
                    <h2 class="page_title">Staff Hub:</h2>

                    <div class="staff_hub_top_container">
                        <div class="search_filter">
                            <i class="ri-search-line"></i>
                            <input type="text" placeholder="Search">
                        </div>
                    </div> <!-- End of staff_hub_top_container -->

                    <?php 
                    $query = "SELECT staff_id, fname, lname, email, staff_phone_no, email, role, department FROM staff_records";
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
                                    echo "<td>" . $staff['department'] . "</td>";
                                    echo "<td><a href='edit_staff.php?id=" . $staff['staff_id'] . "' class='edit-button'>Edit</a></td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div> <!-- End of scrollable-table -->
                </section> <!-- End of staff_hub_section -->
            </div> <!-- End of inside-content -->
        </div> <!-- End of main-content -->
    </div> <!-- End of container -->

    <script src="assets/js/main.js"></script>
</body>
</html>
