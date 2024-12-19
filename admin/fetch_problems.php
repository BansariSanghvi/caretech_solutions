<?php
session_start();

include '../connection/connection.php';

// Ensure the user is an admin
if ($_SESSION['role'] != 'admin') {
    echo "Unauthorized access!";
    exit;
}

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
    echo "Error in query execution: " . $conn->error;
    exit;
}

// Generate the table body
if ($result->num_rows > 0) {
    while ($prob = $result->fetch_assoc()) {
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
} else {
    echo "<tr><td colspan='6'>No problems found.</td></tr>";
}
?>
