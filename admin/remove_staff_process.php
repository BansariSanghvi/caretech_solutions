<?php
include("../connection/connection.php"); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data 
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $staff_id = $_POST['staff_id'];
    // Check if reason_to_leave are set
    $reason_to_leave = isset($_POST['reason_to_leave']) ? $_POST['reason_to_leave'] : ''; 
    
    // Prepare and execute the SQL query to update the staff member
    $sql = "UPDATE staff_records 
            SET fname = ?, lname = ?, isActive = 0, reasonToLeave = ?, hospital_id = NULL, hospital_department_id = NULL 
            WHERE staff_id = ?"; 

    // Create a prepared statement
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind parameters

    $stmt->bind_param("sssi", $first_name, $last_name, $reason_to_leave, $staff_id);

    // Execute the query
    if ($stmt->execute()) {
        echo "Staff member updated successfully!";
        header("Location: ../admin/staff_hub.php"); // Redirect to another page
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
