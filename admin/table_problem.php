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
    <title>Problems</title>

    <style>
        .staff_table {
            width: 93%;
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

        .problems_top_container {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
        }

        .search_filter {
            display: flex;
            align-items: center;
            margin-right: 100px;
            gap: 5px; /* Space between the icon and input */
        }

        .search_filter select {
            padding: 5px 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .search_filter label {
            margin-left: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Side Menu -->
        <?php include("../common/sidebar.php"); ?>

        <!-- Header -->
        <div class="main-content">
            <?php include("../common/navbar.php"); ?>

            <!-- Dashboard Section -->
            <div class="inside-content">
                <section class="referal_section" id='referal_hub'>
                    <h2 class="page_title">Table of Problems:</h2>

                    <div class="problems_top_container">
                        <div class="search_filter">
                            <form method="GET" action="">
                                <label for="department">Filter by Department:</label>
                                <select name="department" id="department" onchange="this.form.submit()">
                                    <option value="">All Departments</option>
                                    <?php
                                    // Fetch all departments
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
                    // Build query for problems table
                    $query = "SELECT 
                                problems.problem_id, 
                                problems.problem_catagory, 
                                problems.problem_description, 
                                problems.hospital_department_id AS problem_department_id, 
                                hospital_branches.department_name, 
                                problems.problem_status,
                                problems.isUrgent
                            FROM 
                                problems 
                            INNER JOIN 
                                hospital_branches 
                            ON 
                                problems.hospital_department_id = hospital_branches.hospital_department_id";

                    // Apply filter if a department is selected
                    if (!empty($_GET['department'])) {
                        $selected_department = intval($_GET['department']);
                        $query .= " WHERE problems.hospital_department_id = $selected_department";
                    }

                    $result = $conn->query($query);

                    // Check if query execution was successful
                    if ($result === false) {
                        die("Error in query execution: " . $conn->error);
                    }

                    // Fetch records if available
                    $problem_data = ($result->num_rows > 0) ? $result->fetch_all(MYSQLI_ASSOC) : [];
                    ?>

                    <div class="scrollable-table">
                        <table class="staff_table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Issue Type</th>
                                    <th>Issue Description</th>
                                    <th>Department</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($problem_data as $prob) {
                                    echo "<tr";
                                    if ($prob['isUrgent'] === 'High') {
                                        echo " style='background-color: #ba0a0a; color: white;'";
                                    }
                                    echo ">";
                                    echo "<td>" . $prob['problem_id'] . "</td>";
                                    echo "<td>" . $prob['problem_catagory'] . "</td>";
                                    echo "<td>" . $prob['problem_description'] . "</td>";
                                    echo "<td>" . $prob['department_name'] . "</td>";
                                    echo "<td>" . $prob['problem_status'] . "</td>";
                                    echo "<td><a href='update_status.php?id=" . $prob['problem_id'] . "' class='edit-button'>Update</a></td>";
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
