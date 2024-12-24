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
            user_requests.request_id,
            user_requests.staff_id,
            user_requests.staff_email,
            user_requests.hospital_department_id,
            hospital_branches.department_name, 
            user_requests.request_status
        FROM 
            user_requests 
        INNER JOIN 
            hospital_branches 
        ON 
            user_requests.hospital_department_id = hospital_branches.hospital_department_id";

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
        echo "<tr>";
        echo "<td>" . $prob['request_id'] . "</td>";
        echo "<td>" . $prob['staff_id'] . "</td>";
        echo "<td>" . $prob['problem_description'] . "</td>";
        echo "<td>" . $prob['department_name'] . "</td>";
        echo "<td>" . $prob['request_status'] . "</td>";
        echo "<td><a href='update_request.php?id=" . $prob['problem_id'] . "' class='edit-button'>Update</a></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6'>No Requests found.</td></tr>";
}
?>
