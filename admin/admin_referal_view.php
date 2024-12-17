<?php
session_start();

// Check if the user is an admin
if ($_SESSION['role'] != 'admin') {
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
    <title>Referals</title>

    <style>
.staff_table {
    width: 93%;
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

.referal_top_container {
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

.add_supplier_btn{
    background-color: #4CAF50; 
    color: white;
    padding: 5px 10px;
    border: none;
    font-size: 14px;
    border-radius: 4px;
    margin-left: 30px;
}

.remove_supplier_btn{
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
        <?php include("../common/sidebar.php"); ?>

        <!-------------------Header------------------->
        <div class="main-content">
            <?php include("../common/navbar.php"); ?>

            <!------------------Dashboard Section------------------>
            <div class="inside-content">
                <section class="providers_section" id='supplier_hub'>
                    <h2 class="page_title">Patient Referals:</h2>

                    <div class="referal_top_container">
                        <div class="buttons-container">
                            <div class="add_staff_box">
                                <button class="add_supplier_btn" onclick="window.location.href='add_referal.php'">
                                    <i class="ri-user-add-line"></i> Add Referal
                                </button>
                            </div>
                        </div>

                        <div class="search_filter">
                            <form method="GET" action="">
                                <label for="department">Filter by Department:</label>
                                <select name="department" id="department" onchange="this.form.submit()">
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
                            </form>
                        </div>
                    </div>

                    <?php
                    // Filtering logic
                    $where_clause = "";
                    if (isset($_GET['department']) && !empty($_GET['department'])) {
                        $department_id = $conn->real_escape_string($_GET['department']);
                        $where_clause = " WHERE hospital_branches.hospital_department_id = '$department_id'";
                    }

                    $query = "SELECT 
                                referal_form.request_id, 
                                referal_form.patient_id, 
                                referal_form.request_type, 
                                referal_form.hospital_department_id, 
                                hospital_branches.department_name, 
                                referal_form.medical_association_id, 
                                external_associations.medical_association_name, 
                                referal_form.isViewed 
                              FROM 
                                referal_form 
                              INNER JOIN 
                                hospital_branches 
                              ON 
                                referal_form.hospital_department_id = hospital_branches.hospital_department_id 
                              INNER JOIN 
                                external_associations 
                              ON 
                                referal_form.medical_association_id = external_associations.medical_association_id" 
                              . $where_clause;

                    $result = $conn->query($query);

                    // Fetch records
                    $ref_data = ($result->num_rows > 0) ? $result->fetch_all(MYSQLI_ASSOC) : [];
                    ?>

                    <div class="scrollable-table">
                        <table class="staff_table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Patient ID</th>
                                    <th>Type</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($ref_data as $ref) {
                                    echo "<tr";
                                    if ($ref['department_name'] === 'Emergency') {
                                        echo " style='background-color: #ba0a0a; color: white;'";
                                    }
                                    echo ">";
                                    echo "<td>" . $ref['request_id'] . "</td>";
                                    echo "<td>" . $ref['patient_id'] . "</td>";
                                    echo "<td>" . $ref['request_type'] . "</td>";
                                    echo "<td>" . $ref['medical_association_name'] . "</td>";
                                    echo "<td>" . $ref['department_name'] . "</td>";
                                    echo "<td>" . $ref['isViewed'] . "</td>";
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

    <script src="assets/js/main.js"></script>
</body>
</html>
