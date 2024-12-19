<?php
session_start();
include '../connection/connection.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form inputs
    $first_name = htmlspecialchars($_POST['first_name']);
    $last_name = htmlspecialchars($_POST['last_name']);
    $staff_id = htmlspecialchars($_POST['staff_id']);
    $role = htmlspecialchars($_POST['role']);
    $department_id = intval($_POST['hospital_department_id']);
    $issue_type = htmlspecialchars($_POST['issue_type']);
    $notes = htmlspecialchars($_POST['notes']);
    $urgency_type = htmlspecialchars($_POST['urgency_type']); // low, medium, high

    // SQL query to insert the data into the problems table
    $query = "INSERT INTO problems (staff_fname, staff_lname, staff_id, staff_role, hospital_department_id, problem_catagory, problem_description, isUrgent, problem_status) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Pending')";

    $stmt = $conn->prepare($query);
    $stmt->bind_param(
        "sssissss",
        $first_name,
        $last_name,
        $staff_id,
        $role,
        $department_id,
        $issue_type,
        $notes,
        $urgency_type // This should correctly insert the values (low, medium, high)
    );

    if ($stmt->execute()) {
        header("Location: report_problem.php");
        exit;
    } else {
        // Handle errors and display a message
        echo "Error submitting the problem: " . $conn->error;
    }
}
?>
