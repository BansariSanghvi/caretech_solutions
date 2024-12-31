<?php
session_start();
include("../connection/connection.php");

// Check if the form was submitted via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $user_id = $_POST['userID']; // Assuming user_id is stored in the session
    $equipment_ID = $_POST['equipment'];
    $approval_qty = $_POST['quantity'];
    $hospital_department_id = $_POST['department'];
    $approval_description = $_POST['description'];

    // Insert data into the approvals table
    $query = "INSERT INTO approvals (user_id, hospital_department_id, equipment_ID, approval_qty, approval_description)
              VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iiiss", $user_id, $hospital_department_id, $equipment_ID, $approval_qty, $approval_description);

    // Execute the query and check for success
    if ($stmt->execute()) {
        echo "<script>
                alert('Approval request submitted successfully!');
                window.location.href = 'staff_request_form.php';
              </script>";
    } else {
        echo "<script>
                alert('Error: Could not submit the approval request. Please try again.');
                window.history.back();
              </script>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    header("Location: staff_request_form.php");
    exit;
}
?>
